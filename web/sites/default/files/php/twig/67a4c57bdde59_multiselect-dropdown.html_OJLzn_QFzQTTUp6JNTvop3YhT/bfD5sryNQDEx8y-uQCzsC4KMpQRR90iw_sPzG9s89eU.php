<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* modules/contrib/multiselect_dropdown/templates/multiselect-dropdown.html.twig */
class __TwigTemplate_788873be4a5e7b2b885fc92aeb5d42f1 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'toggle' => [$this, 'block_toggle'],
            'dialog' => [$this, 'block_dialog'],
            'dialog_close' => [$this, 'block_dialog_close'],
            'actions' => [$this, 'block_actions'],
            'search' => [$this, 'block_search'],
            'list' => [$this, 'block_list'],
            'children' => [$this, 'block_children'],
            'buttons' => [$this, 'block_buttons'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 51
        yield "<div";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["multiselect-dropdown"], "method", false, false, true, 51), "html", null, true);
        yield ">
  ";
        // line 52
        yield from $this->unwrap()->yieldBlock('toggle', $context, $blocks);
        // line 55
        yield "
  ";
        // line 56
        yield from $this->unwrap()->yieldBlock('dialog', $context, $blocks);
        // line 106
        yield "</div>

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "toggle_attributes", "toggle_label", "dialog_attributes", "wrapper_attributes", "close_attributes", "close_label", "select_all_label", "select_none_label", "select_all_attributes", "select_none_attributes", "search", "scroll_attributes", "list_attributes", "_self", "children", "submit_label", "clear_label", "submit_attributes", "clear_attributes", "items"]);        yield from [];
    }

    // line 52
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_toggle(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 53
        yield "    <button";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["toggle_attributes"] ?? null), "addClass", ["multiselect-dropdown__toggle", "form-select", "form-element", "form-element--type-select"], "method", false, false, true, 53), "html", null, true);
        yield ">";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["toggle_label"] ?? null), "html", null, true);
        yield "</button>
  ";
        yield from [];
    }

    // line 56
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_dialog(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 57
        yield "    <dialog";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["dialog_attributes"] ?? null), "addClass", ["multiselect-dropdown__dialog"], "method", false, false, true, 57), "html", null, true);
        yield ">
      <div";
        // line 58
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["wrapper_attributes"] ?? null), "addClass", ["multiselect-dropdown__wrapper"], "method", false, false, true, 58), "html", null, true);
        yield ">
        ";
        // line 59
        yield from $this->unwrap()->yieldBlock('dialog_close', $context, $blocks);
        // line 62
        yield "
        ";
        // line 63
        yield from $this->unwrap()->yieldBlock('actions', $context, $blocks);
        // line 75
        yield "
        ";
        // line 76
        yield from $this->unwrap()->yieldBlock('search', $context, $blocks);
        // line 79
        yield "
        ";
        // line 80
        yield from $this->unwrap()->yieldBlock('list', $context, $blocks);
        // line 90
        yield "
        ";
        // line 91
        yield from $this->unwrap()->yieldBlock('buttons', $context, $blocks);
        // line 103
        yield "      </div>
    </dialog>
  ";
        yield from [];
    }

    // line 59
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_dialog_close(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 60
        yield "          <button";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["close_attributes"] ?? null), "addClass", ["multiselect-dropdown__dialog-close"], "method", false, false, true, 60), "html", null, true);
        yield ">";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["close_label"] ?? null), "html", null, true);
        yield "</button>
        ";
        yield from [];
    }

    // line 63
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_actions(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 64
        yield "          ";
        if ((($context["select_all_label"] ?? null) || ($context["select_none_label"] ?? null))) {
            // line 65
            yield "            <div class=\"multiselect-dropdown__actions\">
              ";
            // line 66
            if (($context["select_all_label"] ?? null)) {
                // line 67
                yield "                <button";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["select_all_attributes"] ?? null), "addClass", ["multiselect-dropdown__action", "multiselect-dropdown__action--all"], "method", false, false, true, 67), "html", null, true);
                yield ">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["select_all_label"] ?? null), "html", null, true);
                yield "</button>
              ";
            }
            // line 69
            yield "              ";
            if (($context["select_none_label"] ?? null)) {
                // line 70
                yield "                <button";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["select_none_attributes"] ?? null), "addClass", ["multiselect-dropdown__action", "multiselect-dropdown__action--none"], "method", false, false, true, 70), "html", null, true);
                yield ">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["select_none_label"] ?? null), "html", null, true);
                yield "</button>
              ";
            }
            // line 72
            yield "            </div>
          ";
        }
        // line 74
        yield "        ";
        yield from [];
    }

    // line 76
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_search(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 77
        yield "          ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["search"] ?? null), "html", null, true);
        yield "
        ";
        yield from [];
    }

    // line 80
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_list(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 81
        yield "          <div";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["scroll_attributes"] ?? null), "addClass", ["multiselect-dropdown__scroll"], "method", false, false, true, 81), "html", null, true);
        yield ">
            <ul";
        // line 82
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["list_attributes"] ?? null), "addClass", ["multiselect-dropdown__list"], "method", false, false, true, 82), "html", null, true);
        yield ">
              ";
        // line 83
        yield from $this->unwrap()->yieldBlock('children', $context, $blocks);
        // line 87
        yield "            </ul>
          </div>
        ";
        yield from [];
    }

    // line 83
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_children(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 84
        yield "                ";
        $macros["self"] = $this;
        // line 85
        yield "                ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["self"]->getTemplateForMacro("macro_children", $context, 85, $this->getSourceContext())->macro_children(...[($context["children"] ?? null)]));
        yield "
              ";
        yield from [];
    }

    // line 91
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_buttons(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 92
        yield "          ";
        if ((($context["submit_label"] ?? null) || ($context["clear_label"] ?? null))) {
            // line 93
            yield "            <div class=\"multiselect-dropdown__buttons\">
              ";
            // line 94
            if (($context["submit_label"] ?? null)) {
                // line 95
                yield "                <button";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["submit_attributes"] ?? null), "addClass", ["multiselect-dropdown__button", "multiselect-dropdown__button--submit"], "method", false, false, true, 95), "html", null, true);
                yield ">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["submit_label"] ?? null), "html", null, true);
                yield "</button>
              ";
            }
            // line 97
            yield "              ";
            if (($context["clear_label"] ?? null)) {
                // line 98
                yield "                <button";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["clear_attributes"] ?? null), "addClass", ["multiselect-dropdown__button", "multiselect-dropdown__button--clear"], "method", false, false, true, 98), "html", null, true);
                yield ">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["clear_label"] ?? null), "html", null, true);
                yield "</button>
              ";
            }
            // line 100
            yield "            </div>
          ";
        }
        // line 102
        yield "        ";
        yield from [];
    }

    // line 108
    public function macro_children($items = null, ...$varargs): string|Markup
    {
        $macros = $this->macros;
        $context = [
            "items" => $items,
            "varargs" => $varargs,
        ] + $this->env->getGlobals();

        $blocks = [];

        return ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 109
            yield "  ";
            $macros["self"] = $this;
            // line 110
            yield "  ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 111
                yield "    <li class=\"multiselect-dropdown__item";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", true, true, true, 111)) {
                    yield " multiselect-dropdown__item--grouped";
                }
                yield "\">
      ";
                // line 112
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($context["item"], "below"), "html", null, true);
                yield "
      ";
                // line 113
                if (CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", true, true, true, 113)) {
                    // line 114
                    yield "        <ul class=\"multiselect-dropdown__group\">
          ";
                    // line 115
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["self"]->getTemplateForMacro("macro_children", $context, 115, $this->getSourceContext())->macro_children(...[CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 115)]));
                    yield "
        </ul>
      ";
                }
                // line 118
                yield "    </li>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/multiselect_dropdown/templates/multiselect-dropdown.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  337 => 118,  331 => 115,  328 => 114,  326 => 113,  322 => 112,  315 => 111,  310 => 110,  307 => 109,  295 => 108,  290 => 102,  286 => 100,  278 => 98,  275 => 97,  267 => 95,  265 => 94,  262 => 93,  259 => 92,  252 => 91,  244 => 85,  241 => 84,  234 => 83,  227 => 87,  225 => 83,  221 => 82,  216 => 81,  209 => 80,  201 => 77,  194 => 76,  189 => 74,  185 => 72,  177 => 70,  174 => 69,  166 => 67,  164 => 66,  161 => 65,  158 => 64,  151 => 63,  141 => 60,  134 => 59,  127 => 103,  125 => 91,  122 => 90,  120 => 80,  117 => 79,  115 => 76,  112 => 75,  110 => 63,  107 => 62,  105 => 59,  101 => 58,  96 => 57,  89 => 56,  79 => 53,  72 => 52,  64 => 106,  62 => 56,  59 => 55,  57 => 52,  52 => 51,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/multiselect_dropdown/templates/multiselect-dropdown.html.twig", "/opt/drupal/web/modules/contrib/multiselect_dropdown/templates/multiselect-dropdown.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["block" => 52, "macro" => 108, "if" => 64, "import" => 84, "for" => 110];
        static $filters = ["escape" => 51, "without" => 112];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['block', 'macro', 'if', 'import', 'for'],
                ['escape', 'without'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
