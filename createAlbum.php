<?php
require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Album;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="static/js/createAlbum.js"></script>
    <title>Document</title>
</head>
<body>
    <h1>Ajoute Albums</h1>
    <?php
        echo Album::createAlbumForm();
    ?>
    <div id="genre-ajoute"></div>
    <a href="index.php">Retour</a>
</body>
</html>