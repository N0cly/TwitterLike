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
$postCtrl = new PostController();
$post_fetch = $postCtrl->getPostsAll($user);



$posts = $post_fetch;
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
    <meta charset="utf-8">
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
    <img src="../Images/Logos/Logo_Nexa.png" alt="Logo Nexa" class="logo-img">
    <div class="user-icon">
        <i class="fas fa-user-circle"></i>
        <a href="profil.php" class="username-link"><img
                src="https://www.photoprof.fr/images_dp/photographes/profil_vide.jpg" alt="Profil"
                class="post-pp post-pp-hover"></a>
        <?php if ($is_moderator): ?>
            <img src="../Images/icon/modo.png" alt="Modérateur" class="moderator-icon" />
        <?php endif; ?>
        <?php echo $user; ?>
        </a>
    </div>
</header>

<body>
    <main>
        <!-- Contenu principal de la page -->
        <section class="profile">
            <div class="profile-info">
                <img src="chemin/vers/image_profil.jpg" alt="Photo de profil">
                <h1>
                    <?php echo $user; ?>
                </h1>
                <p>Description ou informations sur l'utilisateur</p>
                <a href="modifier_profil.php">Modifier le profil</a>
            </div>
            <div class="profile-posts">
                <!-- Affichage des publications de l'utilisateur -->
                <h2>Publications récentes</h2>
                <div class="post">
                    <img src="chemin/vers/image_post.jpg" alt="Image de la publication">
                    <p>Contenu de la publication</p>
                </div>
                <!-- Répéter cette structure pour afficher d'autres publications -->
            </div>
        </section>
    </main>
</body>


</html>