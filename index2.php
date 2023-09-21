<?php

use ctrl\UserController;

require 'models/userModel.php';
require 'ctrl/UserController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

// Inclure les classes et initialiser la session

$controller = new UserController();
switch ($action) {
//    case 'inscription':
//        $controller->showRegistrationForm();
//        break;
    case 'traitement_inscription':
        $controller->registerUser();
        break;
//    case 'login':
//        $controller->showLoginForm();
//        break;
    case 'traitement_connexion':
        $controller->loginUser();
        break;
    // Autres actions et contrôleurs ici
    default:
        // Page d'accueil par défaut
        include('Views/accueil.php');
}
