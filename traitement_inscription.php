<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Validez et insérez les données dans la base de données (vous devez configurer votre connexion à la base de données)
    // $db = new PDO("mysql:host=hostname;dbname=database", "username", "password");
    // $query = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
    // $stmt = $db->prepare($query);
    // $stmt->execute([$nom, $email, $mot_de_passe]);

    // Redirigez l'utilisateur vers une page de confirmation ou de connexion
    header("Location: confirmation.php");
    exit;
}
?>
