<?php



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
            <h2>Changez votre mot de passe</h2>
        </section>
        <!-- Formulaire -->
        <section class="choice-form">
            <form method="post" action="../index.php?user=changeMDP">

                <section class=confirmPassword>
                    <label for="newMDP">Entrez votre nouveau mot de passe :</label>
                    <input type="password" name="newMDP" required>
                </section>

                <section class=confirmPassword>
                    <label for="confirmNewMDP">Confirmez votre nouveau mot de passe :</label>
                    <input type="password" name="confirmNewMDP" required>
                </section>

                <input class="connexionButton button" type="submit" value="Changer de mot de passe">
            </form>

        </section>
    </section>
</body>

</html>