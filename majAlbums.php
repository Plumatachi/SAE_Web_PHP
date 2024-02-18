<?php
header('Content-Type: application/json');
require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Album;

if (isset($_GET['recherche']) || isset($_GET['artiste']) || isset($_GET['annee']) || isset($_GET['genre'])){
    $recherche = $_GET['recherche'] ?? '';
    $artiste = (int) $_GET['artiste'] ?? -1;
    $annee = $_GET['annee'] ?? NULL;
    $genre = (int) $_GET['genre'] ?? -1;
    $albums = Album::getAlbumsFiltre($recherche, $artiste, $annee, $genre);
    echo json_encode($albums);
}
?>