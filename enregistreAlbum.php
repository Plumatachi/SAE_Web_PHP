<?php
require_once 'Classes/Autoloader.php';
Autoloader::register();
use Album\Album;

if (isset($_POST['titre']) && isset($_POST['artiste']) && isset($_POST['producteur']) && isset($_POST['annee'])){
    $titre = $_POST['titre'];
    $artiste = $_POST['artiste'];
    $producteur = $_POST['producteur'];
    $annee = $_POST['annee'];
    $entryID = $_POST['entryID'];
    $image = '';
    if (isset($_FILES['imageAlbum'])) { // Si un fichier image a été téléchargé
        $imagePath = 'static/images/';
        $imageTempPath = $_FILES['imageAlbum']['tmp_name'];
        $imageName = $_FILES['imageAlbum']['name'];
        $imageDestination = $imagePath . $imageName;
        if (move_uploaded_file($imageTempPath, $imageDestination)) {
            $image = $imageName;
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé.";
    }
    if (!$image) {
        $image = 'default.jpg';
    }
    $genres = isset($_POST['genres']) ? explode(',', $_POST['genres']) : array(); // Récupérer les genres sélectionnés et les diviser en un tableau
    Album::createAlbum($titre, $artiste, $producteur, $annee, $image, $genres, $entryID); // Appeler la fonction createAlbum avec les genres

} else {
    echo 'Erreur';
    if (isset($_POST['titre'])) {
        echo 'Titre: ' . $_POST['titre'];
    }
    if (isset($_POST['artiste'])) {
        echo 'Artiste: ' . $_POST['artiste'];
    }
    if (isset($_POST['producteur'])) {
        echo 'Producteur: ' . $_POST['producteur'];
    }
    if (isset($_POST['annee'])) {
        echo 'Année: ' . $_POST['annee'];
    }
    if (isset($_POST['genres'])) {
        echo 'Genres: ' . $_POST['genres'];
    }
    if (isset($_POST['entryID'])) {
        echo 'entryID: ' . $_POST['entryID'];
    }
    
    echo '<a href="index.php">Retour</a>';

}

?>