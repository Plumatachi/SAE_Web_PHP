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
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="detailArtiste.css">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
    <?php
        include 'nav.php';
    ?>
    <div class="content">
        <?php
        echo Groupe::getArtisteById($_GET['id']);
        echo Album::getAlbumsByArtiste($_GET['id']);
        ?>
    </div>
</body>
</html>