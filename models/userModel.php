<?php

namespace Model;


use PDO;
use PDOException;

class userModel
{

    public function connectDB(){
        try {
            $db = new PDO('sqlite:./db/db_nexa.sqlite');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function checkEmailExists($email){

        // Vérifiez si l'email n'existe pas déjà dans la base de données
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;

//        if ($stmt->rowCount() > 0) {
//            // L'email existe déjà, affichez un message d'erreur ou redirigez l'utilisateur
//            header('Location: index2.php?erreur=email_existe');
//            exit;
//        }


    }
    public function createUser($email, $username, $password) {

        // Si l'email n'existe pas, insérez les données dans la base de données
        $query = "INSERT INTO users (email, mdp, username) VALUES (:email, :mot_de_passe, :username)";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Redirigez l'utilisateur vers la page de confirmation ou de connexion
        header('Location: php/confirmation_inscription.php');
        exit;
    }
    public function updateUser($id, $data) { /* ... */ }
    public function deleteUser($id) { /* ... */ }

    public function checkLogin($username, $password) {
        //$db = $this->connectDB();
        $query = "SELECT * FROM users WHERE (email = :email OR username = :username) AND mdp = :mot_de_passe";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $username, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $password, PDO::PARAM_STR);
        $stmt->execute();

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            // Les informations de connexion sont correctes, vous pouvez gérer la session de l'utilisateur ici
            // Par exemple, en utilisant $_SESSION
            session_start();
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['email'] = $utilisateur['email'];
            $_SESSION['userModel'] = $utilisateur['username'];
            //$_SESSION["email_utilisateur"] = $email; // Stockez l'e-mail dans la session

            // Redirigez l'utilisateur vers la page de tableau de bord ou autre
            header('Location: php/dashboard.php');
            exit;
        } else {
            header('Location: index2.php?erreur=1');
            $messageErreur = "Nom d'utilisateur ou mot de passe incorrect.";
            echo '<script>';
            echo 'document.getElementById("message-erreur").innerHTML = "' . $messageErreur . '";';
            echo 'document.getElementById("message-erreur").classList.add("erreur-message");';
            echo '</script>';
            // Les informations de connexion sont incorrectes, affichez un message d'erreur ou redirigez vers la page de connexion
            exit;
        }
    }
}