<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
<h1>Inscription</h1>
<form action="traitement_inscription.php" method="post">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" required><br>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" name="mot_de_passe" required><br>

    <input type="submit" value="S'inscrire">
</form>
</body>
</html>