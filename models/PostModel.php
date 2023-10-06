<?php

namespace Model;

use PDO;
use PDOException;
class PostModel
{

    public function connectDB()
    {
        try {
            $db = new PDO('sqlite:/amuhome/b22002844/PhpstormProjects/TwitterLike/db/db_nexa.sqlite');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function getPostsAll($user)
    {
        $query = "SELECT Post.*, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post) as LikeCount, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post AND Likes.user = :user) as user_liked FROM Post WHERE id_pere IS NULL ORDER BY Time DESC";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        return $posts;
    }

    public function getPosts()
    {
        $query = "SELECT * FROM Post ORDER BY Time DESC";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getPost($id_post)
    {
        $query = "SELECT * FROM Post WHERE id_post = :id_post";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getPostLikes($id_post)
    {
        $query = "SELECT COUNT(*) as LikeCount FROM Likes WHERE post_id = :id_post";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['LikeCount'];
    }

    public function getPostUserLiked($id_post, $user)
    {
        $query = "SELECT COUNT(*) as user_liked FROM Likes WHERE post_id = :id_post AND user = :user";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':id_post', $id_post, PDO::PARAM_INT);
        $stmt->bindParam(':user', $user, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['user_liked'] == 1;
    }



    public function createPost($user, $contenu, $image)
    {
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = '../uploads/';

            // Assurez-vous que le répertoire de téléchargement existe
            if(!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Déplace le fichier téléchargé vers le répertoire de téléchargement
            $image = $uploadDir . basename($_FILES['image']['name']);
            if(!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                // Si le déplacement du fichier échoue, réinitialise $imagePath à null
                $image = null;
            }
        }

        $query = "INSERT INTO Post (user, contenu, image, Time) VALUES (:username, :contenu, :image, datetime('now'))";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: ../views/dashboard.php");

    }

    public function getAllPosts()
    {
        $query = "SELECT * FROM Post ORDER BY Time DESC";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getComments($id_pere)
    {
        $query = "SELECT * FROM Post WHERE id_pere = :id_pere ORDER BY Time";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':id_pere', $id_pere);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }
}