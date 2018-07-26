<?php
session_start();

require_once 'dbconfig.php';
require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'classes/AdminActions.php'; // класс
require_once 'classes/QuestionActions.php'; // класс
require_once 'classes/CategoriesAction.php'; // класс

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
    'cache' => 'compilation_cache',
    'auto_reload' => true
]);

$adminVariables =[];

if (!empty($_POST)) {                                                      // админ может залогиниться
    if (isset($_POST['sign_in'])) {
        $login = strip_tags($_POST['login']);
        $password = strip_tags($_POST['password']);
        auth($login, $password);
    }
    if (isset($_POST['user_question'])) {                                    // обработка вопроса от пользователя
        processUserQuestion($_POST);
    }
}

if (isAuth()) {                                                             // если админ залогинен
    $adminVariables['isAuth'] = true;
    $admins = new AdminActions();
    $adminsList = $admins->getAdminsList();
    $categories = new CategoriesAction();
    $categoriesList = $categories->getAllCategories();
    $questions = new QuestionActions();
    $unansweredQuestions = $questions->getUnansweredQuestions();

    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'editpassword') {                            //  подготовка с смене пароля админа
            $adminVariables['editpassword'] = true;
            $adminVariables['editpassword_id'] = $_GET['id'];
            $_SESSION['editpassword_id'] = $_GET['id'];
        }
        if ($_GET['action'] == 'delete') {                                  //  удаление админа
            $admins->deleteAdmin($_GET['id']);
            $adminsList = $admins->getAdminsList();
        }
        if ($_GET['action'] == 'deleteCat') {                               //  удаление темы
            $categories->deleteCategory($_GET['id']);
            $categoriesList = $categories->getAllCategories();
        }
        if ($_GET['action'] == 'del_question') {                            //  удаление вопроса администратором
            $questions->deleteQuestion($_GET['question_id']);
        }
        if ($_GET['action'] == 'published' || $_GET['action'] == 'suspended') {  //  изменение статуса вопроса
            $questions->changeStatus($_GET['action'], $_GET['question_id']);
        }
        if ($_GET['action'] == 'answer') {                                  // подготовка к ответу на вопрос
            $_SESSION['question_to_answer'] = $_GET['question_id'];
            $adminVariables['answer'] = true;
        }
        if ($_GET['action'] == 'edit_question') {                           //  подготовка к редактированию вопроса
            $_SESSION['question_to_edit'] = $_GET['question_id'];
            $adminVariables['edit_question'] = true;
            $adminVariables['edit'] = $questions->getQuestionToEdit($_GET['question_id']);
            $_SESSION['answer_to_edit'] = $adminVariables['edit']['answer_id'];
        }
    }

    if (isset($_POST['setpass'])) {                                         //  смена пароля админа
        $admins->setPassword($_SESSION['editpassword_id'], $_POST['newpass']);
        $adminsList = $admins->getAdminsList();
    }

    if (isset($_POST['createAdmin'])) {                                     //  создание нового администратора
        $admins->createAdmin($_POST['login'], $_POST['password']);
        $adminsList = $admins->getAdminsList();
    }

    if (isset($_POST['createCategory'])) {                                  //  создание новой темы
        $categories->addCategory($_POST['category_name']);
        $categoriesList = $categories->getAllCategories();
    }

    if (isset($_POST['admin_sort_questions'])) {                            //  вопросы отсортированные по теме для администратора
        $sortedQuestions =  $categories->getQuestionsByCategory($_POST['admin_category_id']);
        $adminVariables['sortedQuestions'] = $sortedQuestions;
    }

    if (isset($_POST['answer_form'])) {
        print_r($_POST);
        echo "SDSDDSDSSDSSDSDSD";
        if ($_POST['publish'] == 'pub') {
            $publish = 'published';
        }
        else {
            $publish = 'suspended';
        }
        $questions->setAnswer($_SESSION['question_to_answer'], $_POST['answer_text'], $_POST['author'], $publish);
        $unansweredQuestions = $questions->getUnansweredQuestions();
    }

    if (isset($_POST['edited_question'])) {
        $questions->updateAnsweredQuestion($_SESSION['question_to_edit'], $_SESSION['answer_to_edit'], $_POST['author'], $_POST['email'], $_POST['question'], $_POST['answer']);
    }

    if (isset($_POST['change_category_id'])) {
        //$questions->changeCategory($question_id, $_POST['category_id']);
    }


    echo $twig->render('admin.html', ['adminVariables'=>$adminVariables,
                                            'adminsList' => $adminsList,
                                            'categoriesList' => $categoriesList,
                                            'uaQuestions' => $unansweredQuestions]);
}
else {                                                                      //  если админ не залогинен = обычный пользователь
    $categories = getCategories();
    if (isset($_GET['category'])) {
        $questions = getQuestionsByCategory($_GET['category']);
    }
    else {
        $questions = getQuestionsAll();
    }
    echo $twig->render('user.html', ['categories' => $categories,
                                            'questions' => $questions]);
}
