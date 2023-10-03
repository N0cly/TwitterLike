<?php

//namespace ctrl;


require_once('../models/UserModel.php');


use Model\UserModel;

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
            $userModel->isModerator($email);

        }
    }

    public function forgotPwd(){
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupérer l'adresse e-mail soumise par l'utilisateur
            $email = $_POST["email"];
            session_start();

            $_SESSION["email"] = $email;

            $userModel = new UserModel();
            $userModel->resetPwd($email);
        }
    }

    public function checkCodeVerif()
    {
        if (
            isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER["REQUEST_METHOD"] == "POST"
        ) {

            session_start();

            $code = $_POST["code"];
            $email = $_SESSION["email"];

            $userModel = new UserModel();
            $userModel->checkCodeVerif($email, $code);
        }

    }

    public function changeMDP()
    {
        if (
            isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER["REQUEST_METHOD"] == "POST"
        ) {

            session_start();

            $newMDP = $_POST["newMDP"];
            $confirmNewMDP = $_POST["confirmNewMDP"];
            $email = $_SESSION["email"];

            $userModel = new UserModel();
            $userModel->changeMDP($newMDP, $confirmNewMDP, $email);
        }
    }

    public  function getUser($email){
        $userModel = new UserModel();
        $user = $userModel->getUserData($email);

        return $user;
    }



    // Autres méthodes pour gérer les utilisateurs
}
