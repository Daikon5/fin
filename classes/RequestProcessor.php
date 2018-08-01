<?php

class RequestProcessor {
    function __construct($db) {
        $this->questions = new QuestionActions($db);
        $this->categories = new CategoriesAction($db);
        $this->admins = new AdminActions($db);
    }

    function process($array) {
        global $adminVariables;

        if (isset($array['action'])) {
            if ($array['action'] == 'editpassword') {                            //  подготовка с смене пароля админа
                $adminVariables['editpassword'] = true;
                $adminVariables['editpassword_id'] = $array['id'];
                $_SESSION['editpassword_id'] = $array['id'];
            }
            if ($array['action'] == 'delete') {                                  //  удаление админа
                $this->admins->deleteAdmin($array['id']);
                $adminVariables['adminsList'] = $this->admins->getAdminsList();
            }
            if ($array['action'] == 'deleteCat') {                               //  удаление темы
                $this->categories->deleteCategory($array['id']);
                $adminVariables['categoriesList'] = $this->categories->getAllCategories();
            }
            if ($array['action'] == 'del_question') {                            //  удаление вопроса администратором
                $this->questions->deleteQuestion($array['question_id']);
            }
            if ($array['action'] == 'published' || $array['action'] == 'suspended') {  //  изменение статуса вопроса
                $this->questions->changeStatus($array['action'], $array['question_id']);
            }
            if ($array['action'] == 'answer') {                                  // подготовка к ответу на вопрос
                $_SESSION['question_to_answer'] = $array['question_id'];
                $adminVariables['answer'] = true;
            }
            if ($array['action'] == 'edit_question') {                           //  подготовка к редактированию вопроса
                $_SESSION['question_to_edit'] = $array['question_id'];
                $adminVariables['edit_question'] = true;
                $adminVariables['edit'] = $this->questions->getQuestionToEdit($array['question_id']);
                $_SESSION['answer_to_edit'] = $adminVariables['edit']['answer_id'];
            }
        }

        if (isset($_POST['setpass'])) {                                         //  смена пароля админа
            $this->admins->setPassword($_SESSION['editpassword_id'], $_POST['newpass']);
            $adminVariables['adminsList'] = $this->admins->getAdminsList();
        }

        if (isset($_POST['createAdmin'])) {                                     //  создание нового администратора
            $this->admins->createAdmin($_POST['login'], $_POST['password']);
            $adminVariables['adminsList'] = $this->admins->getAdminsList();
        }

        if (isset($_POST['createCategory'])) {                                  //  создание новой темы
            $this->categories->addCategory($_POST['category_name']);
            $adminVariables['categoriesList'] = $this->categories->getAllCategories();
        }

        if (isset($_POST['admin_sort_questions'])) {                            //  вопросы отсортированные по теме для администратора
            $sortedQuestions =  $this->categories->getQuestionsByCategory($_POST['admin_category_id']);
            $adminVariables['sortedQuestions'] = $sortedQuestions;
        }

        if (isset($_POST['answer_form'])) {                                     // ответ на вопрос
            if ($_POST['publish'] == 'pub') {
                $publish = 'published';
            }
            else {
                $publish = 'suspended';
            }
            $this->questions->setAnswer($_SESSION['question_to_answer'], $_POST['answer_text'], $_POST['author'], $publish);
            $adminVariables['unansweredQuestions'] = $this->questions->getUnansweredQuestions();
        }

        if (isset($_POST['edited_question'])) {
            $this->questions->updateAnsweredQuestion($_SESSION['question_to_edit'], $_SESSION['answer_to_edit'], $_POST['author'], $_POST['email'], $_POST['question'], $_POST['answer']);
        }

        if (isset($_POST['change_category_id'])) {
            $this->questions->changeCategory($_POST['change_category_id']);
        }
    }

    function adminRegular() {
        return ['adminsList' => $this->admins->getAdminsList(),
                'categoriesList' => $this->categories->getAllCategories(),
                'unansweredQuestions' => $this->questions->getUnansweredQuestions()];
    }

    function userRegular($req = 'none') {
        $questionsList = $this->questions->getQuestionsAll();
        $categoriesList = $this->categories->getUserCategories();
        if ($req != 'none') {
            $questionsList = $this->questions->getQuestionsByCategory($req);
        }

        return [$questionsList, $categoriesList];
    }
}