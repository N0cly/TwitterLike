<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    try {
        $db = new PDO('sqlite:../db/db_nexa.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion à la base de données : ' . $e->getMessage());
    }



    $query = "SELECT * FROM users WHERE email = :email AND mdp = :mot_de_passe";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
    $stmt->execute();

    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        // Les informations de connexion sont correctes, vous pouvez gérer la session de l'utilisateur ici
        // Par exemple, en utilisant $_SESSION
        session_start();
        $_SESSION['utilisateur_connecte'] = true;
        $_SESSION['email'] = $utilisateur['email'];
        $_SESSION['user'] = $utilisateur['user'];
        $_SESSION["email_utilisateur"] = $email; // Stockez l'e-mail dans la session

        // Redirigez l'utilisateur vers la page de tableau de bord ou autre
        header('Location: dashboard.php');
        exit;
    } else {
        // Les informations de connexion sont incorrectes, affichez un message d'erreur ou redirigez vers la page de connexion
        header('Location: ../index.php?erreur=1');
        exit;
    }

    // Validez les informations de connexion dans la base de données (vous devez configurer votre connexion à la base de données)
    // $db = new PDO("mysql:host=hostname;dbname=database", "username", "password");
    // $query = "SELECT * FROM utilisateurs WHERE email = ? AND mot_de_passe = ?";
    // $stmt = $db->prepare($query);
    // $stmt->execute([$email, $mot_de_passe]);

    // Si l'utilisateur est trouvé, vous pouvez gérer la session et le rediriger vers une page de tableau de bord
    // Sinon, affichez un message d'erreur

    // Exemple basique de redirection
    //if ($email ==="enzo.bedos@nocly.fr" || $email === "nocly_" && $mot_de_passe === "test") {
    //    session_start();
    //    $_SESSION["utilisateur_connecte"] = true; // Vous pouvez stocker des informations sur l'utilisateur connecté ici
    //    $_SESSION["email_utilisateur"] = $email; // Stockez l'e-mail dans la session
    //    header("Location: dashboard.php");
   //     exit;
   // } else {
    //    $erreurMessage = "Adresse email ou mot de passe incorrect.";
   //     header("Location: ConnectPage.php?erreur=$erreurMessage");
    //    exit;
   // }
}
?>
