<?php

use Model\PostModel;
require_once $_SERVER['DOCUMENT_ROOT'] .('/models/PostModel.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class PostController
{

    public function getPost($id_post)
    {
        $postModel = new PostModel();
        $post = $postModel->getPost($id_post);

        $post['LikeCount'] = $postModel->getPostLikes($id_post);
        $post['user_liked'] = $postModel->getPostUserLiked($id_post, $_SESSION['user']);

        return $post;
    }

    public function getPosts()
    {
        $postModel = new PostModel();
        $posts = $postModel->getAllPosts(); // Remplacez par la méthode appropriée pour obtenir les publications

        return $posts;
    }


    public function sendPost()
    {
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD'] == "POST") {
            // Récupérez les données du formulaire
            $image = null;
            $content = $_POST["content"];
            $user = $_SESSION['username'];

            $postModel = new PostModel();
            $postModel->createPost($user, $content, $image);
        }
    }

    public function getPostsAll($user)
    {
        $postModel = new PostModel();
        $posts = $postModel->getPostsAll($user); // Remplacez par la méthode appropriée pour obtenir les publications

        return $posts;
    }

    public function getComments($id_post)
    {
        $postModel = new PostModel();
        $comments = $postModel->getComments($id_post); // Remplacez par la méthode appropriée pour obtenir les publications

        return $comments;
    }




}