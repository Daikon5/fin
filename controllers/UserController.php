<?php

class UserController {

    function __construct($db, $twig) {
        $this->db = $db;
        $this->questions = new QuestionsModel($db);
        $this->categories = new CategoriesModel($db);
        $this->admin = new AdminModel($db);
        $this->twig = $twig;
    }

    /*
     * стандартны рендер юзера
     */
    function userRender() {
        echo $this->twig->render('user.html', ['categories'=>$this->categories->getUserCategories(),
                                                'questions' => $this->questions->getQuestionsAll()]);
    }

    /*
     * выбор метода для обработки действий
     */
    function userController($array) {
        if (!empty($array)) {
            if (isset($array['getQuestionsByCategoryId'])) {
                    $this->getQuestionsByCategoryId($array['getQuestionsByCategoryId']);
            }
            elseif (isset($array['sign_in'])) {
                $login = strip_tags($array['login']);
                $password = strip_tags($array['password']);
                $this->admin->auth($login, $password);
            }
            elseif (isset($array['user_question'])) {
                $this->questions->processUserQuestion($array);
                $this->userRender();
            }
        }
        else {
            $this->userRender();
        }
    }

    /*
     * рендер с вопросами по определнной категории
     */
    function getQuestionsByCategoryId($id) {
        echo $this->twig->render('user.html', ['categories'=>$this->categories->getUserCategories(),
                                                'questions' => $this->questions->getQuestionsByCategory($id)]);
    }
}