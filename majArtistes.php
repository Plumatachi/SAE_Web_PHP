<?php
header('Content-Type: application/json');
require_once 'Classes/Autoloader.php';
Autoloader::register();
use Album\Groupe;

if (isset($_GET['recherche'])){
    $recherche = $_GET['recherche'];
    $albums = Groupe::getArtisteFilter($recherche);
    echo json_encode($albums);
}

?>