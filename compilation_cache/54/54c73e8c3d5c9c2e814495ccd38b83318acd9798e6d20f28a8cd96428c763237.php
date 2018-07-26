<?php

/* user.html */
class __TwigTemplate_24aab36ed9f75a1ce759622bb7050c00bf86b3237459416746068467db88195d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("index.html", "user.html", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "index.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<main>
    <section class=\"ask\">
        <div class=\"ask-form\">
            <p><strong>Есть вопрос? Задайте его нам и, скорее всего, мы вам ответим!</strong></p>
            <form method=\"POST\" action=\"../index.php\">
                <input type=\"text\" name=\"question\" placeholder=\"Текст вопроса\">
                <input type=\"text\" name=\"email\" placeholder=\"Ваш email\">
                <input type=\"text\" name=\"name\" placeholder=\"Ваше имя\">
                <select name=\"category_id\">
                    <option selected disabled>выберите категорию</option>
                    ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["cat"]) {
            // line 15
            echo "                        <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["cat"], "category_id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["cat"], "category_name", array()), "html", null, true);
            echo "</option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "                </select>
                <input type=\"submit\" name=\"user_question\" value=\"Отправить\">
            </form>
        </div>
    </section>
    <section class=\"categories\">
        <div class=\"category\">
            ";
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["cat"]) {
            // line 25
            echo "            <p><a href=\"../index.php?category=";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["cat"], "category_id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["cat"], "category_name", array()), "html", null, true);
            echo " </a></p>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cat'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "        </div>
    </section>
    <section class=\"content\">
        ";
        // line 30
        if ((twig_length_filter($this->env, ($context["questions"] ?? null)) == 0)) {
            // line 31
            echo "            ";
            echo "В этой категории нет вопросов.";
            echo "
        ";
        }
        // line 33
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["questions"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 34
            echo "        <div class=\"question\">
            <div class=\"que\">
                <p>Вопрос в категории \"";
            // line 36
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "category", array()), "html", null, true);
            echo "\" от ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "author_name", array()), "html", null, true);
            echo " (";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "author_email", array()), "html", null, true);
            echo "), задан ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "date_added", array()), "html", null, true);
            echo ":</p>
                <span>";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "question", array()), "html", null, true);
            echo "</span>
            </div>
            <div class=\"answer\">
                <p>Ответ от ";
            // line 40
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "answerer", array()), "html", null, true);
            echo ":</p>
                ";
            // line 41
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["item"], "answer", array()), "html", null, true);
            echo "
            </div>
        </div>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        echo "    </section>
</main>
";
    }

    public function getTemplateName()
    {
        return "user.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 45,  124 => 41,  120 => 40,  114 => 37,  104 => 36,  100 => 34,  95 => 33,  89 => 31,  87 => 30,  82 => 27,  71 => 25,  67 => 24,  58 => 17,  47 => 15,  43 => 14,  31 => 4,  28 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "user.html", "W:\\domains\\localfinal\\templates\\user.html");
    }
}
