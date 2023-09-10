<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Validez les informations de connexion dans la base de données (vous devez configurer votre connexion à la base de données)
    // $db = new PDO("mysql:host=hostname;dbname=database", "username", "password");
    // $query = "SELECT * FROM utilisateurs WHERE email = ? AND mot_de_passe = ?";
    // $stmt = $db->prepare($query);
    // $stmt->execute([$email, $mot_de_passe]);

    // Si l'utilisateur est trouvé, vous pouvez gérer la session et le rediriger vers une page de tableau de bord
    // Sinon, affichez un message d'erreur

    // Exemple basique de redirection
    if ($email ==="enzo.bedos@nocly.fr" && $mot_de_passe === "test") {
        session_start();
        $_SESSION["utilisateur_connecte"] = true; // Vous pouvez stocker des informations sur l'utilisateur connecté ici
        header("Location: dashboard.php");
        exit;
    } else {
        $erreurMessage = "Adresse email ou mot de passe incorrect.";
        header("Location: connexion.php?erreur=$erreurMessage");
        exit;
    }
}
?>
