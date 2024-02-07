<?php
require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Album;
    use Album\Groupe;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="albums.css">
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
            ?>
        </div>
        <div class="albums">
            <?php
            echo Album::getAlbums();
            ?>
        </div>
    </div>
    <script src="albums.js"></script>
</body>
</html>