<?php
session_start();
$email = $_SESSION["email"];


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de connexion">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link href="../css/style1.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="Images/Logos/Logo_Nexa-smaller.png">
    <title>Mot de passe oublié</title>
</head>

<body>
    <section class="main">
        <section class="container-form">
            <h2>Mot de passe oublié</h2>
            <h3>Entrez votre code de réinitialisation recu par email afin de pouvoir changer votre mot de passe.</h3>
        </section>
        <!-- Formulaire -->
        <section class="choice-form">
            <form method="post" action="../User/checkCodeVerif">
                <label for="code">Code :</label>
                <input type="code" name="code" required>
                <input type="submit" value="Envoyer le code de réinitialisation">
            </form>

        </section>
    </section>
</body>

</html>