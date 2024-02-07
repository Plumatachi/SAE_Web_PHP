<?php
header('Content-Type: application/json');
require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Album;

if (isset($_GET['recherche']) || isset($_GET['artiste']) || isset($_GET['annee'])) {
    $recherche = $_GET['recherche'] ?? '';
    $artiste = (int) $_GET['artiste'] ?? -1;
    $annee = $_GET['annee'] ?? NULL;
    $genre = $_GET['genre'] ?? NULL;
    $albums = Album::getAlbumsFiltre($recherche, $artiste, $annee, $genre);
    error_log(print_r($albums, true));
    echo json_encode($albums);
}
?>