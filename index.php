<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de connexion">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link href="css/style1.css" rel="stylesheet" type="text/css">
    <script src="js/script.js"></script>
    <link rel="icon" href="Images/Logos/Logo_Nexa-smaller.png">
    <title>Nexa</title>
</head>

<body>
<section class="main">
    <section class="head">
        <img class="logo-nexa" src="Images/Logos/Logo Nexa.png" alt="Logo Nexa">
    </section>
    <h2>Page de connexion</h2>

    <section class="choice-form">

        <button class="inscriptionButton" id="inscriptionButton" onclick="afficherFormulaire('inscription')">Inscription</button>
        <button class="connexionButton" id="connexionButton" onclick="afficherFormulaire('connexion')">Connexion</button>
    </section>



    <form class="register" id="register" action="php/traitement_inscription.php" method="post"> <!-- Formulaire inscription -->
        <h3>Inscription</h3>
        <div class="field">
            <label for="username">Username :</label>
            <input type="text" id="username" name="username" class="field" required>
        </div>

        <div class="field">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" class="field field-email" required>
        </div>

        <div class="field ">
            <label for="mot_de_passe">Mot de passe :</label>
            <section class="field-pswd">
                <input type="password" id="mot_de_passe" name="mot_de_passe" class="mdp field field-pswd__mdp" required>
                <input type="checkbox" class="checkpswd" onclick="showPwd1()">
            </section>
        </div>


        <input class="inscriptionButton" type="submit" value="S'inscrire">
    </form>

    <form id="connexion" class="connexion" action="php/traitement_connexion.php" method="post"> <!-- Formulaire connexion -->
        <h3>Connexion</h3>
        <div class="field">
            <label for="email">Email or Username :</label>
            <input class="field field-email" type="text" name="email" required><br>
        </div>

        <div class="field ">
            <label for="mot_de_passe">Mot de passe :</label>
            <section class="field-pswd">
                <input type="password" name="mot_de_passe" id="mdp2" class="mdp field field-pswd__mdp" required>
                <input type="checkbox" class="checkpswd" onclick="showPwd2()">
            </section>
        </div>

        <input class="connexionButton" type="submit" value="Se connecter">
    </form>
</section>

<section class="NexaInformation">
    <h2>A Propos de Nexa</h2>
</section>
</body>
</html>
