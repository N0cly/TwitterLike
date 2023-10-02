<?php
session_start();

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification de la session utilisateur
    if(!isset($_SESSION['user'])) {
        header("Location: login.php"); // ou une autre page de redirection
        exit;
    }

    $contenu = $_POST['contenu'];
    $user = $_SESSION['user'];

    // Chemin de l'image à enregistrer dans la base de données
    $imagePath = null;

    // Vérification si une image a été téléchargée
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = '../uploads/';

        // Assurez-vous que le répertoire de téléchargement existe
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Déplace le fichier téléchargé vers le répertoire de téléchargement
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        if(!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            // Si le déplacement du fichier échoue, réinitialise $imagePath à null
            $imagePath = null;
        }
    }

    // Préparation de la requête SQL pour insérer le post avec l'image
    $stmt = $conn->prepare("INSERT INTO Post (contenu, user, Time, image) VALUES (:contenu, :user, datetime('now'), :image)");
    $stmt->bindParam(':contenu', $contenu);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':image', $imagePath); // Liaison du chemin de l'image
    $stmt->execute();

    header("Location: dashboard.php");

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
