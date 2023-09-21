<?php

namespace Model;


use PDO;
use PDOException;

class userModel
{
    public function getAllUsers() { /*"SELECT * FROM users"*/}
    public function getUserById($id) { /*"SELECT username FROM users WHERE $id = id"*/}
    public function createUser($data) { /*"SELECT createUser FROM users WHERE $data = username || $data = email"*/}
    public function updateUser($id, $data) { /* ... */ }
    public function deleteUser($id) { /* ... */ }

    public function checkLogin($username, $password) {
        try {
            $db = new PDO('sqlite:db/db_nexa.sqlite');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }

        $query = "SELECT * FROM users WHERE (email = :email OR username = :username) AND mdp = :mot_de_passe";
        $stmt = $db->prepare($query);
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
            header('Location: ../index.php?erreur=1');
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