<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Inconnu';


try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM Post ORDER BY Time DESC");
    $stmt->execute();
    $posts = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nexa - Réseau Social</title>
    <link rel="stylesheet" href="../css/style_dash.css">
</head>
<body>

<header class="header">
    <div class="left-header">
        <img src="../Images/Logos/Logo_Nexa-smaller.png" alt="Logo Nexa" class="logo-img">
        <button id="searchBtn" class="search-btn">🔍</button>
        <input type="text" id="searchInput" class="search-input" placeholder="Recherche...">
    </div>
    <div class="user-icon">
        <i class="fas fa-user-circle"></i>
        <a href="profil.php" class="username-link"><?php echo $user; ?></a>
    </div>
</header>

<main class="main-content">
    <section class="left-panel">
    </section>
    <section class="right-panel">
        <button id="ouvrirPublication">Nouvelle publication</button>
        <div id="modal" class="modal">
            <div class="modal-content">
                <form action="traitement_publication.php" method="post" enctype="multipart/form-data">
                    <div class="input-container">
                        <label for="contenu">Contenu :</label>
                        <textarea id="contenu" name="contenu"></textarea>
                        <button id="effacerContenu" type="button" class="modal-button">✖</button>
                    </div>
                    <div class="input-container">
                        <label for="image">Image :</label>
                        <input type="file" id="image" name="image">
                        <button id="effacerImage" type="button" class="modal-button">✖</button>
                    </div>
                    <input type="submit" value="Publier">
                </form>
            </div>
        </div>
        <?php foreach($posts as $post): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?= empty($post['pp']) ? 'https://www.photoprof.fr/images_dp/photographes/profil_vide.jpg' : $post['pp']; ?>" alt="Photo de profil" class="post-pp">
                    <h3 class="post-username"><?= $post['user']; ?></h3>
                </div>
                <hr class="post-divider">
                <p class="post-content"><?= $post['contenu']; ?></p>
                <div class="post-actions">
                    <button class="post-action like" data-id_post="<?= $post['id_post']; ?>">❤️ <?= isset($post['Like']) ? $post['Like'] : 0; ?></button>
                    <button class="post-action comment">💬 <?= $post['Comment']; ?></button>
                    <button class="post-action share">🔗 <?= $post['partage']; ?></button>
                </div>
            </div>
        <?php endforeach; ?>


    </section>
</main>

<script src="../js/script_dash.js"></script>

</body>
</html>
