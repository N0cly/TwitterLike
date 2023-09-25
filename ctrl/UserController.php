<?php

namespace Ctrl;

use Model\userModel;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class UserController {



    public function registerUser() {
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD'] == "POST") {
            // Récupérez les données du formulaire
            $email = $_POST["email"];
            $password = $_POST["mot_de_passe"];
            $username = $_POST["username"];

            $userModel = new UserModel();
            $userModel->createUser($email, $username, $password);
        }
    }

    public function loginUser() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['mot_de_passe'];

            // Appelez le modèle pour vérifier les informations de connexion
            $userModel = new UserModel();
            $userModel->checkLogin($email, $password);

        }
    }

    public function forgotPwd(){
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer l'adresse e-mail soumise par l'utilisateur
            $email = $_POST["email"];

            $userModel = new UserModel();
            $userModel->resetPwd($email);
        }
    }

    // Autres méthodes pour gérer les utilisateurs
}
