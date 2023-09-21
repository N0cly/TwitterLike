<?php

namespace Ctrl;

use Model\userModel;

class UserController {

    public function showRegistrationForm() {
        // Afficher le formulaire d'inscription
        include('Views/inscription.php');
    }

    public function registerUser() {
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD'] == "POST") {
            // Récupérez les données du formulaire
            $email = $_POST["email"];
            $password = $_POST["mot_de_passe"];
            $username = $_POST["username"];

            $userModel = new UserModel();
            $isValid = $userModel->createUser($email, $username, $password);

            if ($isValid) {
                // Les informations de connexion sont valides, vous pouvez rediriger
               // header('Location: dashboard.php');
                exit;
            } else {
                // Affichez un message d'erreur à l'utilisateur
                $errorMessage = 'Nom d\'utilisateur ou mot de passe incorrect';
                include 'views/login.php'; // Afficher la vue de connexion avec un message d'erreur
            }
        } else {
            // Affichez le formulaire de connexion
            include 'views/login.php';
        }

        // Gérer la soumission du formulaire d'inscription
        // Appeler les méthodes du modèle User pour créer un utilisateur
        // Rediriger vers une vue appropriée (par exemple, page de confirmation)
    }

    public function showLoginForm() {
        // Afficher le formulaire de connexion
        include('Views/login.php');
    }

    public function loginUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['mot_de_passe'];

            // Appelez le modèle pour vérifier les informations de connexion
            $userModel = new UserModel();
            $isValid = $userModel->checkLogin($email, $password);

            if ($isValid) {
                // Les informations de connexion sont valides, vous pouvez rediriger
                //header('Location: dashboard.php');
                exit;
            } else {
                // Affichez un message d'erreur à l'utilisateur
                $errorMessage = 'Nom d\'utilisateur ou mot de passe incorrect';
                include 'views/login.php'; // Afficher la vue de connexion avec un message d'erreur
            }
        } else {
            // Affichez le formulaire de connexion
            include 'views/login.php';
        }


        // Gérer la soumission du formulaire de connexion
        // Appeler les méthodes du modèle User pour valider les informations de connexion
        // Rediriger vers une vue appropriée (par exemple, tableau de bord)
    }

    // Autres méthodes pour gérer les utilisateurs
}
