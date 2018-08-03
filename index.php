<?php
session_start();

require_once 'dbconfig.php';
require_once 'vendor/autoload.php';
require_once 'models/AdminModel.php';
require_once 'models/QuestionsModel.php';
require_once 'models/CategoriesModel.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AdminController.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, [
    'cache' => 'compilation_cache',
    'auto_reload' => true
]);

if (isset($_SESSION['user_id'])) {                      // если админ залогинен
    $admin = new AdminController($db, $twig);
    $admin->adminController($_REQUEST);
}

else {
    $user = new UserController($db, $twig);
    $user->userController($_REQUEST);
}
