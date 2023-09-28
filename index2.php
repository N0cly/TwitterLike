<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use ctrl\UserController;

require 'models/userModel.php';
require 'ctrl/UserController.php';

$controller = new UserController();

$action = isset($_GET['user']) ? $_GET['user'] : 'accueil';

// Inclure les classes et initialiser la session

// Vérifier si la méthode existe dans le contrôleur
if (method_exists($controller, $action)) {
    call_user_func(array($controller, $action));
}
//elseif (!$action = 'accueil') {
//    include ('views/404.php');
//}
else {
    include('views/accueil.php');

}

