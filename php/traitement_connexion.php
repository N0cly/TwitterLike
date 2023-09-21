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

    $query = "SELECT * FROM users WHERE email = :email OR username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':username', $email, PDO::PARAM_STR); // Vous avez utilisé le même paramètre ici

    if ($stmt->execute()) {
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mdp'])) {
            // Le mot de passe correspond, vous pouvez continuer avec l'authentification
            // ...
        } else {
            // Le mot de passe ne correspond pas, affichez un message d'erreur ou redirigez
            header('Location: login.php?erreur=mauvais_mot_de_passe');
            exit;
        }
    } else {
        // Une erreur s'est produite lors de l'exécution de la requête SQL
        echo 'Erreur SQL : ' . $stmt->errorInfo()[2];
    }

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
