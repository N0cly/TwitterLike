<?php

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Réinitialisation mot de passe">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link href="../css/style1.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="Images/Logos/Logo_Nexa-smaller.png">
    <title>Mot de passe oublié</title>
</head>

<body>
    <h2>Mot de passe oublié</h2>
    <p>Entrez votre adresse e-mail pour recevoir un code de réinitialisation.</p>
    <form method="post" action="../User/forgotPwd">
        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" required>
        <input type="submit" value="Envoyer le code de réinitialisation">
    </form>
</body>

</html>