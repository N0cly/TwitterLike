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
        <div class="post-actions">
            <button class="post-action like" data-id_post="<?php echo $post['id_post']; ?>" <?php echo $post['user_liked'] > 0 ? 'disabled' : ''; ?>>❤️
                <?php echo $post['LikeCount']; ?>
            </button>
            <a id="post-link" class="post-action comment" href="post.php?id=<?php echo $post['id_post']; ?>">💬</a>
            <button class="post-action share" id="copy-link">🔗</button>
            <?php if ($is_moderator == 1 || $post['user'] == $user): ?>
                <a class="post-action delete" href="supprimerPost.php?id=<?php echo $post['id_post']; ?>">🗑</a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>