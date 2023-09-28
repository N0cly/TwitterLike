<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use ctrl\UserController;


// Inclure le modèle de base
require 'models/userModel.php';


// Récupérer l'URI de la demande
$requestUri = $_SERVER['REQUEST_URI'];

// Supprimer les paramètres de l'URL
$cleanUri = strtok($requestUri, '?');

// Divisez l'URI en segments en utilisant '/'
$uriSegments = explode('/', trim($cleanUri, '/'));

$controllerName = isset($uriSegments[0]) ? ucfirst($uriSegments[0]) . 'Controller' : 'AccueilController';
$action = isset($uriSegments[1]) ? $uriSegments[1] : 'accueil';

// Récupérer le nom du contrôleur depuis l'URL
//$controllerName = isset($_GET['Controller']) ? $_GET['Controller'] : 'Accueil';

// Ajoutez ici la logique pour valider et sécuriser le nom du contrôleur, par exemple, en vérifiant qu'il correspond à un contrôleur existant.

// Inclure le fichier du contrôleur spécifié
$controllerFile = "ctrl/{$controllerName}.php";
//$controllerFile ="ctrl/{$controllerName}Controller.php";

if (file_exists($controllerFile)) {
    require $controllerFile;

    // Instancier le contrôleur
    //$controllerClassName = $controllerName . 'Controller';
    $controller = new $controllerName();

    // Récupérer la méthode depuis l'URL
   // $action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

    // Vérifier si la méthode existe dans le contrôleur
    if (method_exists($controller, $action)) {
        call_user_func(array($controller, $action));
    } else {
        include('views/404.php');
    }
} else {
    include('views/accueil.php');
}