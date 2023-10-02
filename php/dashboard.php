<?php
session_start();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'Inconnu';
$is_moderator = false;

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :user");
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $user_data = $stmt->fetch();

    if ($user_data && $user_data['is_moderator']) $is_moderator = true;

    $stmt = $conn->prepare("SELECT Post.*, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post) as LikeCount, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post AND Likes.user = :user) as user_liked FROM Post WHERE id_pere IS NULL ORDER BY Time DESC");
    $stmt->bindParam(':user', $user);
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
        <a href="profil.php" class="username-link">
            <?php if($is_moderator): ?>
                <img src="../Images/img_mod.png" alt="Modérateur" class="moderator-icon"/>
            <?php endif; ?>
            <?php echo $user; ?>
        </a>
    </div>
</header>

<main class="main-content">
    <section class="left-panel"></section>
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
                    <?php if($is_moderator && $post['user'] === $user): ?>
                        <img src="../Images/img_mod.png" alt="Modérateur" class="moderator-icon"/>
                    <?php endif; ?>
                    <img src="<?= empty($post['pp']) ? 'https://www.photoprof.fr/images_dp/photographes/profil_vide.jpg' : $post['pp']; ?>" alt="Photo de profil" class="post-pp">
                    <h3 class="post-username"><?= $post['user']; ?></h3>
                </div>
                <hr class="post-divider">
                <p class="post-content"><?= $post['contenu']; ?></p>
                <?php if(!empty($post['image'])): ?>
                    <img src="<?= $post['image']; ?>" alt="Image du post" class="post-image"/>
                <?php endif; ?>
                <div class="post-actions">
                    <button class="post-action like" data-id_post="<?= $post['id_post']; ?>" <?= $post['user_liked'] > 0 ? 'disabled' : '' ?>>❤️ <?= $post['LikeCount'] ?></button>
                    <button class="post-action comment" data-id_post="<?= $post['id_post']; ?>">💬 <?= $post['Comment']; ?></button>
                    <button class="post-action share">🔗 <?= $post['partage']; ?></button>
                    <?php if($is_moderator): ?>
                        <button class="post-action delete" data-id_post="<?= $post['id_post']; ?>">🗑</button>
                    <?php endif; ?>
                </div>
                <div id="commentModal<?= $post['id_post']; ?>" class="modal">
                    <div class="modal-content">
                        <form action="traitement_commentaire.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_pere" id="id_pere<?= $post['id_post']; ?>" value="<?= $post['id_post']; ?>">
                            <div class="input-container">
                                <label for="contenu">Commentaire :</label>
                                <textarea id="contenu" name="contenu"></textarea>
                            </div>
                            <input type="submit" value="Commenter">
                        </form>
                    </div>
                </div>
                <div class="comments-container" id="comments<?= $post['id_post']; ?>" style="display:none;">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM Post WHERE id_pere = :id_post ORDER BY Time");
                    $stmt->bindParam(':id_post', $post['id_post']);
                    $stmt->execute();
                    $comments = $stmt->fetchAll();
                    foreach($comments as $comment):
                        ?>
                        <div class="comment">
                            <p class="comment-content"><?= $comment['contenu']; ?></p>
                            <p class="comment-user"><?= $comment['user']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if($post['Comment'] > 0): ?>
                    <div class="comment-banner" data-id_post="<?= $post['id_post']; ?>">
                        <span>Voir les commentaires</span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<script src="../js/script_dash.js"></script>

</body>
</html>

