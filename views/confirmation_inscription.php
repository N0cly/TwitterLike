<?php
session_start();

// Vérifiez d'abord si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_connecte"]) || $_SESSION["utilisateur_connecte"] !== true) {
    header("Location: ../");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de connexion">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link href="../css/style1.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="../Images/Logos/Logo_Nexa-smaller.png">
    <title>Confirmation</title>
</head>

<body>
<?php include('message_ESI.php'); ?>

    <section class=main>
        <h2>Inscription bien enregistrée</h2>
        <section>
            <button class="connexionAutoButton" action="index.php?user=acceuil">Connexion</button>
        </section>
    </section>


    <!-- Autres contenus du tableau de bord -->
</body>

</html>