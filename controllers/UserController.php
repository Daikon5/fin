<?php

class UserController {

    function __construct($db, $twig) {
        $this->db = $db;
        $this->questions = new QuestionsModel($db);
        $this->categories = new CategoriesModel($db);
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
                $this->auth($login, $password);
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
     * аутентификация администратора
     */
    function auth($login,$password) {
        try {
            $sqlAuth = 'SELECT * FROM users WHERE login=? AND password=?';
            $query = $this->db->prepare($sqlAuth);
            $query->execute([$login, $password]);
            $result = $query->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        if ($login == $result['login'] && $password == $result['password']) {
            $_SESSION['user_id'] = $result['user_id'];
            header('location: index.php');
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