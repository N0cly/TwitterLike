<?php
//
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//
//use ctrl\UserController;
//
//
//// Inclure le modèle de base
//require 'models/userModel.php';
//
//
//// Récupérer l'URI de la demande
//$requestUri = $_SERVER['REQUEST_URI'];
//
//// Supprimer les paramètres de l'URL
//$cleanUri = strtok($requestUri, '?');
//
//// Divisez l'URI en segments en utilisant '/'
//$uriSegments = explode('/', trim($cleanUri, '/'));
//
//$controllerName = isset($uriSegments[0]) ? ucfirst($uriSegments[0]) . 'Controller' : 'AccueilController';
//$action = isset($uriSegments[1]) ? $uriSegments[1] : 'accueil';
//
//// Récupérer le nom du contrôleur depuis l'URL
////$controllerName = isset($_GET['Controller']) ? $_GET['Controller'] : 'Accueil';
//
//// Ajoutez ici la logique pour valider et sécuriser le nom du contrôleur, par exemple, en vérifiant qu'il correspond à un contrôleur existant.
//
//// Inclure le fichier du contrôleur spécifié
//$controllerFile = "ctrl/{$controllerName}.php";
////$controllerFile ="ctrl/{$controllerName}Controller.php";
//
//if (file_exists($controllerFile)) {
//    require $controllerFile;
//
//    // Instancier le contrôleur
//    //$controllerClassName = $controllerName . 'Controller';
//    $controller = new $controllerName();
//
//    // Récupérer la méthode depuis l'URL
//   // $action = isset($_GET['action']) ? $_GET['action'] : 'accueil';
//
//    // Vérifier si la méthode existe dans le contrôleur
//    if (method_exists($controller, $action)) {
//        call_user_func(array($controller, $action));
//    } else {
//        include('views/404.php');
//    }
//} else {
//    include('views/accueil.php');
//}


// Ce fichier est le point d'entrée de votre application

require 'core/ChargementAuto.php';
/*
 url pour notre premier test MVC Hello World,
 nous n'avons pas d'action précisée on visera celle par défaut
 /index.php?ctrl=helloworld
 /helloworld
 /controleur/nom_action/whatever/whatever2/

*/
/*
    $S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
    $S_action = isset($_GET['action']) ? $_GET['action'] : null;

    Vue::ouvrirTampon(); //  /Noyau/Vue.php : on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
    $O_controleur = new Controleur($S_controleur, $S_action);
*/

$S_urlADecortiquer = isset($_GET['url']) ? $_GET['url'] : null;
$A_postParams = isset($_POST) ? $_POST : null;

Vue::ouvrirTampon(); // on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans

try {
    $O_controleur = new Controleur($S_urlADecortiquer, $A_postParams);
    $O_controleur->executer();
} catch (ControleurException $O_exception) {
    echo('Une erreur s\'est produite : ' . $O_exception->getMessage());
}


// Les différentes sous-vues ont été "crachées" dans le tampon d'affichage, on les récupère
$contenuPourAffichage = Vue::recupererContenuTampon();

// On affiche le contenu dans la partie body du gabarit général
Vue::montrer('accueil', array('body' => $contenuPourAffichage));