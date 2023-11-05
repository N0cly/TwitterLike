<?php

use Model\PostModel;

require_once $_SERVER['DOCUMENT_ROOT'] . ('/models/PostModel.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PostController
{

    public function getPost($id_post)
    {
        if (
            isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD'] == "GET"
        ) {
            $user = $_SESSION['username'];
            $postModel = new PostModel();
            $post = $postModel->getPost($id_post);

            $post['LikeCount'] = $postModel->getPostLikes($id_post);
            $post['user_liked'] = $postModel->getPostUserLiked($id_post, $user);

            return $post;
        }
    }

    public function getPosts()
    {
        $postModel = new PostModel();
        $posts = $postModel->getAllPosts(); // Remplacez par la méthode appropriée pour obtenir les publications

        return $posts;
    }
    public function getPostsByCategory($categorie, $user)
    {
        $postModel = new PostModel();
        $posts = $postModel->getPostsByCategory($categorie, $user); // Remplacez par la méthode appropriée pour obtenir les publications

        return $posts;
    }

    public function getPostsByContenu($contenu, $user)
    {
        if (isset($_GET['contenu'])) {
            $contenu = $_GET['contenu'];
            session_start();
            $user = $_SESSION['username']; // Récupérez l'utilisateur depuis la session

            $postCtrl = new PostController();
            $posts = $postCtrl->getPostsByContenu($contenu, $user);
        }
        return $posts;
    }

    public function sendPost()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $image = null; // Si vous n'utilisez pas l'image pour le moment
            $content = $_POST["contenu"];
            session_start();
            // Obtenez l'username à partir de la session
            $user = $_SESSION['username'];
            $categorie = $_POST['categorie'];

            $postModel = new PostModel();
            $postModel->createPost($user, $content, $image, $categorie);
        }
    }
    public function supprimerPost()
    {

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $reponse = $_POST["choix"];
            session_start();
            $id_post = $_SESSION['post_id'];
            $postModel = new PostModel();
            $post = $postModel->supprimerPost($id_post, $reponse);

            return $post;

        }
    }




    public function sendComment()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $image = null; // Si vous n'utilisez pas l'image pour le moment
            $content = $_POST["contenu"];
            session_start();
            // Obtenez l'username à partir de la session
            $user = $_SESSION['username'];
            $id_pere = $_SESSION['post_id'];

            $postModel = new PostModel();
            $postModel->commentPost($user, $content, $image, $id_pere);
        }
    }


    public function getPostsAll($user)
    {
        $postModel = new PostModel();
        $posts = $postModel->getPostsAll($user); // Remplacez par la méthode appropriée pour obtenir les publications

        return $posts;
    }
    public function getAllPostsUser($user)
    {
        $postModel = new PostModel();
        $posts = $postModel->getAllPostsUser($user); // Remplacez par la méthode appropriée pour obtenir les publications de l'utilisateur

        return $posts;
    }

    public function getComments($id_post)
    {
        $postModel = new PostModel();
        $comments = $postModel->getComments($id_post); // Remplacez par la méthode appropriée pour obtenir les publications

        return $comments;
    }





}