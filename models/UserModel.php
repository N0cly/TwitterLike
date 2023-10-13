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

        $path = __DIR__ . "/../db/db_nexa.sqlite";
        try {
            $db = new PDO('sqlite:' . $path);
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

        //$this->connectDB()->close();
        return $result !== false;
    }

    public function checkUsernameExists($username)
    {
        $err = "err_user";
        // Vérifiez si le nom d'utilisateur existe déjà dans la base de données
        $query = "SELECT * FROM users WHERE username = :username or username = :err";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':err', $err, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //$this->connectDB()->close();

        return $result !== false;
    }

    public function verifyEmail($email)
    {
        $uniqid = uniqid(true);
        $code = strtoupper(substr($uniqid, -5));

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

            $mail->setFrom('socialnetwork.nexa@gmail.com', 'Nexa');
            $mail->addAddress($email);
            //            $mail->addReplyTo('enzo.bedos@nocly.fr', 'Nocly');

            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation de votre inscription';
            $mail->Body = "Votre code de confirmation est : $code";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if ($mail->send()) {
                $_SESSION['email'] = $email;
                $_SESSION['code'] = $code;

                //$this->connectDB()->close();

                header("Location: ../views/codeVerif.php");
                exit;
            } else {
                // $this->connectDB()->close();

                session_start();
                $_SESSION["error_message"] = "Email non envoyé";
                $_SESSION['utilisateur_connecte'] = false;

                header('Location: ../');

                exit;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function createUser($email, $username, $password)
    {
        if ($this->checkEmailExists($email)) {

            session_start();
            $_SESSION['error_message'] = "Email déjà utilisé";
            $_SESSION['utilisateur_connecte'] = false;

            header('Location: ../');
            exit;
        } elseif ($this->checkUsernameExists($username)) {
            session_start();
            $_SESSION['error_message'] = "Username déjà utilisé";
            $_SESSION['utilisateur_connecte'] = false;

            header('Location: ../');
            exit;
        } else {



            $uniqid = uniqid(true);
            $codeInscription = strtoupper(substr($uniqid, -5));

            // Si l'email n'existe pas, insérez les données dans la base de données
            $query = "INSERT INTO users (codeInscription) VALUES (:codeInscription);";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':codeInscription', $codeInscription, PDO::PARAM_STR);

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
                    $mail->Body = "Votre code d'inscription' de mot de passe est : $codeInscription";
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    if ($mail->send()) {
                        $_SESSION['email'] = $email;
                        //$this->connectDB()->close();

                        header("Location: ../views/codeVerifInscription.php");
                        exit;
                    } else {
                        // $this->connectDB()->close();

                        session_start();
                        $_SESSION["error_message"] = "Email non envoyé";
                        $_SESSION['utilisateur_connecte'] = false;

                        header('Location: ../');

                        exit;
                    }
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                //$this->connectDB()->close();

                session_start();
                $_SESSION["error_message"] = "Erreur connexion a la base de données";
                $_SESSION['utilisateur_connecte'] = false;

                header('Location: ../');
                exit;
            }
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
            session_start();
            $_SESSION["error_message"] = "Email inexistant, créé un compte !";
            $_SESSION['utilisateur_connecte'] = false;

            header('Location: ../');

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

                $mail->setFrom('socialnetwork.nexa@gmail.com', 'Nexa');
                $mail->addAddress($email);
                $mail->addReplyTo('enzo.bedos@nocly.fr', 'Nocly');

                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true);
                $mail->Subject = 'Réinitialisation de mot de passe';
                $mail->Body = "Votre code de réinitialisation de mot de passe est : $code";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if ($mail->send()) {
                    $_SESSION['email'] = $email;
                    //$this->connectDB()->close();
                    $_SESSION['codeSend'] = true;

                    header("Location: ../views/codeVerif.php");
                    exit;
                } else {
                    // $this->connectDB()->close();

                    session_start();
                    $_SESSION["error_message"] = "Code Vérif non envoyé";
                    header('Location: ../');

                    exit;
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            //$this->connectDB()->close();

            session_start();
            $_SESSION["error_message"] = "Erreur connexion a la base de données";
            header('Location: ../');
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



        if ($user && password_verify($password, $user['mdp'])) {
            session_start();
            $_SESSION['utilisateur_connecte'] = true;
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            //actualisation de last_connexion
            $query = "UPDATE users SET last_connexion = datetime('now') WHERE email = :email";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':email', $user['email'], PDO::PARAM_STR);
            $stmt->execute();

            header('Location: ../views/dashboard.php');
            exit;
            //refaire ca pour qu'on puisse savoir quelle erreur a été commise au login
        } else {
            //$this->connectDB()->close();
            session_start();
            $_SESSION['error_message'] = "Identifiant ou mot de passe incorrect";
            $_SESSION['utilisateur_connecte'] = false;


            header('Location: ../');
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
                $_SESSION['codeCheck'] = true;

                header('Location: ../views/ChangementMDP.php');
                exit();
            } else {

                //$this->connectDB()->close();

                session_start();
                $_SESSION["error_message"] = "Code vérif erroné !";
                header('Location: codeVerif.php');
                exit;
            }

        }
    }

    public function checkCodeVerifInscription($email, $password, $username, $code)
    {

        $query = "SELECT codeInscription FROM users WHERE (codeInscription = :code )";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $pp = 'Images/pdp/Default.png';
        if ($row) {
            $codeBD = $row['codeInscription'];
            if ($codeBD == $code) {

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (username, email, mdp, first_connexion, pp) VALUES (:username, :email, :hashed_password, DATETIME('now'), :pp)";
                $stmt = $this->connectDB()->prepare($query);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':pp', $pp, PDO::PARAM_STR);
                $stmt->execute();

                $this->checkLogin($email, $password);
                exit();

            } else {

                session_start();
                $_SESSION["error_message"] = "Code erroné !";
                header('Location: ../');
                exit;
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

            //$this->connectDB()->close();

            $this->checkLogin($email, $newMDP);
            session_start();
            $_SESSION["success_message"] = "Mot de passe modifié avec success";
            header('Location: ../');
            exit;
        } else {
            //this->connectDB()->close();
            session_start();
            $_SESSION["error_message"] = "Les mots de passes ne coorespondent pas !";
            header('Location: ChangementMDP.php');
            exit;
        }

    }

    public function isModerator($email)
    {
        $query = "SELECT * FROM users WHERE (email = :email OR username = :email)";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user_data = $stmt->fetch();

        session_start();
        $_SESSION['is_moderator'] = $user_data['is_moderator'];
        //$this->connectDB()->close();


    }

    public function getUserData($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
        //$this->connectDB()->close();


        return $user_data;
    }

    public function ChangeUserInfo()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();
            $newDesc = $_POST["newDesc"];
            $user = $_SESSION["username"];

            if (isset($_FILES['newPP']) && $_FILES['newPP']['error'] == 0) {
                $uploadDir = 'Images/pdp/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $imageFileName = uniqid() . '_' . basename($_FILES['newPP']['name']);
                $ppPath = $uploadDir . $imageFileName;

                if (move_uploaded_file($_FILES['newPP']['tmp_name'], $ppPath)) {
                    $query = "UPDATE users SET pp = :newPP, description = :newDesc WHERE username = :user";
                    $stmt = $this->connectDB()->prepare($query);
                    $stmt->bindParam(':newPP', $ppPath, PDO::PARAM_STR);
                    $stmt->bindParam(':newDesc', $newDesc, PDO::PARAM_STR);
                    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
                    $stmt->execute();
                }
            } else {
                $query = "UPDATE users SET description = :newDesc WHERE username = :user";
                $stmt = $this->connectDB()->prepare($query);
                $stmt->bindParam(':newDesc', $newDesc, PDO::PARAM_STR);
                $stmt->bindParam(':user', $user, PDO::PARAM_STR);
                $stmt->execute();
            }

            header("Location: ../views/profil.php");
        }
    }




}