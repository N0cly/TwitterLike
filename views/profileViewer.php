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
$userViwed_data = $userCtrl->getUser($userViewed);


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

<?php include('header.php'); ?>


<body>
    <main>
        <!-- Contenu principal de la page -->
        <section class="profile">
            <div class="profile-info">
                <img src="../<?php echo $userViwed_data['pp']; ?>" alt="Photo de profil" class="pp pp-hover">
                <h1>
                    <?php echo $userViewed; ?>
                </h1>
                <?php if ($userViwed_data['is_moderator'] == 1): ?>
                    <h4>Modérateur</h4>
                <?php endif; ?>
                <p>
                    <?php echo $userViwed_data['description']; ?>
                </p>
            </div>
            <div class="profile-posts">
                <!-- Affichage des publications de l'utilisateur -->
                <h2>Publications récentes</h2>

                <?php include('afficherpost.php'); ?>
            </div>
        </section>
    </main>
</body>

</html>