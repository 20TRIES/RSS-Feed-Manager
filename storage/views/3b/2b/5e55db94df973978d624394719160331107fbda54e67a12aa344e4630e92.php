<?php

/* feeds/index.twig */
class __TwigTemplate_3b2b5e55db94df973978d624394719160331107fbda54e67a12aa344e4630e92 extends Twig_Template
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
            <tr> <th>Name</th> <th>Created</th> </tr>
            ";
        // line 10
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["feed"]) {
            // line 11
            echo "                <tr>
                    <td> <a href=\"";
            // line 12
            echo twig_escape_filter($this->env, ((isset($context["link_to_show"]) ? $context["link_to_show"] : null) . $this->getAttribute($context["feed"], "getAttribute", array(0 => "id"), "method")), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["feed"], "getAttribute", array(0 => "name"), "method"), "html", null, true);
            echo "</a> </td>
                    <td> ";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["feed"], "getAttribute", array(0 => "created_at"), "method"), "diffForHumans", array(), "method"), "html", null, true);
            echo " </td>
                </tr>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['feed'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "        </table>
    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "feeds/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 16,  49 => 13,  43 => 12,  40 => 11,  36 => 10,  30 => 7,  24 => 4,  19 => 1,);
    }
}
