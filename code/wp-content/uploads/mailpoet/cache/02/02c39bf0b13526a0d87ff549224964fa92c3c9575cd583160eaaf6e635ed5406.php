<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Extension\SandboxExtension;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* emails/statsNotificationLayout.txt */
class __TwigTemplate_1085faa1e635d1f1975910f3e76984f3ae41db9ac313e8c1b2be32612a8f383b extends \MailPoetVendor\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->displayBlock('content', $context, $blocks);
        // line 2
        echo "
";
        // line 3
        echo $this->extensions['MailPoet\Twig\I18n']->translate("How to improve my open rate?");
        echo " https://www.mailpoet.com/how-to-improve-open-rates/
";
        // line 4
        echo $this->extensions['MailPoet\Twig\I18n']->translate("And my click rate?");
        echo " https://www.mailpoet.com/how-to-improve-click-rates/
";
        // line 5
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Disable these emails");
        echo " ";
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["linkSettings"] ?? null), "html", null, true);
        echo "
";
    }

    // line 1
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "emails/statsNotificationLayout.txt";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 1,  51 => 5,  47 => 4,  43 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "emails/statsNotificationLayout.txt", "C:\\Sites\\happiesthealth.local\\web\\wp-content\\plugins\\mailpoet\\views\\emails\\statsNotificationLayout.txt");
    }
}
