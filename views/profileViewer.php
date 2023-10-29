<?php
session_start();
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'err_user';

if ($_SESSION['username'] == 'err_user' || $_SESSION['utilisateur_connecte'] !== true || !isset($_SESSION['utilisateur_connecte'])) {
    header("Location: ../");
}

$userViewed = $_GET['user'];

require_once('../ctrl/UserController.php');
$userCtrl = new UserController();
$user_data = $userCtrl->getUser($user);

//     Partie commentée pour récupérer les messages

require_once('../ctrl/PostController.php');
$postCtrl = new PostController();
$posts = $postCtrl->getAllPostsUser($userViewed);

$userCtrl->getUser($userViewed);

$is_moderator = $user_data['is_moderator'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nexa - Réseau Social</title>
    <link rel="stylesheet" href="../css/style_dash.css">
    <link rel="stylesheet1" href="../css/user-preview.css">
    <link href="../css/profil.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nexa !">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../Images/Logos/Logo_Nexa-smaller.png">
    <title>Nexa</title>
</head>

<?php include('message_ESI.php'); ?>

<header class="header">
    <div class="left-header">
        <button id="searchBtn" class="search-btn">🔍</button>
        <input type="text" id="searchInput" class="search-input" placeholder="Recherche...">
    </div>
    <a href="dashboard.php"><img src="../Images/Logos/Logo_Nexa.png" alt="Logo Nexa" class="logo-img"></a>

    <div class="user-icon">
        <i class="fas fa-user-circle"></i>
        <a href="profil.php" class="username-link"><img src="../<?php echo $user_data['pp']; ?>" alt="Profil"
                class="post-pp post-pp-hover"></a>
        <?php echo $user; ?>
        </a>
    </div>
</header>

<body>
    <main>
        <!-- Contenu principal de la page -->
        <section class="profile">
            <div class="profile-info">
                <img src="../<?php echo $user_data['pp']; ?>" alt="Photo de profil" class="pp pp-hover">
                <h1>
                    <?php echo $user; ?>
                </h1>
                <?php if ($is_moderator == 1): ?>
                    <h4>Modérateur</h4>
                <?php endif; ?>
                <p>
                    <?php echo $user_data['description']; ?>
                </p>
                <a href="modifier_profil.php">Modifier le profil</a>
            </div>
            <div class="profile-posts">
                <!-- Affichage des publications de l'utilisateur -->
                <h2>Publications récentes</h2>
                <div class="post">
                    <?php foreach ($posts as $post): ?>
                        <div class="post">
                            <div class="post-header">
                                <img src="../<?php echo $post['user_pp']; ?>" alt="Photo de profil de l'utilisateur"
                                    class="post-pp post-pp-hover">
                                <h3 class="post-username">
                                    <?php echo $post['user']; ?>
                                </h3>
                            </div>
                            <hr class="post-divider">
                            <p class="post-content">
                                <?php echo $post['contenu']; ?>
                            </p>
                            <?php if (!empty($post['image'])): ?>
                                <img src="../<?php echo $post['image']; ?>" alt="Photo de profil" class="post-image" />
                            <?php endif; ?>
                            <div class="post-actions">
                                <button class="post-action like" data-id_post="<?php echo $post['id_post']; ?>" <?php echo $post['user_liked'] > 0 ? 'disabled' : ''; ?>>❤️
                                    <?php echo $post['LikeCount']; ?>
                                </button>
                                <button class="post-action comment" data-id_post="<?php echo $post['id_post']; ?>">💬
                                    <?php echo array_key_exists('Comment', $post) ? $post['Comment'] : ''; ?>
                                </button>
                                <button class="post-action share">🔗
                                    <?php echo array_key_exists('partage', $post) ? $post['partage'] : ''; ?>
                                </button>
                                <?php if ($is_moderator): ?>
                                    <button class="post-action delete"
                                        data-id_post="<?php echo $post['id_post']; ?>">🗑</button>
                                <?php endif; ?>
                            </div>
                            <div id="commentModal<?php echo $post['id_post']; ?>" class="modal">
                                <div class="modal-content">
                                    <form action="traitement_commentaire.php" method="post" enctype="multipart/form-data">

                                        <input type="hidden" name="id_pere" id="id_pere<?php echo $post['id_post']; ?>"
                                            value="<?php echo $post['id_post']; ?>">
                                        <div class="input-container">
                                            <label for="contenu">Commentaire :</label>
                                            <textarea id="contenu" name="contenu"></textarea>
                                        </div>
                                        <input type="submit" value="Commenter">
                                    </form>
                                </div>
                            </div>
                            <div class="comments-container" id="comments<?php echo $post['id_post']; ?>"
                                style="display:none;">
                                <?php
                                $comments = $postCtrl->getComments($post['id_post']);
                                foreach ($comments as $comment):
                                    ?>
                                    <div class="comment">
                                        <p class="comment-content">
                                            <?php echo $comment['contenu']; ?>
                                        </p>
                                        <p class="comment-user">
                                            <?php echo $comment['user']; ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
</body>

</html>