<?php
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    //$nom = $_POST["nom"];
    //$email = $_POST["email"];
    //$mot_de_passe = $_POST["mot_de_passe"];

    // Validez et insérez les données dans la base de données (vous devez configurer votre connexion à la base de données)
    // $db = new PDO("mysql:host=hostname;dbname=database", "username", "password");
    // $query = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
    // $stmt = $db->prepare($query);
    // $stmt->execute([$nom, $email, $mot_de_passe]);

    // Redirigez l'utilisateur vers une page de confirmation ou de connexion
    //header("Location: confirmation.php");
    //exit;
//}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $username = $_POST["username"];

    try {
        $db = new PDO('sqlite:./db/db_nexa.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    // Vérifiez si l'email n'existe pas déjà dans la base de données
    $query = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // L'email existe déjà, affichez un message d'erreur ou redirigez l'utilisateur
        header('Location: inscription.php?erreur=email_existe');
        exit;
    }

    // Si l'email n'existe pas, insérez les données dans la base de données
    $query = "INSERT INTO utilisateurs (email, mot_de_passe, username) VALUES (:email, :mot_de_passe, :username)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Redirigez l'utilisateur vers la page de confirmation ou de connexion
    header('Location: confirmation_inscription.php');
    exit;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}


?>
