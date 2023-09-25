<?php

namespace Model;


use PDO;
use PDOException;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    public function checkEmailExists($email) {
        // Vérifiez si l'email existe déjà dans la base de données
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false;
    }

    public function checkUsernameExists($username) {
        // Vérifiez si le nom d'utilisateur existe déjà dans la base de données
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false;
    }


    public function createUser($email, $username, $password) {
        if ($this->checkEmailExists($email)) {
            header('Location: index.php?erreur=email_existe');
            exit;
        } elseif ($this->checkUsernameExists($username)) {
            header('Location: index.php?erreur=username_existe');
            exit;
        } else {
            // Si l'email n'existe pas, insérez les données dans la base de données
            $query = "INSERT INTO users (email, mdp, username) VALUES (:email, :mot_de_passe, :username)";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $password, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            // Redirigez l'utilisateur vers la page de confirmation ou de connexion
            header('Location: views/confirmation_inscription.php');
            exit;
        }
    }

    public function updateUser($id, $data) { /* ... */ }
    public function deleteUser($id) { /* ... */ }

    public function resetPwd($email){
        if (!$this->checkEmailExists($email)) {
            header('Location: index.php?erreur=email_inexistant');
            exit;
        } else {
            $uniqid = uniqid(true);
            $code = strtoupper(substr($uniqid, -5));

            $query = "UPDATE users SET codeMDPOublie = :code WHERE email = :email";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();


            // Envoyer l'e-mail avec le code de réinitialisation==
            $subject = "Réinitialisation de mot de passe";
            $message = "Votre code de réinitialisation de mot de passe est : " . $code;
            $headers = "From: no-replay@nexa.nocly.fr";
            mail($email, $subject, $message, $headers);

            $_SESSION['email'] = $email;
            // Rediriger l'utilisateur vers la page de réinitialisation de mot de passe
            header("Location: views/codeVerif.php");
            exit;
        }
    }
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
            $_SESSION['username'] = $utilisateur['username'];
            //$_SESSION["email_utilisateur"] = $email; // Stockez l'e-mail dans la session

            // Redirigez l'utilisateur vers la page de tableau de bord ou autre
            header('Location: views/dashboard.php');
            exit;
        } else {
            header('Location: index.php?erreur=1');
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