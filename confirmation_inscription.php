<?php
session_start();

// Vérifiez d'abord si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_connecte"]) || $_SESSION["utilisateur_connecte"] !== true) {
    header("Location: ConnectPage.php");
    exit;
}

// Récupérez l'e-mail de la session
$email_utilisateur = $_SESSION["email_utilisateur"];

// Vous pouvez maintenant utiliser $email_utilisateur dans cette page
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
</head>
<body>
<h1>Confirme email -></h1>
<p>Email de l'utilisateur connecté : <?php echo htmlspecialchars($email_utilisateur); ?></p>
<!-- Autres contenus du tableau de bord -->
</body>
</html>
