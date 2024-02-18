<?php
require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Album;
    use Album\Groupe;
    use Album\Genre;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="static/css/navbar.css">
    <link rel="stylesheet" href="static/css/albums.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
    <?php
        include 'nav.php';
    ?>
    <div class="content">
        <h1>Albums</h1>
        <div class="recherche">
            <input type="search" name="search_Albums" id="search_Albums" onchange="getAlbumsFilter()">
            <?php
                echo Album::getAnneesOption();
                echo Groupe::getArtistesOption();
                echo Genre::getGenresOption();
            ?>
        </div>
        <div class="albums">
            <?php
            echo Album::getAlbums();
            ?>
        </div>
    </div>
    <script src="static/js/albums.js"></script>
</body>
</html>