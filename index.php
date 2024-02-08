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
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
    <?php
        include 'nav.php';
    ?>
    <div class="albums">
        <h1>Albums publiés</h1>
        <ul>
            <?php
            echo Album::getAlbums(5);
            ?>
        </ul>
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