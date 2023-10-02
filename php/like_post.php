<?php
header('Content-Type: application/json');
session_start();

if(!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    $id_post = $data['id_post'];
    $user = $_SESSION['user'];

    // Vérifier si l'utilisateur a déjà "liké" ce post
    $stmt_check = $conn->prepare('SELECT * FROM Likes WHERE post_id = :post_id AND user = :user');
    $stmt_check->execute([':post_id' => $id_post, ':user' => $user]);

    if($stmt_check->fetch()) {
        // Si l'utilisateur a déjà "liké" ce post, le "like" est retiré
        $stmt = $conn->prepare('DELETE FROM Likes WHERE post_id = :post_id AND user = :user');
        $stmt->execute([':post_id' => $id_post, ':user' => $user]);

        // Mettre à jour le compteur de "likes" dans la table Post
        $stmt_update = $conn->prepare('UPDATE Post SET Like = Like - 1 WHERE id_post = :id_post');
        $stmt_update->execute([':id_post' => $id_post]);

        echo json_encode(['success' => true, 'action' => 'unliked']);
    } else {
        // Si l'utilisateur n'a pas encore "liké" ce post, un "like" est ajouté
        $stmt = $conn->prepare('INSERT INTO Likes (post_id, user) VALUES (:post_id, :user)');
        $stmt->execute([':post_id' => $id_post, ':user' => $user]);

        // Mettre à jour le compteur de "likes" dans la table Post
        $stmt_update = $conn->prepare('UPDATE Post SET Like = Like + 1 WHERE id_post = :id_post');
        $stmt_update->execute([':id_post' => $id_post]);

        echo json_encode(['success' => true, 'action' => 'liked']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
