<?php

namespace Drupal\webform_vin_decoder\Plugin\WebformHandler;

/*
*  Written By Nabil Akdouche.
*
*  COPYRIGHT © 2025
*  ALL RIGHTS RESERVED
*
*  PERMISSION IS GRANTED TO USE, COPY, CREATE DERIVATIVE WORKS AND
*  REDISTRIBUTE THIS SOFTWARE AND SUCH DERIVATIVE WORKS FOR ANY PURPOSE, SO
*  LONG AS THE NAME  IS NOT USED IN ANY
*  ADVERTISING OR PUBLICITY PERTAINING TO THE USE OR DISTRIBUTION OF THIS
*  SOFTWARE WITHOUT SPECIFIC, WRITTEN PRIOR AUTHORIZATION.  IF THE ABOVE
*  COPYRIGHT NOTICE OR ANY OTHER IDENTIFICATION 
*  IS INCLUDED IN ANY COPY OF ANY PORTION OF THIS SOFTWARE, THEN THE
*  DISCLAIMER BELOW MUST ALSO BE INCLUDED.
*
*  THIS SOFTWARE IS PROVIDED AS IS, WITHOUT REPRESENTATION  AS TO ITS FITNESS FOR ANY PURPOSE, AND WITHOUT WARRANTY
*  OF ANY KIND, EITHER EXPRESS OR IMPLIED,
*  INCLUDING WITHOUT LIMITATION THE IMPLIED WARRANTIES OF MERCHANTABILITY
*  AND FITNESS FOR A PARTICULAR PURPOSE. SHALL NOT BE LIABLE FOR ANY DAMAGES, INCLUDING SPECIAL,
*  INDIRECT, INCIDENTAL, OR CONSEQUENTIAL DAMAGES, WITH RESPECT TO ANY CLAIM
*  ARISING OUT OF OR IN CONNECTION WITH THE USE OF THE SOFTWARE, EVEN IF IT
*  HAS BEEN OR IS HEREAFTER ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
*/

use Drupal\Core\Url;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionConditionsValidatorInterface;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformTokenManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\commerce_store\Entity\Store;
use Drupal\commerce_product\Entity\Product;
use Drupal\taxonomy\Entity\Term;
use Drupal\Core\File\FileSystemInterface;


/**
* Webform vin decoder handler.
*
* @WebformHandler(
*   id = "webform_vin_decoder",
*   label = @Translation("Look up car vin numbers"),
*   category = @Translation("Validation"),
*   description = @Translation("This looks up car vin numbers from NHTSA."),
*   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
*   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
*   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_OPTIONAL,
* )
*/
class WebformVinDecoderWebformHandler extends WebformHandlerBase {

	/**
	* The token manager.
	*
	* @var \Drupal\webform\WebformTokenManagerInterface
	*/
	protected $tokenManager;

	/**
	* {@inheritdoc}
	*/
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		$instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
		$instance->moduleHandler = $container->get('module_handler');
		$instance->elementManager = $container->get('plugin.manager.webform.element');
		$instance->httpClient = $container->get('http_client');
		$instance->tokenManager = $container->get('webform.token_manager');
		$instance->request = $container->get('request_stack')->getCurrentRequest();
		$instance->messageManager = $container->get('webform.message_manager');
		$instance->kernel = $container->get('kernel');
		$instance->requestStack = $container->get('request_stack');
		return $instance;

	}

	/**
	* {@inheritdoc}
	*/
	public function defaultConfiguration() {
		return [];
	}


	/**
	* {@inheritdoc}
	*/

	public function validateForm(array &$form, FormStateInterface $formState, WebformSubmissionInterface $webform_submission) {

        	parent::validateForm($form, $formState, $webform_submission);

		$page = $formState->get('current_page');
		$vin = $formState->getValue('vin_number');
        	if($page == 'vin_page'){

			//$vin = '1P3EW65F4VV300946' ;
			$url = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/". $vin ."?format=json";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			$json = json_decode($result);

			$vin = $json ->SearchCriteria;
			$make =  $json ->Results[7]->Value;
			$model = $json ->Results[9]->Value;
			$year  = $json ->Results[10]->Value;
			$trim  = $json ->Results[13]->Value;
			$vehicletype = $json ->Results[14]->Value;
			$bodyclass = $json ->Results[23]->Value;
			$doors = $json ->Results[24]->Value;
			$fueltype = $json ->Results[77]->Value;


			$formState->setValue('make', $make);
			$formState->setValue('model', $model);
			$formState->setValue('year', $year);
			$formState->setValue('trim', $trim);
        	}


	}

	/**
	* {@inheritdoc}
	*/
	public function submitForm(array &$form, FormStateInterface $formState, WebformSubmissionInterface $webform_submission) {
		$this->productCreate($formState, $webform_submission);
	}

	/**
	* submit product.
	*/
	private function productCreate(FormStateInterface $formState, WebformSubmissionInterface $webform_submission) {

		$current_page = $webform_submission->getCurrentPage();
		$current_state = $webform_submission->getState();

		if($current_page != 'webform_confirmation') {
			return;
		}

		//\Drupal::logger('logName_$current_page')->warning('<pre><code>' . print_r($current_page, TRUE) . '</code></pre>');
		//\Drupal::logger('logName_$current_state')->warning('<pre><code>' . print_r($current_state, TRUE) . '</code></pre>');

		$vin = $formState->getValue('vin_number');
		$page = $formState->get('current_page');
		$make = $formState->getValue('make');
		$model = $formState->getValue('model');
		$year = $formState->getValue('year');
		$trim = $formState->getValue('trim');
                $mileage = $formState->getValue('mileage');
                $price = $formState->getValue('price');
                $desc = $formState->getValue('car_description');
                $repemail = $formState->getValue('repemail');
                $repphone = $formState->getValue('repphone');

		$vocabulary = 'make';

		$terms = \Drupal::entityTypeManager()->getStorage("taxonomy_term")->loadByProperties(["name" => $make, "vid" => $vocabulary]);
		if ($terms) {
			// Only use the first term returned; there should only be one anyways if we do this right.
			$make_term = reset($terms);
		} else {
			$make_term = Term::create([
			'name' => $make,
			'vid' => $vocabulary ,
			'parent' => array(0), //worked for the root parent
			]);
			$make_term->save();
		}
		$make_term_id = $make_term->id();


		$terms = \Drupal::entityTypeManager()->getStorage("taxonomy_term")->loadByProperties(["name" => $model, "vid" => $vocabulary]);
		if ($terms) {
			// Only use the first term returned; there should only be one anyways if we do this right.
			$model_term = reset($terms);
		} else {
			$model_term = Term::create([
			'name' => $model,
			'vid' => $vocabulary ,
			'parent' => [$make_term_id],  // parent term id.
			]);
			$model_term->save();
		}
		$model_term_id = $model_term->id();

		\Drupal::logger('logName_$model_term_id')->warning('<pre><code>' . print_r($model_term_id, TRUE) . '</code></pre>');
		$store = Store::load(1);
		$product = Product::create([
			'uid' => 1, // The user id that created the product.
			'type' => 'car', // Just like variation, the default product type is 'default'.
			'title' => $year. ' '.$make .' '.$model ,
			'stores' => [$store], // The store we created/loaded above.
			'field_make' => $model_term_id, // 6 make term id
			'field_year' => $year,
                        'field_mileage' => $mileage,
                        'field_price' => $price,
                        'body' => $desc,
                        'field_repemail' => $repemail,
                        'field_repphone' => $repphone,
			'field_vin_number' => $vin,
			]);
		$product->save();
		$product_id = $product->id();

		$car_images = $formState->getValue('car_images');

		//use Drupal\Core\File\FileSystemInterface;
		$entity_storage = \Drupal::entityTypeManager()->getStorage('commerce_product');
		$entity = $entity_storage->load($product_id); //10 is the product_id
		if (isset($car_images[0])) { $entity->field_photos[0] = ['target_id' => $car_images[0],];}
		if (isset($car_images[1])) { $entity->field_photos[1] = ['target_id' => $car_images[1],];}
		if (isset($car_images[2])) { $entity->field_photos[2] = ['target_id' => $car_images[2],];}
                if (isset($car_images[3])) { $entity->field_photos[3] = ['target_id' => $car_images[3],];}

                if (isset($car_images[4])) { $entity->field_photos[4] = ['target_id' => $car_images[4],];}
                if (isset($car_images[5])) { $entity->field_photos[5] = ['target_id' => $car_images[5],];}
                if (isset($car_images[6])) { $entity->field_photos[6] = ['target_id' => $car_images[6],];}
                if (isset($car_images[7])) { $entity->field_photos[7] = ['target_id' => $car_images[7],];}

                if (isset($car_images[8])) { $entity->field_photos[8] = ['target_id' => $car_images[8],];}
                if (isset($car_images[9])) { $entity->field_photos[9] = ['target_id' => $car_images[9],];}

		$entity->save();

	}

}
