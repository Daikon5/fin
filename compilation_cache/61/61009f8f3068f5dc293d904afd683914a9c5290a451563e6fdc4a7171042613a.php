<?php

/* base.html */
class __TwigTemplate_94827a23c4845511cb8f2e9e951348e018923490fc7576000ba586edb64d9404 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
</head>
<body>
    <div id=\"content\">
        ";
        // line 9
        $this->displayBlock('content', $context, $blocks);
        // line 11
        echo "    </div>
</body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Дратути";
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "        ";
    }

    public function getTemplateName()
    {
        return "base.html";
    }

    public function getDebugInfo()
    {
        return array (  51 => 10,  48 => 9,  42 => 5,  36 => 11,  34 => 9,  27 => 5,  21 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "base.html", "W:\\domains\\localfinal\\templates\\base.html");
    }
}
