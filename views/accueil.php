<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page de connexion">
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


            <form  id="register" class="register" action="index.php?user=registerUser" method="post"> <!-- Formulaire inscription -->
                <h3>Inscription</h3>
                <div class="field">
                    <label for="username">Username :</label>
                    <section class="field-email">

                        <input type="text" id="username" name="username" class="" required>
                    </section>
                </div>

                <div class="field">
                    <label for="email">Email :</label>
                    <section class="field-email">
                        <input type="email" id="email" name="email" class="" required >
                    </section>
                </div>

                <div class="field ">
                    <label for="mot_de_passe">Mot de passe :</label>
                    <section class="field-pswd">
                        <input type="password" id="mdp1" name="mot_de_passe" class="mdp field-pswd__mdp" required>
                        <input type="checkbox" class="checkpswd" onclick="togglePasswordVisibility('mdp1')">
                    </section>
                </div>

                <div class="inscription-connexion-button-container">
                    <input class="inscriptionButton button" type="submit" value="S'inscrire">
                </div>

            </form>



            <form id="connexion" class="connexion" action="index.php?user=loginUser" method="post"> <!-- Formulaire connexion -->
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
                        <input type="password" name="mot_de_passe" id="mdp2" class="mdp field-pswd__mdp" required placeholder="********">
                        <input type="checkbox" class="checkpswd" onclick="togglePasswordVisibility('mdp2')">
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
<footer class="NexaInformation">
    <h2>A Propos de Nexa</h2>
</footer>
<script src="../js/script.js"></script>
</body>
</html>