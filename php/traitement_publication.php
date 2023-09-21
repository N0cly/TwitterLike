<?php
session_start();
try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $contenu = $_POST['contenu'];
    $user = $_SESSION['user'];

    $stmt = $conn->prepare("INSERT INTO Post (contenu, user, Time) VALUES (:contenu, :user, datetime('now'))");
    $stmt->bindParam(':contenu', $contenu);
    $stmt->bindParam(':user', $user);
    $stmt->execute();

    header("Location: dashboard.php");

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
