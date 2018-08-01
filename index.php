<?php
session_start();

require_once 'dbconfig.php';
require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'classes/AdminActions.php'; // класс
require_once 'classes/QuestionActions.php'; // класс
require_once 'classes/CategoriesAction.php'; // класс
require_once 'classes/RequestProcessor.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
    'cache' => 'compilation_cache',
    'auto_reload' => true
]);

$adminVariables =[];
$requests = new RequestProcessor($db);

if (!empty($_POST)) {                                                      // админ может залогиниться
    if (isset($_POST['sign_in'])) {
        $login = strip_tags($_POST['login']);
        $password = strip_tags($_POST['password']);
        auth($login, $password, $db, $adminVariables);
    }
    if (isset($_POST['user_question'])) {                                    // обработка вопроса от пользователя
        processUserQuestion($_POST, $db);
    }
}

if (isAuth()) {                                                             // если админ залогинен

    $regularAdminData = $requests->adminRegular();
    foreach ($regularAdminData as $key => $value) {
        $adminVariables[$key] = $value;
    }

    if (!empty($_REQUEST)) {
        $requests->process($_REQUEST);
    }

    echo $twig->render('admin.html', ['adminVariables'=>$adminVariables,
                                            'adminsList' => $adminVariables['adminsList'],
                                            'categoriesList' => $adminVariables['categoriesList'],
                                            'uaQuestions' => $adminVariables['unansweredQuestions']]);
}
else {                                                                      //  если админ не залогинен = обычный пользователь
    if (isset($_GET['category'])) {
        $result = $requests->userRegular($_GET['category']);
    }
    else {
        $result = $requests->userRegular();
    }
    echo $twig->render('user.html', ['categories' => $result[1],
                                            'questions' => $result[0]]);
}
