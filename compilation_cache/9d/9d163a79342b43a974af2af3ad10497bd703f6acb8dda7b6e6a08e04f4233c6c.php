<?php

/* index.html */
class __TwigTemplate_275557bced6086d881a7ff42bc1d73daff3b7b9b72f1d975603fb1e43f21ec36 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"ru\">
<head>
    ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 9
        echo "</head>
<body>
    <header>
        <h2>FAQ</h2>
        <div class=\"input-bar\">
            <div class=\"input-form\">
                ";
        // line 15
        if (twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "isAuth", array())) {
            // line 16
            echo "                    <form action=\"../logout.php\">
                        <span>Устали администрировать? Добро пожаловать на </span>
                        <button type=\"submit\">Выход</button>
                    </form>
                ";
        } else {
            // line 21
            echo "                    <form method=\"POST\" action=\"../index.php\">
                        <span>О, вы администратор?</span>
                        <input type=\"text\" name =\"login\" placeholder=\"Логин\">
                        <input type=\"text\" name=\"password\" placeholder=\"Пароль\">
                        <input type=\"submit\" name=\"sign_in\" value=\"Войти\">
                    </form>
                ";
        }
        // line 28
        echo "            </div>
        </div>
    </header>

    ";
        // line 32
        $this->displayBlock('content', $context, $blocks);
        // line 34
        echo "</body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "    <meta charset=\"UTF-8\">
    <link rel=\"stylesheet\" href=\"templates/css/style.css\">
    <title>FAQ</title>
    ";
    }

    // line 32
    public function block_content($context, array $blocks = array())
    {
        // line 33
        echo "    ";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 33,  77 => 32,  70 => 5,  67 => 4,  62 => 34,  60 => 32,  54 => 28,  45 => 21,  38 => 16,  36 => 15,  28 => 9,  26 => 4,  21 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html", "W:\\domains\\localfinal\\templates\\index.html");
    }
}
