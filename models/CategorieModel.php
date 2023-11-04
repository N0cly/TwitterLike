<?php

namespace Model;

use PDO;
use PDOException;

class CategorieModel
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
    public function ajouterCategorie($nom_categorie, $libelle)
    {
        session_start();

        try {

            // Préparez la requête d'insertion
            $query = "INSERT INTO categorie (nom_categorie, libelle) VALUES (:nom_categorie, :libelle)";
            $stmt = $this->connectDB()->prepare($query);
            $stmt->bindParam(':nom_categorie', $nom_categorie, PDO::PARAM_STR);
            $stmt->bindParam(':libelle', $libelle, PDO::PARAM_STR);

            // Exécutez la requête
            if ($stmt->execute()) {
                header("Location: ../views/dashboard.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'ajout de la catégorie dans la base de données";
            }
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de l'ajout de la catégorie";
            error_log($e->getMessage());
            exit;
        }
    }

    public function removeCategorie($nom_categorie)
    {
        session_start();

        try {
            // Mettre à jour les catégories des posts existants
            $updateQuery = "UPDATE Post SET categorie = 'Divers' WHERE categorie = :nom_categorie";
            $stmtUpdate = $this->connectDB()->prepare($updateQuery);
            $stmtUpdate->bindParam(':nom_categorie', $nom_categorie, PDO::PARAM_STR);
            $stmtUpdate->execute();

            // Supprimer la catégorie
            $deleteQuery = "DELETE FROM categorie WHERE nom_categorie = :nom_categorie";
            $stmtDelete = $this->connectDB()->prepare($deleteQuery);
            $stmtDelete->bindParam(':nom_categorie', $nom_categorie, PDO::PARAM_STR);

            if ($stmtDelete->execute()) {
                header("Location: ../views/dashboard.php");
                exit;
            } else {
                $_SESSION['error_message'] = "Erreur lors de la suppression de la catégorie de la base de données";
            }
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Erreur lors de la suppression de la catégorie";
            error_log($e->getMessage());
            exit;
        }
    }


    public function getCategorieAll()
    {
        try {
            $db = $this->connectDB();

            // Préparez la requête pour récupérer toutes les catégories
            $query = "SELECT * FROM categorie";
            $stmt = $db->query($query);

            // Récupérez toutes les catégories sous forme de tableau associatif
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $categories;
        } catch (PDOException $e) {
            // Gérez les erreurs en cas de problème de connexion ou de requête
            error_log("Erreur lors de la récupération de toutes les catégories : " . $e->getMessage());
            return [];
        }
    }


}
