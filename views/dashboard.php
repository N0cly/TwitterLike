<?php
session_start();
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Inconnu';
//$is_moderator = false;

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    require_once('../ctrl/UserController.php');

    $userCtrl = new UserController();
    $user_data = $userCtrl->getUser($user);

    // if ($user_data && $user_data['is_moderator']) $is_moderator = true;

//     Partie commentée pour récupérer les messages
    $stmt = $conn->prepare("SELECT Post.*, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post) as LikeCount, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post AND Likes.user = :user) as user_liked FROM Post WHERE id_pere IS NULL ORDER BY Time DESC");
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $posts = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$is_moderator = $user_data['is_moderator'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nexa - Réseau Social</title>
    <link rel="stylesheet" href="../css/style_dash.css">
    <link rel="stylesheet1" href="../css/user-preview.css">
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
                <img src="../Images/icon/modo.png" alt="Modérateur" class="moderator-icon"/>
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
                    </div>
                    <div class="input-container">
                        <label for="image">Image :</label>
                        <input type="file" id="image" name="image">
                    </div>
                    <input type="submit" value="Publier">
                </form>
            </div>
        </div>

        <?php
        // Partie commentée pour afficher les messages
        foreach($posts as $post): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?php echo empty($post['pp']) ? 'https://www.photoprof.fr/images_dp/photographes/profil_vide.jpg' : $post['pp']; ?>" alt="Photo de profil" class="post-pp post-pp-hover">
                    <h3 class="post-username"><?php echo $post['user']; ?></h3>
                </div>
                <hr class="post-divider">
                <p class="post-content"><?php echo $post['contenu']; ?></p>
                <?php if(!empty($post['image'])): ?>
                    <img src="<?php echo $post['image']; ?>" alt="Image du post" class="post-image"/>
                <?php endif; ?>
                <div class="post-actions">
                    <button class="post-action like" data-id_post="<?php echo $post['id_post']; ?>" <?php echo $post['user_liked'] > 0 ? 'disabled' : ''; ?>>❤️ <?php echo $post['LikeCount']; ?></button>
                    <button class="post-action comment" data-id_post="<?php echo $post['id_post']; ?>">💬 <?php echo $post['Comment']; ?></button>
                    <button class="post-action share">🔗 <?php echo $post['partage']; ?></button>
                    <?php if($is_moderator): ?>
                        <button class="post-action delete" data-id_post="<?php echo $post['id_post']; ?>">🗑</button>
                    <?php endif; ?>
                </div>
                <div id="commentModal<?php echo $post['id_post']; ?>" class="modal">
                    <div class="modal-content">
                        <form action="traitement_commentaire.php" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="id_pere" id="id_pere<?php echo $post['id_post']; ?>" value="<?php echo $post['id_post']; ?>">
                            <div class="input-container">
                                <label for="contenu">Commentaire :</label>
                                <textarea id="contenu" name="contenu"></textarea>
                            </div>
                            <input type="submit" value="Commenter">
                        </form>
                    </div>
                </div>
                <div class="comments-container" id="comments<?php echo $post['id_post']; ?>" style="display:none;">
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM Post WHERE id_pere = :id_post ORDER BY Time");
                    $stmt->bindParam(':id_post', $post['id_post']);
                    $stmt->execute();
                    $comments = $stmt->fetchAll();
                    foreach($comments as $comment):
                        ?>
                        <div class="comment">
                            <p class="comment-content"><?php echo $comment['contenu']; ?></p>
                            <p class="comment-user"><?php echo $comment['user']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- La bannière "Afficher les commentaires" est générée par JavaScript, donc pas besoin ici -->
            </div>
        <?php endforeach; ?>
    </section>
</main>

<script src="../js/script_dash.js"></script>

</body>
</html>
