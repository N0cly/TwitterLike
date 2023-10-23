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

require_once('../ctrl/CategorieController.php');
$categorieCtrl = new CategorieController();
$categorie_fetch = $categorieCtrl->getCategorieAll();
$categorie = $categorie_fetch;

$is_moderator = $user_data['is_moderator'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nexa - Réseau Social</title>
    <link rel="stylesheet" href="../css/style_dash.css">
    <link rel="stylesheet1" href="../css/user-preview.css">
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
                <?php if ($is_moderator): ?>
                    <img src="../Images/icon/modo.png" alt="Modérateur" class="moderator-icon">
                <?php endif; ?>
                <span class="username-link">
                    <?php echo $user ?>
                </span>
            </a>
        </div>


    </header>

    <main class="main-content">
        <section class="left-panel">

            <h2 class="section-title">Ajouter une catégorie</h2>
            <form id="addCategoryForm" class="category-form" action="../Categorie/ajouterCategorie" method="post">
                <input type="text" name="nom_categorie" id="newCategory" class="category-input"
                    placeholder="Nouvelle catégorie" required>
                <input type="text" name="libelle" id="newLibelle" class="category-input"
                    placeholder="Libellé de la catégorie" required>
                <button type="submit" class="category-button">Ajouter</button>
            </form>

            <h2 class="section-title">Catégories</h2>
            <ul id="categoryList" class="category-list">
                <?php
                foreach ($categorie as $categorie): ?>
                    <h3 class="category-item">
                        <?php echo $categorie['nom_categorie']; ?>
                    </h3>
                <?php endforeach; ?>
            </ul>

            <h2 class="section-title">Supprimer une catégorie</h2>
            <form id="removeCategoryForm" class="category-form" action="../Categorie/removeCategorie" method="post">
                <input type="text" name="nom_categorie" id="newCategory" class="category-input"
                    placeholder="Catégorie à supprimer" required>
                <button type="submit" class="category-button">Supprimer</button>
            </form>
        </section>


        <section class="right-panel">
            <button id="ouvrirPublication" class="button">Nouvelle publication</button>
            <div id="modal" class="modal">
                <div class="modal-content">
                    <form action="../Post/sendPost" method="post" enctype="multipart/form-data">
                        <div class="input-container">
                            <label for="contenu">Contenu :</label>
                            <textarea id="contenu" name="contenu"></textarea>
                        </div>
                        <div class="input-container">
                            <label for="image">Image :</label>
                            <input type="file" id="image" name="image">
                        </div>
                        <div class="input-container">
                            <label for="choix-couleur">Choisissez une catégorie :</label>
                            <select id="choix-couleur">
                                <option value="rouge">Rouge</option>
                                <option value="vert">Vert</option>
                                <option value="bleu">Bleu</option>
                                <option value="jaune">Jaune</option>
                            </select>
                        </div>
                        <input type="submit" value="Publier">
                    </form>
                </div>
            </div>

            <?php
            // Partie commentée pour afficher les messages
            foreach ($posts as $post): ?>
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
                            <?php echo $post['Comment']; ?>
                        </button>
                        <button class="post-action share">🔗
                            <?php echo $post['partage']; ?>
                        </button>
                        <?php if ($is_moderator): ?>
                            <button class="post-action delete" data-id_post="<?php echo $post['id_post']; ?>">🗑</button>
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
                    <div class="comments-container" id="comments<?php echo $post['id_post']; ?>" style="display:none;">
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
        </section>
    </main>

    <script src="../js/script_dash.js"></script>

</body>

</html>