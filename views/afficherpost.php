<link rel="stylesheet" href="../css/afficherpost.css">



<?php
foreach ($posts as $post): ?>
    <div class="afficherpost">
        <a href="profilViewer.php?user=<?php echo $post['user']; ?>">
            <div class="post">
                <div class="post-header">
                    <img src="../<?php echo $post['user_pp']; ?>" alt="Photo de profil de l'utilisateur"
                        class="post-pp post-pp-hover">
                    <h3 class="post-username">
                        <?php echo $post['user']; ?>
                    </h3>
                </div>
        </a>
        <hr class="post-divider">
        <p class="post-content">
            <?php echo $post['contenu']; ?>
        </p>
        <?php if (!empty($post['image'])): ?>
            <img src="../<?php echo $post['image']; ?>" alt="Photo de profil" class="post-image" />
        <?php endif; ?>
    </div>
<?php endforeach; ?>