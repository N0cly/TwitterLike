<?php
session_start();

// Vérifiez d'abord si l'utilisateur est connecté
if (!isset($_SESSION["utilisateur_connecte"]) || $_SESSION["utilisateur_connecte"] !== true) {
    header("Location: ../index.php");
    exit;
}

// Récupérez l'e-mail de la session
$username = $_SESSION["user"];

// Exemple de données de publications et de suggestions d'amis (vous devez les remplacer par des données réelles depuis votre base de données)
$publications = array(
    array("Utilisateur 1", "Contenu de la publication 1..."),
    array("Utilisateur 2", "Contenu de la publication 2..."),
    // Ajoutez d'autres publications ici
);

$suggestions_amis = array(
    "Ami suggéré 1",
    "Ami suggéré 2",
    "Ami suggéré 3",
    // Ajoutez d'autres amis suggérés ici
);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexa - Réseau Social</title>
    <link rel="stylesheet" href="../css/style_dash.css">
    <script src="../js/script_dash.js" defer></script>
</head>
<body>

<header class="header">
    <div class="left-header">
        <img src="../Images/Logos/Logo_Nexa-smaller.png" alt="Logo Nexa" class="logo-img">
        <button id="searchBtn" class="search-btn"><i class="fas fa-search"></i></button>
        <input type="text" id="searchInput" class="search-input" placeholder="Recherche...">
    </div>
    <div class="user-icon">
        <i class="fas fa-user-circle"></i>
        <a href="profil.php" class="username-link"><?php echo $username; ?></a>
    </div>
</header>

<main class="main-content">
    <section class="left-panel">
        <!-- Stories content here -->
    </section>
    <section class="right-panel">
        <button id="ouvrirPublication" class="new-post">Nouvelle publication</button>

        <div id="modal" class="modal">
            <div id="formulairePublication" class="modal-content">
                <form action="traitement_publication.php" method="post" enctype="multipart/form-data">
                    <label for="contenu">Contenu :</label>
                    <div class="input-container">
                        <textarea id="contenu" name="contenu" rows="4" cols="50"></textarea>
                        <button id="effacerContenu" type="button">✖</button>
                    </div><br>
                    <label for="image">Image :</label>
                    <div class="input-container">
                        <input type="file" id="image" name="image">
                        <button id="effacerImage" type="button">✖</button>
                    </div><br>
                    <input type="submit" value="Publier">
                </form>
            </div>
        </div>

        <!-- Posts content here -->
    </section>
</main>

</body>
</html>


