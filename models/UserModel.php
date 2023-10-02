<?php

namespace Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


use PDO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class UserModel
{


    public function connectDB()
    {
        try {
            $db = new PDO('sqlite:./db/db_nexa.sqlite');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function checkEmailExists($email)
    {
        // Vérifiez si l'email existe déjà dans la base de données
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->connectDB()->close();
        return $result !== false;
    }

    public function checkUsernameExists($username)
    {
        // Vérifiez si le nom d'utilisateur existe déjà dans la base de données
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->connectDB()->close();

        return $result !== false;
    }


    public function createUser($email, $username, $password)
    {
        if ($this->checkEmailExists($email)) {
            header('Location: ../index.php?erreur=email_existe');
            exit;
        } elseif ($this->checkUsernameExists($username)) {
            header('Location: ../index.php?erreur=username_existe');
            exit;
        } else {

            // Si l'email n'existe pas, insérez les données dans la base de données
            $query = "INSERT INTO users (email, mdp, username) VALUES (:email, :mot_de_passe, :username)";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            // Redirigez l'utilisateur vers la page de confirmation ou de connexion
            $userModel = new UserModel();
            $userModel->checkLogin($email, $password);
            $this->connectDB()->close();

            exit;
        }
    }

    public function updateUser($id, $data)
    { /* ... */
    }
    public function deleteUser($id)
    { /* ... */
    }

    public function resetPwd($email)
    {
        if (!$this->checkEmailExists($email)) {
            header('Location: ../index.php?erreur=email_inexistant');
            exit;
        }

        $uniqid = uniqid(true);
        $code = strtoupper(substr($uniqid, -5));

        $query = "UPDATE users SET codeMDPOublie = :code WHERE email = :email";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Envoi de l'e-mail avec le code de réinitialisation
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);

            try {
                $mail->setLanguage('fr', '/optional/path/to/language/directory/');
                //ligne debug $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'socialnetwork.nexa@gmail.com';
                $mail->Password = 'uhxxocpnwxrxzwqv';
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;

                $mail->setFrom('socialnetwork.nexa@gmail.com', 'Mailer');
                $mail->addAddress($email);
                $mail->addReplyTo('enzo.bedos@nocly.fr', 'Nocly');

                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Subject = 'Réinitialisation de mot de passe';
                $mail->Body = "Votre code de réinitialisation de mot de passe est : $code";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if ($mail->send()) {
                    $_SESSION['email'] = $email;
                    $this->connectDB()->close();

                    header("Location: ../views/codeVerif.php");
                    exit;
                } else {
                    $this->connectDB()->close();

                    header('Location: ../index.php?erreur=email_non_envoye');

                    exit;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $this->connectDB()->close();

            header('Location: ../index.php?erreur=db_error');
            exit;
        }
    }
    public function checkLogin($username, $password)
    {
        $query = "SELECT * FROM users WHERE (email = :email OR username = :username)";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $username, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            print_r($errorInfo);
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

//        echo $user['mdp'];
//        echo "<br>";
//        echo $password;
//        echo "<br>";
//        echo password_verify($password, $user['mdp']);
//        die();
        if ($user && password_verify($password, $user['mdp'])) {
            session_start();
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            $this->connectDB()->close();

            header('Location: ../views/dashboard.php');
            exit;
        } else {
            $this->connectDB()->close();

            header('Location: ../index.php?erreur=mauvais_mot_de_passe');
            exit;
        }
    }

    public function checkCodeVerif($email, $code)
    {

        $query = "SELECT codeMDPOublie FROM users WHERE (email = :email )";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $codeBD = $row['codeMDPOublie'];
            if ($codeBD == $code) {
                header('Location: ../views/ChangementMDP.php');
                exit();
            } else {

                $this->connectDB()->close();

                //header('Location: index.php?erreur=code_errone');
                echo $code;
                echo $codeBD;
            }

        }
    }

    public function changeMDP($newMDP, $confirmNewMDP, $email)
    {

        if ($newMDP == $confirmNewMDP) {

            $hashed_password = password_hash($newMDP, PASSWORD_DEFAULT);
            $query = "UPDATE users SET mdp = :newMDP WHERE email = :email";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':newMDP', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $this->connectDB()->close();

            $this->checkLogin($email, $newMDP);
        } else {
            $this->connectDB()->close();

            header("location:../index.php?mdp_corespondent_pas");
        }

    }

    public function isModerator($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_data && $user_data['is_moderator']) {
            $this->connectDB()->close();

            return true;
        } else {
            $this->connectDB()->close();

            return false;
        }
    }

    public function getUserData($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->connectDB()->close();


        return $user_data;
    }


}