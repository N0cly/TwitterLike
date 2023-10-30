<?php
// Partie commentée pour afficher les messages
foreach ($posts as $post): ?>
    <a href="profileViewer.php?user=<?php echo $post['user']; ?>">
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
        <a class="post-action comment" href="post.php?id=<?php echo $post['id_post']; ?>">💬</a>
        <button class="post-action share">🔗
            <?php echo $post['partage']; ?>
        </button>
        <?php if ($is_moderator == 1): ?>
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
    </a>
    </div>
<?php endforeach; ?>