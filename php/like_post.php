<?php
header('Content-Type: application/json');

try {
    $conn = new PDO("sqlite:../db/db_nexa.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    $id_post = $data['id_post'];

    $sql = "UPDATE Post SET 'Like' = Like + 1 WHERE id_post = :id_post";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer le nouveau compteur de likes
    $sql = "SELECT Like FROM Post WHERE id_post = :id_post";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
    $stmt->execute();

    $newLikeCount = $stmt->fetchColumn();
    echo json_encode(['success' => true, 'newLikeCount' => $newLikeCount]);

} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
