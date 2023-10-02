<?php
session_start();

// Vérifie si l'utilisateur est connecté
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $commentaire = $_POST['commentaire'];
    $id_pere = $_POST['id_pere'];
    $user = $_SESSION['user'];

    $stmt = $conn->prepare("INSERT INTO Post (contenu, user, Time, id_pere) VALUES (:contenu, :user, datetime('now'), :id_pere)");
    $stmt->bindParam(':contenu', $commentaire);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':id_pere', $id_pere);
    $stmt->execute();

    header("Location: dashboard.php");

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

