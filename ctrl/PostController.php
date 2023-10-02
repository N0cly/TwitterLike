<?php

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

    public function sendPost()
    {
        if (isset($_SERVER['REQUEST_METHOD']) &&
            $_SERVER['REQUEST_METHOD'] == "POST") {
            // Récupérez les données du formulaire
            $image = $_POST["image"];
            $content = $_POST["content"];
            $user = $_SESSION['user'];

            $postModel = new PostModel();
            $postModel->createPost($user, $content, $image);
        }
    }




}