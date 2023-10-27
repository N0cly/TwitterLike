<?php
session_start();
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'err_user';

if ($_SESSION['username'] == 'err_user' || $_SESSION['utilisateur_connecte'] !== true || !isset($_SESSION['utilisateur_connecte'])) {
    header("Location: ../");
}
// Après que l'utilisateur se soit connecté avec succès

require_once('../ctrl/UserController.php');
$userCtrl = new UserController();
$user_data = $userCtrl->getUser($user);

//     Partie commentée pour récupérer les messages

require_once('../ctrl/PostController.php');
if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    // Utilisez maintenant la variable $postId comme ID de publication
} else {
    // Gérer le cas où le paramètre 'id' n'est pas présent dans l'URL
    header('dashboard.php');
}
$_SESSION['post_id'] = $postId;
$postCtrl = new PostController();
$post_fetch = $postCtrl->getPost($postId);
$post = $post_fetch;

require_once('../ctrl/CategorieController.php');
$categorieCtrl = new CategorieController();
$categorie_fetch = $categorieCtrl->getCategorieAll();
$categorieLeftPannel = $categorie_fetch;
$categorieRightPannel = $categorie_fetch;

$comments = $postCtrl->getComments($postId);

$is_moderator = $user_data['is_moderator'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nexa - Réseau Social</title>
    <link rel="stylesheet" href="../css/style_dash.css">
    <link rel="stylesheet" href="../css/user-preview.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nexa !">
    <meta name="author" content="Henricy Limosani Safran Amettler Zoppi Bedos">
    <link rel="icon" href="../Images/Logos/Logo_Nexa-smaller.png">
    <title>Nexa</title>
</head>

<body>

    <?php include('message_ESI.php'); ?>

    <header class="header">
        <div class="left-header">
            <button id="searchBtn" class="search-btn">🔍</button>
            <input type="text" id="searchInput" class="search-input" placeholder="Recherche...">
        </div>
        <a href="dashboard.php"><img src="../Images/Logos/Logo_Nexa.png" alt="Logo Nexa" class="logo-img"></a>

        <div class="user-icon">
            <i class="fas fa-user-circle"></i>
            <a href="profil.php" class="username-link">
                <img src="../<?php echo $user_data['pp']; ?>" alt="Profil" class="post-pp post-pp-hover">
                <span class="username-link">
                    <?php echo $user ?>
                </span>
            </a>
        </div>
    </header>

    <main class="main-content">

        <section class="right-panel">

            <!-- Affichage des publications -->

            <div class="post">
                <div class="post-header">
                    <img src="../<?php echo $post['user_pp']; ?>" alt="Photo de profil de l'utilisateur"
                        class="post-pp post-pp-hover">
                    <h3 class="post-username">
                        <?php echo $post['user']; ?>
                    </h3>
                </div>
                <hr class="post-divider">
                <a href="post.php?id=<?php echo $post['id_post']; ?>">
                    <p class="post-content">
                        <?php echo $post['contenu']; ?>
                    </p>
                    <?php if (!empty($post['image'])): ?>
                        <img src="../<?php echo $post['image']; ?>" alt="Photo de profil" class="post-image" />
                    <?php endif; ?>
                </a>
            </div>
        </section>
        <section class="comments">
            <h2>Commentaires</h2>
            <form action="../Post/sendComment" method="post">
                <textarea name="contenu" placeholder="Ajouter un commentaire"></textarea>
                <input type="submit" value="Publier">
            </form>
            <?php foreach ($comments as $comment): ?>
                <div class="post">
                    <div class="post-header">
                        <img src="../<?php echo $comment['user_pp']; ?>"
                            alt="Photo de profil de l'utilisateur qui a commenté" class="post-pp post-pp-hover">
                        <h3 class="post-username">
                            <?php echo $comment['user']; ?>
                        </h3>
                    </div>
                    <p class="post-content">
                        <?php echo $comment['contenu']; ?>
                    </p>

                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <script src="../js/script_dash.js"></script>

</body>

</html>