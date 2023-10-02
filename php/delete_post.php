<?php
header('Content-Type: application/json');
session_start();

// Log Debugging Information
error_log("delete_post.php accessed");

if(!isset($_SESSION['user'])) {
    // Log Debugging Information
    error_log("User not logged in");
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$user = $_SESSION['user'];

// Log Debugging Information
error_log("User: $user");

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :user");
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $user_data = $stmt->fetch();

    if(!$user_data || !$user_data['is_moderator']) {
        // Log Debugging Information
        error_log("User is not a moderator");
        echo json_encode(['success' => false, 'error' => 'Unauthorized']);
        exit;
    }

    // Log Debugging Information
    error_log("User is a moderator");

    $data = json_decode(file_get_contents('php://input'), true);
    $id_post = $data['id_post'];

    // Log Debugging Information
    error_log("Deleting post with id: $id_post");

    // Delete associated likes before deleting the post
    $stmt_likes = $conn->prepare("DELETE FROM Likes WHERE post_id = :id_post");
    $stmt_likes->bindParam(':id_post', $id_post);
    $stmt_likes->execute();

    // Log Debugging Information
    error_log("Associated likes deleted successfully");

    // Now delete the post
    $stmt_post = $conn->prepare("DELETE FROM Post WHERE id_post = :id_post");
    $stmt_post->bindParam(':id_post', $id_post);
    $stmt_post->execute();

    // Log Debugging Information
    error_log("Post deleted successfully");

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Log Debugging Information
    error_log("PDOException: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
