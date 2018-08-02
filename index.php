<?php
session_start();

require_once 'dbconfig.php';
require_once 'vendor/autoload.php';
require_once 'classes/AdminActions.php';
require_once 'classes/QuestionActions.php';
require_once 'classes/CategoriesAction.php';
require_once 'classes/User.php';
require_once 'classes/Admin.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
    'cache' => 'compilation_cache',
    'auto_reload' => true
]);

if (isset($_SESSION['user_id'])) {                                                             // если админ залогинен
    $admin = new Admin($db, $twig);
    $admin->adminController($_REQUEST);
}

else {
    $user = new User($db, $twig);
    $user->userController($_REQUEST);
}
