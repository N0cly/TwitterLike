<?php
session_start();

// Vérifiez d'abord si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_connecte"]) || $_SESSION["utilisateur_connecte"] !== true) {
    header("Location: ../index.php");
    exit;
}

// Récupérez l'e-mail de la session
$username = $_SESSION["username"];

// Vous pouvez maintenant utiliser $email_utilisateur dans cette page
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord</title>
</head>
<body>
<h1>Bienvenue sur le tableau de bord</h1>
<p>Email de l'utilisateur connecté : <?php echo htmlspecialchars($username); ?></p>
<!-- Autres contenus du tableau de bord -->
</body>
</html>
