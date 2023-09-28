<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use ctrl\UserController;


// Inclure le modèle de base
require 'models/userModel.php';


// Récupérer le nom du contrôleur depuis l'URL
$controllerName = isset($_GET['Controller']) ? $_GET['Controller'] : 'Accueil';

// Ajoutez ici la logique pour valider et sécuriser le nom du contrôleur, par exemple, en vérifiant qu'il correspond à un contrôleur existant.

// Inclure le fichier du contrôleur spécifié
$controllerFile ="ctrl/{$controllerName}Controller.php";

if (file_exists($controllerFile)) {
    require $controllerFile;

    // Instancier le contrôleur
    $controllerClassName = $controllerName . 'Controller';
    $controller = new $controllerClassName();

    // Récupérer la méthode depuis l'URL
    $action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

    // Vérifier si la méthode existe dans le contrôleur
    if (method_exists($controller, $action)) {
        call_user_func(array($controller, $action));
    } else {
        include('views/404.php');
    }
} else {
    include('views/accueil.php');
}