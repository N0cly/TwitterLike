<?php

use ctrl\UserController;

require 'models/userModel.php';
require 'ctrl/UserController.php';

$action = isset($_GET['user']) ? $_GET['user'] : 'accueil';

// Inclure les classes et initialiser la session

$controller = new UserController();
echo $action;
// Vérifier si la méthode existe dans le contrôleur
if (method_exists($controller, $action)) {
    call_user_func(array($controller, $action));
}
//elseif (!$action = 'accueil') {
//    include ('Views/404.php');
//}
else {
    include ('Views/accueil.php');

}

