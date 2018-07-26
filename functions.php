<?php
function auth($login,$password) {                                                                  //  аутентификация
    global $db;
    global $adminVariables;

    try {
        $sqlAuth = 'SELECT * FROM users WHERE login=? AND password=?';
        $query = $db->prepare($sqlAuth);
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
    else {
        $adminVariables['authError'] = 'Неверный логин или пароль!';
    }
}

function isAuth(){                                                                                  //  проверка аутентификации
    return isset($_SESSION['user_id']);
}

function getCategories() {                                                                          //  категории для пользователя
    global $db;

    try {
        $categoriesQuery = 'SELECT * FROM categories';
        $query = $db->prepare($categoriesQuery);
        $query->execute();
        $categories = $query->fetchAll();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $categories;
}

function getQuestionsAll() {                                                                         //  все отвеченные вопросы для пользователя
    global $db;

    try {
        $questionsQuery = 'SELECT q.author_name, q.author_email, q.question, q.date_added, a.answer, a.author as answerer, c.category_name as category
                          FROM questions q
                          JOIN answers a ON a.question_id = q.question_id
                          JOIN categories c ON q.category_id = c.category_id
                          WHERE q.status = ?';
        $query = $db->prepare($questionsQuery);
        $query->execute(['published']);
        $questions = $query->fetchAll();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $questions;
}

function getQuestionsByCategory($category) {                                                          //  отвеченный вопросы в выбранной категории
    global $db;

    try {
        $questionsQuery = 'SELECT q.author_name, q.author_email, q.question, q.date_added, a.answer, a.author as answerer, c.category_name as category
                          FROM questions q
                          JOIN answers a ON a.question_id = q.question_id
                          JOIN categories c ON q.category_id = c.category_id
                          WHERE q.category_id = ? AND q.status = ?';
        $query = $db->prepare($questionsQuery);
        $query->execute([$category, 'published']);
        $questions = $query->fetchAll();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $questions;
}

function processUserQuestion($array) {
    global $db;
    $inputErrors = [];
    $wantedFields = ['question','email','name','category_id'];

    foreach ($wantedFields as $field) {
        if (empty($array[$field])) {
            array_push($inputErrors, $field);
        }
    }
    if (count($inputErrors) == 0) {
        try {
            $dateNow = date('Y-m-d')." ".date('H:i:s');
            $addQuestionQuery = 'INSERT INTO questions(question_id, author_name, author_email, category_id, status, question, date_added) 
                                  VALUES (?,?,?,?,?,?,?)';
            $db->prepare($addQuestionQuery)->execute([NULL, $array['name'], $array['email'], $array['category_id'], 'suspended', $array['question'], $dateNow]);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
