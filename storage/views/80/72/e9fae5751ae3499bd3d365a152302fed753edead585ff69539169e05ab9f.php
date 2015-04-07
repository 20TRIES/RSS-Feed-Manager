<?php

/* feeds/create.twig */
class __TwigTemplate_8072e9fae5751ae3499bd3d365a152302fed753edead585ff69539169e05ab9f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <title>";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</title>
</head>
    <body>
        <h1>";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
        echo "</h1>
        <form method=\"POST\" action=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["submit_address"]) ? $context["submit_address"] : null), "html", null, true);
        echo "\" accept-charset=\"UTF-8\">
            Name
            <div>
                <input id=\"name\" name=\"name\" value=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["feed"]) ? $context["feed"] : null), "name", array()), "html", null, true);
        echo "\" type=\"text\">
            </div>
            Address
            <div>
                <input id=\"address\" name=\"address\" value=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["feed"]) ? $context["feed"] : null), "address", array()), "html", null, true);
        echo "\" type=\"text\">
            </div>
            <input type=\"submit\" value=\"Submit\">
        </form>

    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "feeds/create.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 15,  40 => 11,  34 => 8,  30 => 7,  24 => 4,  19 => 1,);
    }
}
