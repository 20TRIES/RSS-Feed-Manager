<?php

/* feeds/show.twig */
class __TwigTemplate_a1ab8810b734de337177e00125301581c1d336e964bcf5c3eb60639a2e7159d6 extends Twig_Template
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
<table>
    <tr> <th>Title</th> <th>Desc</th> <th>Created</th> </tr>
    ";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 11
            echo "        <tr>
            <td> <a href=\"";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "getAttribute", array(0 => "address"), "method"), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "getAttribute", array(0 => "title"), "method"), "html", null, true);
            echo "</a> </td>
            <td style=\"max-width: 400px\"> ";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "getAttribute", array(0 => "desc"), "method"), "html", null, true);
            echo " </td>
            <td> ";
            // line 14
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "getAttribute", array(0 => "created_at"), "method"), "diffForHumans", array(), "method"), "html", null, true);
            echo " </td>
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "</table>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "feeds/show.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 17,  53 => 14,  49 => 13,  43 => 12,  40 => 11,  36 => 10,  30 => 7,  24 => 4,  19 => 1,);
    }
}
