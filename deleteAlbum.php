<?php
require_once 'Classes/Autoloader.php';
Autoloader::register();
use Album\Database;
if (isset($_POST['idAlbum'])) {
    $idAlbum = $_POST['idAlbum'];
    $pdo = Database::getPdo(); // Initialisez votre connexion PDO à la base de données
    $query = $pdo->prepare('DELETE FROM Album WHERE idAlbum = :idAlbum');
    $query->execute(array('idAlbum' => $idAlbum));

    $response = array('status' => 'OK', 'message' => 'Suppression effectuée');
} else {
    $response = array('status' => 'error', 'message' => 'ID de l\'album manquant dans la requête');
}

// Renvoyez la réponse JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
