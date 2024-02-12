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
    <link rel="stylesheet" href="index.css">
    <script src="index.js"></script>
</head>
<body>
    <?php
        include 'nav.php';
    ?>
    <div class="albums">
        <h1>Albums publiés</h1>
        <div id="album-rotator">
            <div id="album-rotator-holder">
                    <?php
                    echo Album::getAlbums();
                    ?>
            </div>
        </div>
    </div>
    <div class="artistes">
        <h1>Artistes</h1>
        <ul>
            <?php
            echo Groupe::getArtistes();
            ?>
        </ul>
    </div>
</body>
</html>