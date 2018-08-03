<?php

/* admin.html */
class __TwigTemplate_75b82219d2e55ad8a2accc98a879e5d95ec4a8dc35f92e5c9fa2643790ceefd9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("index.html", "admin.html", 1);
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
    <form method=\"POST\" action=\"../index.php\">
        <p>Создание нового администратора</p>
        <input type=\"text\" name=\"login\" placeholder=\"Логин\">
        <input type=\"text\" name=\"password\" placeholder=\"Пароль\">
        <input type=\"submit\" name=\"createAdmin\" value=\"Создать\">
    </form>
    <br>


    <table border='1'>
    <tr><th>id</th><th>Логин</th><th>Пароль</th><th>Действия</th></tr>
    ";
        // line 16
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["adminsList"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["admin"]) {
            // line 17
            echo "        <tr><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["admin"], "user_id", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["admin"], "login", array()), "html", null, true);
            echo "</td><td> ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["admin"], "password", array()), "html", null, true);
            echo " </td><td>
            <a href=\"../index.php?action=deleteAdmin&id=";
            // line 18
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["admin"], "user_id", array()), "html", null, true);
            echo "\">Удалить</a>
            <a href=\"../index.php?action=editPassword&id=";
            // line 19
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["admin"], "user_id", array()), "html", null, true);
            echo "\">Изменить пароль</a>
            </td></tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['AdminController'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "    </table>

    ";
        // line 24
        if (twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "editpassword", array())) {
            // line 25
            echo "        <form method=\"POST\" action=\"../index.php\">
            <p>Меняем пароль администратору с id ";
            // line 26
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "editpassword_id", array()), "html", null, true);
            echo "</p>
            <input type=\"text\" name=\"newpass\" placeholder=\"Введите новый пароль\">
            <input type=\"submit\" name=\"setPassword\" value=\"Отправить\">
        </form>
    ";
        }
        // line 31
        echo "    <br><hr><br>

    <form method=\"POST\" action=\"../index.php\">
        <p>Создание новой темы</p>
        <input type=\"text\" name=\"category_name\" placeholder=\"Название новой темы\">
        <input type=\"submit\" name=\"createCategory\" value=\"Создать\">
    </form>
    <br>

    <table border='1'>
        <tr><th>id</th><th>Название темы</th><th>Всего вопросов</th><th>Опубликовано</th><th>Без ответа/заморожено</th><th>Действия</th></tr>
        ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categoriesList"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 43
            echo "        <tr><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_id", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_name", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "overall", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "published", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "suspended", array()), "html", null, true);
            echo "</td><td>
            <a href=\"../index.php?action=deleteCategory&id=";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_id", array()), "html", null, true);
            echo "\">Удалить тему со всеми вопросами</a>
        </td></tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "    </table>
    <br><hr><br>

    <p>Просмотр/администрирование вопросов по темам.</p>
    <form method=\"POST\" action=\"../index.php\">
        <select name=\"admin_category_id\">
            <option selected disabled>выберите тему</option>
            ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categoriesList"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
            // line 55
            echo "            <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_id", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_name", array()), "html", null, true);
            echo "</option>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 57
        echo "        </select>
        <input type=\"submit\" name=\"adminSortQuestions\" value=\"Выбрать\">
    </form>

    ";
        // line 61
        if (twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "sortedQuestions", array())) {
            // line 62
            echo "        <table border=\"1px\">
        <tr><th>Вопрос</th><th>Дата создания</th><th>Статус</th><th>Действия</th><th>Изменение темы</th></tr>
        ";
            // line 64
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "sortedQuestions", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["question"]) {
                // line 65
                echo "        <tr><td>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question", array()), "html", null, true);
                echo "</td><td>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "date_added", array()), "html", null, true);
                echo "</td><td>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "status", array()), "html", null, true);
                echo "</td><td>
            <a href=\"../index.php?action=deleteQuestion&question_id=";
                // line 66
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question_id", array()), "html", null, true);
                echo "\">Удалить</a>
            <a href=\"../index.php?action=setAnswerPrepare&question_id=";
                // line 67
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question_id", array()), "html", null, true);
                echo "\">Ответить</a>
            <a href=\"../index.php?action=editQuestionPrepare&question_id=";
                // line 68
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question_id", array()), "html", null, true);
                echo "\">Редактировать</a>
            ";
                // line 69
                if ((twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "status", array()) == "suspended")) {
                    // line 70
                    echo "                <a href=\"../index.php?action=changeQuestionStatus&newstatus=published&question_id=";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question_id", array()), "html", null, true);
                    echo "\">Опубликовать</a>
            ";
                } else {
                    // line 72
                    echo "                <a href=\"../index.php?action=changeQuestionStatus&newstatus=suspended&question_id=";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question_id", array()), "html", null, true);
                    echo "\">Скрыть</a>
            ";
                }
                // line 74
                echo "            </td><td>
            <form method=\"POST\" action=\"../index.php\">
                <select name=\"change_category_id\">
                    <option selected disabled>выберите тему</option>
                    ";
                // line 78
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["categoriesList"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["c"]) {
                    // line 79
                    echo "                    <option value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["question"], "question_id", array()), "html", null, true);
                    echo " ";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_id", array()), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["c"], "category_name", array()), "html", null, true);
                    echo "</option>
                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['c'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 81
                echo "                </select>
                <input type=\"submit\" name=\"changeCategory\" value=\"В другую тему\">
            </form>
        </td></tr>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['question'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 86
            echo "        </table>
    ";
        }
        // line 88
        echo "
    ";
        // line 89
        if (twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "answer", array())) {
            // line 90
            echo "        <p>Дать ответ:</p>
        <form method=\"POST\" action=\"../index.php\">
            <input type=\"text\" name=\"author\" placeholder=\"Автор ответа\">
            <input type=\"text\" name=\"answer_text\" placeholder=\"и сам ответ\">
            <input type=\"checkbox\" name=\"publish\" value=\"pub\"> <span>Опубликовать после ответа?</span>
            <input type=\"submit\" name=\"setAnswer\" value=\"Отправить\">
        </form>
    ";
        }
        // line 98
        echo "
    ";
        // line 99
        if (twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "edit_question", array())) {
            // line 100
            echo "        <p>Редактируем вопрос:</p>
        <form method=\"POST\" action=\"../index.php\">
            <input type=\"text\" name=\"question\" value=\"";
            // line 102
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "edit", array()), "question", array()), "html", null, true);
            echo "\">
            <input type=\"text\" name=\"author\" value=\"";
            // line 103
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "edit", array()), "author_name", array()), "html", null, true);
            echo "\">
            <input type=\"text\" name=\"email\" value=\"";
            // line 104
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "edit", array()), "author_email", array()), "html", null, true);
            echo "\">
            <input type=\"text\" name=\"answer\" value=\"";
            // line 105
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), twig_get_attribute($this->env, $this->getSourceContext(), ($context["adminVariables"] ?? null), "edit", array()), "answer", array()), "html", null, true);
            echo "\">
            <input type=\"submit\" name=\"updateQuestion\" value=\"Отправить\">
        </form>

    ";
        }
        // line 110
        echo "
    <br><hr><br>
    <p>Вопросы без ответов:</p>
    <table border=\"1\">
        <tr><th>Вопрос</th><th>Тема</th><th>Действия</th></tr>
        ";
        // line 115
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["uaQuestions"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["q"]) {
            // line 116
            echo "            <tr><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["q"], "question", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["q"], "category", array()), "html", null, true);
            echo "</td><td>
                <a href=\"../index.php?action=deleteQuestion&question_id=";
            // line 117
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["q"], "question_id", array()), "html", null, true);
            echo "\">Удалить</a>
            </td></tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['q'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 120
        echo "    </table>


</main>
";
    }

    public function getTemplateName()
    {
        return "admin.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  310 => 120,  301 => 117,  294 => 116,  290 => 115,  283 => 110,  275 => 105,  271 => 104,  267 => 103,  263 => 102,  259 => 100,  257 => 99,  254 => 98,  244 => 90,  242 => 89,  239 => 88,  235 => 86,  225 => 81,  212 => 79,  208 => 78,  202 => 74,  196 => 72,  190 => 70,  188 => 69,  184 => 68,  180 => 67,  176 => 66,  167 => 65,  163 => 64,  159 => 62,  157 => 61,  151 => 57,  140 => 55,  136 => 54,  127 => 47,  118 => 44,  105 => 43,  101 => 42,  88 => 31,  80 => 26,  77 => 25,  75 => 24,  71 => 22,  62 => 19,  58 => 18,  49 => 17,  45 => 16,  31 => 4,  28 => 3,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "admin.html", "W:\\domains\\localfinal\\templates\\admin.html");
    }
}
