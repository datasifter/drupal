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

/* modules/contrib/imagefield_slideshow/templates/imagefield-slideshow.html.twig */
class __TwigTemplate_1b0ac5bf2604f53f2d71cb243c60b897 extends Template
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
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 16
        $context["prev"] = Twig\Extension\CoreExtension::random($this->env->getCharset());
        // line 17
        $context["next"] = Twig\Extension\CoreExtension::random($this->env->getCharset());
        // line 18
        yield "<div class=\"imagefield_slideshow-wrapper\">
    <div class=\"cycle-slideshow\"
         data-cycle-pause-on-hover='";
        // line 20
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["pause"] ?? null), "html", null, true);
        yield "'
         data-cycle-fx=\"";
        // line 21
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["effect"] ?? null), "html", null, true);
        yield "\"
         data-cycle-speed=\"";
        // line 22
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["speed"] ?? null), "html", null, true);
        yield "\"
         data-cycle-timeout=\"";
        // line 23
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["timeout"] ?? null), "html", null, true);
        yield "\"
         data-cycle-prev=\"#imagefield_slideshow-prev-";
        // line 24
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["prev"] ?? null), "html", null, true);
        yield "\"
         data-cycle-next=\"#imagefield_slideshow-next-";
        // line 25
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["next"] ?? null), "html", null, true);
        yield "\"
         data-cycle-loader=\"wait\"
         data-cycle-caption-plugin=\"caption2\"
         data-cycle-pager=\"#image-pager\"
         data-cycle-pager-template=\"\">
        ";
        // line 30
        if (($context["pager"] ?? null)) {
            // line 31
            yield "            <div class=\"cycle-pager\"></div>
        ";
        }
        // line 33
        yield "        <div class=\"cycle-overlay\"></div>
        ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["url"] ?? null));
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 35
            yield "            ";
            if (($context["link_image_to"] ?? null)) {
                // line 36
                yield "                ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["link_image_to"] ?? null), "type", [], "any", false, false, true, 36) == "content")) {
                    // line 37
                    yield "                    <img title=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 37), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "alt", [], "any", false, false, true, 37), "html", null, true);
                    yield "\" src=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "uri", [], "any", false, false, true, 37), "html", null, true);
                    yield "\" onclick=\"window.open('";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["link_image_to"] ?? null), "path", [], "any", false, false, true, 37), "html", null, true);
                    yield "', '_self')\" data-cycle-title=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 37), "html", null, true);
                    yield "\" data-cycle-desc=\"\" />
                ";
                }
                // line 39
                yield "                ";
                if ((CoreExtension::getAttribute($this->env, $this->source, ($context["link_image_to"] ?? null), "type", [], "any", false, false, true, 39) == "file")) {
                    // line 40
                    yield "                    <img title=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 40), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "alt", [], "any", false, false, true, 40), "html", null, true);
                    yield "\" src=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "uri", [], "any", false, false, true, 40), "html", null, true);
                    yield "\" onclick=\"window.open('";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "uri", [], "any", false, false, true, 40), "html", null, true);
                    yield "', '_self')\" data-cycle-title=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 40), "html", null, true);
                    yield "\" data-cycle-desc=\"\" />
                ";
                }
                // line 42
                yield "            ";
            } else {
                // line 43
                yield "                <img title=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 43), "html", null, true);
                yield "\" alt=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "alt", [], "any", false, false, true, 43), "html", null, true);
                yield "\" src=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "uri", [], "any", false, false, true, 43), "html", null, true);
                yield "\" data-cycle-title=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 43), "html", null, true);
                yield "\" data-cycle-desc=\"\" />
            ";
            }
            // line 45
            yield "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        yield "        ";
        if (($context["image_pager"] ?? null)) {
            // line 47
            yield "          <div id=\"image-pager\" class=\"cycle-pager external\">
              ";
            // line 48
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["url"] ?? null));
            foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                // line 49
                yield "                <img title=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "title", [], "any", false, false, true, 49), "html", null, true);
                yield "\" alt=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "alt", [], "any", false, false, true, 49), "html", null, true);
                yield "\" src=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["value"], "uri", [], "any", false, false, true, 49), "html", null, true);
                yield "\" width=\"50\" height=\"50\" />
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['key'], $context['value'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            yield "          </div>
        ";
        }
        // line 53
        yield "    </div>
    ";
        // line 54
        if (($context["prev_next"] ?? null)) {
            // line 55
            yield "        <div class=\"prev-next\">
            <a href=# id=\"imagefield_slideshow-prev-";
            // line 56
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["prev"] ?? null), "html", null, true);
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Prev"));
            yield "</a>
            <a href=# id=\"imagefield_slideshow-next-";
            // line 57
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["next"] ?? null), "html", null, true);
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Next"));
            yield "</a>
        </div>
    ";
        }
        // line 60
        yield "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["pause", "effect", "speed", "timeout", "pager", "url", "link_image_to", "image_pager", "prev_next"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/imagefield_slideshow/templates/imagefield-slideshow.html.twig";
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
        return array (  200 => 60,  192 => 57,  186 => 56,  183 => 55,  181 => 54,  178 => 53,  174 => 51,  161 => 49,  157 => 48,  154 => 47,  151 => 46,  145 => 45,  133 => 43,  130 => 42,  116 => 40,  113 => 39,  99 => 37,  96 => 36,  93 => 35,  89 => 34,  86 => 33,  82 => 31,  80 => 30,  72 => 25,  68 => 24,  64 => 23,  60 => 22,  56 => 21,  52 => 20,  48 => 18,  46 => 17,  44 => 16,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/imagefield_slideshow/templates/imagefield-slideshow.html.twig", "/opt/drupal/web/modules/contrib/imagefield_slideshow/templates/imagefield-slideshow.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 16, "if" => 30, "for" => 34];
        static $filters = ["escape" => 20, "trans" => 56];
        static $functions = ["random" => 16];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'for'],
                ['escape', 'trans'],
                ['random'],
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
