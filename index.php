<?php
    require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Album;
    use Album\Groupe;
    use Album\Utilisateur;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="static/css/navbar.css">
    <link rel="stylesheet" href="static/css/index.css">
    <script src="static/js/index.js"></script>
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
        <div id="album2-rotator">
            <div id="album2-rotator-holder">
                <ul>
                    <?php
                    echo Groupe::getArtistes();
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>