<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 02.08.2018
 * Time: 19:50
 */

class AdminController {
    public $adminVariables = [];

    function __construct($db, $twig) {
        $this->questions = new QuestionsModel($db);
        $this->categories = new CategoriesModel($db);
        $this->admins = new AdminModel($db);
        $this->twig = $twig;
        $this->adminVariables['isAuth'] = true;
    }

    /*
     * стандартный рендер панели админа
     */
    function adminPanelRender() {
        echo $this->twig->render('admin.html', ['adminVariables'=>$this->adminVariables,
            'adminsList' => $this->admins->getAdminsList(),
            'categoriesList' => $this->categories->getAllCategories(),
            'uaQuestions' => $this->questions->getUnansweredQuestions()]);
    }

    /*
     * выбор метода для обработки действий
     */
    function adminController($array) {
        if (!empty($array)) {
            if (isset ($array['action'])) {
                $action = $array['action'];
                if (method_exists($this, $action)) {
                    $this->$action($array);
                }
            } else {
                $possibleValues = ['setPassword', 'createAdmin', 'createCategory', 'adminSortQuestions', 'getAnswerForm', 'changeCategory', 'updateQuestion'];
                foreach ($possibleValues as $value) {
                    if (array_key_exists($value, $array)) {
                        $this->$value($array);
                    }
                }
            }
        }
        else {
            $this->adminPanelRender();
        }
    }

    /*
     * подготовка к смене пароля
     */
    function editPassword($array) {
        $this->adminVariables['editpassword'] = true;
        $this->adminVariables['editpassword_id'] = $array['id'];
        $_SESSION['editpassword_id'] = $array['id'];
        $this->adminPanelRender();
    }

    /*
     * удаление администратора
     */
    function deleteAdmin($array) {
        $this->admins->deleteAdmin($array['id']);
        $this->adminPanelRender();
    }

    /*
     * удаление категории
     */
    function deleteCategory($array) {
        $this->categories->deleteCategory($array['id']);
        $this->adminPanelRender();
    }

    /*
     * удаление вопроса
     */
    function deleteQuestion($array) {
        $this->questions->deleteQuestion($array['question_id']);
        $this->adminPanelRender();
    }

    /*
     * изменение статуса вопроса
     */
    function changeQuestionStatus($array) {
        $this->questions->changeStatus($array['newstatus'], $array['question_id']);
        $this->adminPanelRender();
    }

    /*
     * подготовка к ответу на вопрос
     */
    function setAnswerPrepare($array) {
        $_SESSION['question_to_answer'] = $array['question_id'];
        $this->adminVariables['answer'] = true;
        $this->adminPanelRender();
    }

    /*
     * подготовка к редактированию вопроса
     */
    function editQuestionPrepare($array) {
        $_SESSION['question_to_edit'] = $array['question_id'];
        $this->adminVariables['edit_question'] = true;
        $this->adminVariables['edit'] = $this->questions->getQuestionToEdit($array['question_id']);
        $_SESSION['answer_to_edit'] = $this->adminVariables['edit']['answer_id'];
        $this->adminPanelRender();
    }

    /*
     * смена пароля администратора
     */
    function setPassword($array) {
        $this->admins->setPassword($_SESSION['editpassword_id'], $array['newpass']);
        $this->adminPanelRender();
    }

    /*
     * создание нового администратора
     */
    function createAdmin($array) {
        $this->admins->createAdmin($array['login'], $array['password']);
        $this->adminPanelRender();
    }

    /*
     * создание новой категории
     */
    function createCategory($array) {
        $this->categories->addCategory($array['category_name']);
        $this->adminPanelRender();
    }

    /*
     * вопросы из определенной категории
     */
    function adminSortQuestions($array) {
        $sortedQuestions =  $this->categories->getQuestionsByCategory($array['admin_category_id']);
        $this->adminVariables['sortedQuestions'] = $sortedQuestions;
        $this->adminPanelRender();
    }

    /*
     * отправка ответа на вопрос
     */
    function setAnswer($array) {
        if ($_POST['publish'] == 'pub') {
            $publish = 'published';
        }
        else {
            $publish = 'suspended';
        }
        $this->questions->setAnswer($_SESSION['question_to_answer'], $array['answer_text'], $array['author'], $publish);
        $this->adminPanelRender();
    }

    /*
     * отправка отредактированного вопроса
     */
    function updateQuestion($array) {
        $this->questions->updateAnsweredQuestion($_SESSION['question_to_edit'], $_SESSION['answer_to_edit'], $array['author'], $array['email'], $array['question'], $array['answer']);
        $this->adminPanelRender();
    }

    /*
     * перенос вопроса в другую категорию
     */
    function changeCategory($array) {
        $this->questions->changeCategory($array['change_category_id']);
        $this->adminPanelRender();
    }
}