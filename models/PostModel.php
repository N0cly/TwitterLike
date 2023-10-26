<?php

namespace Model;

use PDO;
use PDOException;

class PostModel
{

    public function connectDB()
    {

        $path = __DIR__ . "/../db/db_nexa.sqlite";
        try {
            $db = new PDO('sqlite:' . $path);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
            session_start();
            $_SESSION["error_message"] = "Connexion impossible a la DB !";
            header('Location: ../index.php');
            exit;
        }
    }

    public function getPostsAll($user)
    {
        $query = "SELECT Post.*, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post) as LikeCount, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post AND Likes.user = :user) as user_liked, Users.pp AS user_pp FROM Post LEFT JOIN Users ON Post.user = Users.username WHERE id_pere IS NULL ORDER BY Time DESC";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $posts = $stmt->fetchAll();

        return $posts;
    }


    public function getPost($id_post)
    {
        $query = "SELECT Post.*, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post) as LikeCount, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post AND Likes.user = :user) as user_liked, Users.pp AS user_pp FROM Post LEFT JOIN Users ON Post.user = Users.username WHERE Post.id_post = :id_post"; // Changement de :post_id à :id_post
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



    public function createPost($user, $contenu, $image, $categorie)
    {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = 'uploads/';

            // Assurez-vous que le répertoire de téléchargement existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Générez un nom de fichier unique pour éviter les collisions
            $imageFileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageFileName;

            // Déplace le fichier téléchargé vers le répertoire de téléchargement
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                // Si le déplacement du fichier échoue, réinitialisez $imagePath à null
                $imagePath = null;
            }
        } else {
            $imagePath = null;
        }

        $query = "SELECT pp FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->execute();
        $pp = $stmt->fetchColumn();


        $query = "INSERT INTO Post (user, contenu, image, Time, pp, categorie) VALUES (:username, :contenu, :image, datetime('now'), :pp, :categorie)";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':pp', $pp, PDO::PARAM_STR);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
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

    public function getAllPostsUser($user)
    {
        $query = "SELECT *, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post) as LikeCount, (SELECT COUNT(*) FROM Likes WHERE Likes.post_id = Post.id_post AND Likes.user = :user) as user_liked, Users.pp AS user_pp FROM Post LEFT JOIN Users ON Post.user = Users.username WHERE id_pere IS NULL AND user = :user ORDER BY Time DESC";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':user', $user);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getComments($id_pere)
    {
        $query = "SELECT Post.*, Users.pp AS user_pp FROM Post LEFT JOIN Users ON Post.user = Users.username WHERE Post.id_pere = :id_pere ORDER BY Post.Time DESC";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':id_pere', $id_pere);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function commentPost($user, $contenu, $image, $id_pere)
    {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = 'uploads/';

            // Assurez-vous que le répertoire de téléchargement existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Générez un nom de fichier unique pour éviter les collisions
            $imageFileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageFileName;

            // Déplace le fichier téléchargé vers le répertoire de téléchargement
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                // Si le déplacement du fichier échoue, réinitialisez $imagePath à null
                $imagePath = null;
            }
        } else {
            $imagePath = null;
        }

        $query = "SELECT pp FROM users WHERE username = :username";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->execute();
        $pp = $stmt->fetchColumn();


        $query = "INSERT INTO Post (user, contenu, image, Time, pp, id_pere) VALUES (:username, :contenu, :image, datetime('now'), :pp, :id_pere)";
        $stmt = $this->connectDB()->prepare($query);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':pp', $pp, PDO::PARAM_STR);
        $stmt->bindParam(':id_pere', $id_pere, PDO::PARAM_STR);
        $stmt->execute();
        header("Location: ../views/post.php?id=" . $id_pere);


    }
}