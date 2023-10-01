<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bienvenue sur Nexa !">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <!--<link href="../css/style1.css" rel="stylesheet" type="text/css">-->
    <link href="../css/accueil.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <link rel="icon" href="../Images/Logos/Logo_Nexa-smaller.png">
    <title>Nexa</title>
</head>

<body>
<section class="main">
    <section class="container-form">
        <section class="head">
            <img class="logo-nexa" src="../Images/Logos/Logo_Nexa.png" alt="Logo Nexa">
            <!--            <h2>Accueil Nexa</h2>-->
        </section>

        <section class="accueil">

            <section class="choice-form">
                <section class="choice-form__button">
                    <button class="inscriptionButton button" id="inscriptionButton" onclick="afficherFormulaire('inscription')">Inscription</button>
                    <button class="connexionButton button" id="connexionButton" onclick="afficherFormulaire('connexion')">Connexion</button>
                </section>
                <div id="message-erreur"></div>
            </section>


            <form  id="register" class="register" action="User/registerUser" method="post"> <!-- Formulaire inscription -->
                <h3>Inscription</h3>
                <div class="field">
                    <label for="username">Username :</label>
                    <section class="field-email">

                        <input type="text" id="username" name="username" class="" placeholder="Dylan_du_92" required>
                    </section>
                </div>

                <div class="field">
                    <label for="email">Email :</label>
                    <section class="field-email">
                        <input type="email" id="email" name="email" class="" placeholder="email@exemple.com" required>
                    </section>
                </div>

                <div class="field ">
                    <label for="mot_de_passe">Mot de passe :</label>
                    <section class="field-pswd">
                        <input type="password" name="mot_de_passe" id="mdp1" class="mdp field-pswd__mdp" required placeholder="********">
                        <!--                        <img src="Images/Form/oeil_ferme.png" id="mdp1-eye" class="checkpswd eye" onclick="togglePasswordVisibility('mdp1')">-->
                        <label class="switch ">
                            <input type="checkbox" class="" onclick="togglePasswordVisibility('mdp1')">
                            <span class="slider"></span>
                        </label>
                    </section>
                </div>

                <div class="inscription-connexion-button-container">
                    <input class="inscriptionButton button" type="submit" value="S'inscrire">
                </div>
            </form>

            <form id="connexion" class="connexion" action="User/loginUser" method="post"> <!-- Formulaire connexion -->
                <h3>Connexion</h3>
                <div class="field">
                    <label for="email">Email or Username :</label>
                    <section class="field-email">

                        <input class="" type="text" name="email" placeholder="nocly_" required><br>
                    </section>
                </div>

                <div class="field ">
                    <label for="mot_de_passe">Mot de passe :</label>
                    <section class="field-pswd">
                        <input type="password" name="mdp2" id="mdp2" class="mdp field-pswd__mdp" required placeholder="********">
                        <!--                        <img src="Images/Form/oeil_ferme.png" id="mdp2-eye" class="checkpswd eye" onclick="togglePasswordVisibility('mdp2')">-->
                        <label class="switch ">
                            <input type="checkbox" class="" onclick="togglePasswordVisibility('mdp2')">
                            <span class="slider"></span>
                        </label>
                    </section>
                </div>

                <a href="views/forgotPwd.php" class="forgotPwd">Mot de passe oublié ?</a>

                <div class="inscription-connexion-button-container">
                    <input class="connexionButton button" type="submit" value="Se connecter">
                </div>
            </form>
        </section>
    </section>
</section>
<?php include('footer.php'); ?>
<script src="../js/script.js"></script>
</body>
</html>
