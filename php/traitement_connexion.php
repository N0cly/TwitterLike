<?php
if (isset($_SERVER['REQUEST_METHOD']) &&
    $_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    try {
        $db = new PDO('sqlite:../db/db_nexa.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }

    $query = "SELECT * FROM users WHERE (email = :email OR username = :username) AND mdp = :mot_de_passe";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':username', $email, PDO::PARAM_STR);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
    $stmt->execute();

    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        // Les informations de connexion sont correctes, vous pouvez gérer la session de l'utilisateur ici
        // Par exemple, en utilisant $_SESSION
        session_start();
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['email'] = $utilisateur['email'];
        $_SESSION['user'] = $utilisateur['username'];
        //$_SESSION["email_utilisateur"] = $email; // Stockez l'e-mail dans la session

        // Redirigez l'utilisateur vers la page de tableau de bord ou autre
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: ../index.php?erreur=1');
        $messageErreur = "Nom d'utilisateur ou mot de passe incorrect.";
        echo '<script>';
        echo 'document.getElementById("message-erreur").innerHTML = "' . $messageErreur . '";';
        echo 'document.getElementById("message-erreur").classList.add("erreur-message");';
        echo '</script>';
        // Les informations de connexion sont incorrectes, affichez un message d'erreur ou redirigez vers la page de connexion
        exit;
    }

}
?>
