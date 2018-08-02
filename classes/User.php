<?php

class User {

    function __construct($db, $twig) {
        $this->db = $db;
        $this->questions = new QuestionActions($db);
        $this->categories = new CategoriesAction($db);
        $this->twig = $twig;
    }

    function userRender() {
        echo $this->twig->render('user.html', ['categories'=>$this->categories->getUserCategories(),
                                                'questions' => $this->questions->getQuestionsAll()]);
    }

    function userController($array) {
        if (!empty($array)) {
            if (isset($array['getQuestionsByCategoryId'])) {
                    $this->getQuestionsByCategoryId($array['getQuestionsByCategoryId']);
            }
            else if (isset($array['sign_in'])) {
                $login = strip_tags($array['login']);
                $password = strip_tags($array['password']);
                $this->auth($login, $password);
            }
            else if (isset($array['user_question'])) {
                $this->questions->processUserQuestion($array);
                $this->userRender();
            }
        }
        else {
            $this->userRender();
        }
    }

    function auth($login,$password) {                                                                  //  аутентификация
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

    function getQuestionsByCategoryId($id) {
        echo $this->twig->render('user.html', ['categories'=>$this->categories->getUserCategories(),
                                                'questions' => $this->questions->getQuestionsByCategory($id)]);
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