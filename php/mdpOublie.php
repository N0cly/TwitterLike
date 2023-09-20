

<?php
//Avant de pouvoir l'utiliser, nous devons vérifier les points suivants :
//La fonction mail() est bien activée par l'hébergeur.
//Pour le vérifier, il suffit de regarder son phpinfo() : Le serveur SMTP est correctement configuré.

if (isset($_SERVER['REQUEST_METHOD']) &&
    $_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'adresse e-mail soumise par l'utilisateur
    $email = $_POST["email"];

    try {
        $db = new PDO('sqlite:../db/db_nexa.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    // Vérifier si l'adresse e-mail existe dans la base de données (vous devez implémenter cette vérification)

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() < 0) {
        // L'email n'éxiste pas dans la bd, affichez un message d'erreur ou redirigez l'utilisateur
        header('Location: inscription.php?erreur=non_inscrit');
//        echo "email existe pas";
        exit;
    } else {

        // Générer un code de réinitialisation aléatoire
        $uniqid = uniqid( true);
        $code = strtoupper(substr($uniqid, -5));

        $query = "UPDATE users SET codeMDPOublie = :code WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();


        // Envoyer l'e-mail avec le code de réinitialisation==
        $subject = "Réinitialisation de mot de passe";
        $message = "Votre code de réinitialisation de mot de passe est : " . $code;
        $headers = "From: no-replay@nexa.nocly.fr";
        mail($email, $subject, $message, $headers);

        // Rediriger l'utilisateur vers la page de réinitialisation de mot de passe
        header("Location: reinitialisationMDP.php");
        exit;
    }

}
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
<h2>Mot de passe oublié</h2>
<p>Entrez votre adresse e-mail pour recevoir un code de réinitialisation.</p>
<form method="post">
    <label for="email">Adresse e-mail :</label>
    <input type="email" name="email" required>
    <input type="submit" value="Envoyer le code de réinitialisation">
</form>
</body>

</html>
