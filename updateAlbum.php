<?php
require_once 'Classes/Autoloader.php';
Autoloader::register();
use Album\Database;
if (isset($_POST['idAlbum'], $_POST['idChanteur'], $_POST['annee'], $_POST['titre'])) {
    // Récupérez les valeurs des paramètres
    $idAlbum = $_POST['idAlbum'];
    $idChanteur = $_POST['idChanteur'];
    $annee = $_POST['annee'];
    $titre = $_POST['titre'];

    $pdo = Database::getPdo(); // Initialisez votre connexion PDO à la base de données
    $query = $pdo->prepare('UPDATE Album SET idChanteur = :idChanteur, annee = :annee, titre =:titre WHERE idAlbum = :idAlbum');
    $query->bindParam(':idAlbum', $idAlbum, PDO::PARAM_INT);
    $query->bindParam(':idChanteur', $idChanteur, PDO::PARAM_INT);
    $query->bindParam(':annee', $annee, PDO::PARAM_INT);
    $query->bindParam(':titre', $titre, PDO::PARAM_STR);
    $query->execute(); // Exécutez la requête préparée


    // Exemple de réponse JSON pour indiquer que la mise à jour a été effectuée avec succès
    $response = array('status' => 'OK', 'message' => 'Mise à jour réussie');
} else {
    // Si des paramètres sont manquants, renvoyez un message d'erreur
    $response = array('status' => 'error', 'message' => 'Paramètres manquants');
}

// Renvoyer la réponse JSON
header('Content-Type: application/json');
echo json_encode($response);


?>