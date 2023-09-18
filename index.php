<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de connexion">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link href="css/style1.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="Images/Logos/Logo_Nexa-smaller.png">
    <title>Nexa</title>
</head>

<body>
<section class="main">
    <section class="container-form">
        <section class="head">
            <img class="logo-nexa" src="Images/Logos/Logo Nexa.png" alt="Logo Nexa">
            <h2>Page de connexion</h2>
        </section>


        <section class="choice-form">
            <section class="choice-form__button">
                <button class="inscriptionButton" id="inscriptionButton" onclick="afficherFormulaire('inscription')">Inscription</button>
                <button class="connexionButton" id="connexionButton" onclick="afficherFormulaire('connexion')">Connexion</button>
            </section>
            <div id="message-erreur"></div>
        </section>




        <form  id="register" class="register" action="php/traitement_inscription.php" method="post"> <!-- Formulaire inscription -->
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
                    <input type="password" id="mdp1" name="mot_de_passe" class="mdp field field-pswd__mdp" required>
                    <input type="checkbox" class="checkpswd" onclick="togglePasswordVisibility('mdp1')">
                </section>
            </div>

        <div  class="inscription-connexion-button-container">
            <input class="inscriptionButton" type="submit" value="S'inscrire">
        </div>
            
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
                    <input type="checkbox" class="checkpswd" onclick="togglePasswordVisibility('mdp2')">
                </section>
            </div>

            <div class="inscription-connexion-button-container">
                <input class="connexionButton" type="submit" value="Se connecter">
            </div>
        </form>
    </section>
</section>
<section class="NexaInformation">
    <h2>A Propos de Nexa</h2>
</section>
<script src="js/script.js"></script>
</body>
</html>
