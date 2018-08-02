<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 02.08.2018
 * Time: 19:50
 */

class Admin {
    public $adminVariables = [];

    function __construct($db, $twig) {
        $this->questions = new QuestionActions($db);
        $this->categories = new CategoriesAction($db);
        $this->admins = new AdminActions($db);
        $this->twig = $twig;
        $this->adminVariables['isAuth'] = true;
    }

    function adminPanelRender() {
        echo $this->twig->render('admin.html', ['adminVariables'=>$this->adminVariables,
            'adminsList' => $this->admins->getAdminsList(),
            'categoriesList' => $this->categories->getAllCategories(),
            'uaQuestions' => $this->questions->getUnansweredQuestions()]);
    }

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

    function editPassword($array) {                                                                 //подготовка к смене пароля
        $this->adminVariables['editpassword'] = true;
        $this->adminVariables['editpassword_id'] = $array['id'];
        $_SESSION['editpassword_id'] = $array['id'];
        $this->adminPanelRender();
    }

    function deleteAdmin($array) {                                                                  //удаление админа
        $this->admins->deleteAdmin($array['id']);
        $this->adminPanelRender();
    }

    function deleteCategory($array) {                                                               //удаление темы
        $this->categories->deleteCategory($array['id']);
        $this->adminPanelRender();
    }

    function deleteQuestion($array) {                                                               //удаление вопроса
        $this->questions->deleteQuestion($array['question_id']);
        $this->adminPanelRender();
    }

    function changeQuestionStatus($array) {                                                         //изменение статуса вопроса
        $this->questions->changeStatus($array['newstatus'], $array['question_id']);
        $this->adminPanelRender();
    }

    function setAnswerPrepare($array) {                                                             //подготовка к ответу на вопрос
        $_SESSION['question_to_answer'] = $array['question_id'];
        $this->adminVariables['answer'] = true;
        $this->adminPanelRender();
    }

    function editQuestionPrepare($array) {                                                                 //подготовка к редактированию вопроса
        $_SESSION['question_to_edit'] = $array['question_id'];
        $this->adminVariables['edit_question'] = true;
        $this->adminVariables['edit'] = $this->questions->getQuestionToEdit($array['question_id']);
        $_SESSION['answer_to_edit'] = $this->adminVariables['edit']['answer_id'];
        $this->adminPanelRender();
    }

    function setPassword($array) {                                                                  //смена пароля админа
        $this->admins->setPassword($_SESSION['editpassword_id'], $array['newpass']);
        $this->adminPanelRender();
    }

    function createAdmin($array) {                                                                  //создание новго админа
        $this->admins->createAdmin($array['login'], $array['password']);
        $this->adminPanelRender();
    }

    function createCategory($array) {                                                               //создание новой темы
        $this->categories->addCategory($array['category_name']);
        $this->adminPanelRender();
    }

    function adminSortQuestions($array) {                                                           //вопросы из определенной категории
        $sortedQuestions =  $this->categories->getQuestionsByCategory($array['admin_category_id']);
        $this->adminVariables['sortedQuestions'] = $sortedQuestions;
        $this->adminPanelRender();
    }

    function setAnswer($array) {                                                                    //отправка ответа на вопрос
        if ($_POST['publish'] == 'pub') {
            $publish = 'published';
        }
        else {
            $publish = 'suspended';
        }
        $this->questions->setAnswer($_SESSION['question_to_answer'], $array['answer_text'], $array['author'], $publish);
        $this->adminPanelRender();
    }

    function updateQuestion($array) {                                                               //отправка отредактированного вопроса
        $this->questions->updateAnsweredQuestion($_SESSION['question_to_edit'], $_SESSION['answer_to_edit'], $array['author'], $array['email'], $array['question'], $array['answer']);
        $this->adminPanelRender();
    }

    function changeCategory($array) {                                                             //перенос вопроса в другую тему
        $this->questions->changeCategory($array['change_category_id']);
        $this->adminPanelRender();
    }
}