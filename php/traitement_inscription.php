<?php

if (isset($_SERVER['REQUEST_METHOD']) &&
    $_SERVER['REQUEST_METHOD'] == "POST") {
    // Récupérez les données du formulaire
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $username = $_POST["username"];

    try {
        $db = new PDO('sqlite:../db/db_nexa.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    // Vérifiez si l'email n'existe pas déjà dans la base de données
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // L'email existe déjà, affichez un message d'erreur ou redirigez l'utilisateur
        header('Location: inscription.php?erreur=email_existe');
        exit;
    }

    // Si l'email n'existe pas, insérez les données dans la base de données
    $hashed_password = password_verify($mot_de_passe, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, mdp, username) VALUES (:email, :hashed_password, :username)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':hashed_password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Redirigez l'utilisateur vers la page de confirmation ou de connexion
    header('Location: confirmation_inscription.php');
    exit;
}


?>
