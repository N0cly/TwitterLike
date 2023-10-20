<?php

//namespace ctrl;


require_once $_SERVER['DOCUMENT_ROOT'] . '/models/CategorieModel.php';


use Model\CategorieModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class CategorieController
{
    public function ajouterCategorie()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom_categorie = $_POST['nom_categorie'];
            $libelle = $_POST['libelle'];

            $categorieModel = new CategorieModel();
            $result = $categorieModel->ajouterCategorie($nom_categorie, $libelle);
            return $result;
        }
    }


    public function getCategorieAll()
    {
        $categorieModel = new CategorieModel();
        $result = $categorieModel->getCategorieAll();
        return $result;
    }


}
