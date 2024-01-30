<?php
require_once 'Classes/Autoloader.php';
    Autoloader::register();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="navbar.css">
</head>

<body>
    <nav class="nav-bar">
        <ul>
            <li><img src="https://picsum.photos/100" alt="Logo"></li>
            <li><a href="">Artistes</a></li>
            <li><a href="">Albums</a></li>
            <li><a href="">Playlists</a></li>
            <li><input type="search" name="search" id="search" placeholder="Rechercher..."></li>
            <li><a href="">Login</a></li>
        </ul>
    </nav>

    <div class="albums">
        <h1>Albums publiés</h1>
        <ul>
            <?php
            use Album\Album;
            echo Album::getAlbums();
            ?>
        </ul>
    </div>

    <div class="artistes">
        <h1>Artistes</h1>
        <ul>
            <?php
            use Album\Groupe;
            echo Groupe::getArtistes();
            ?>
        </ul>
    </div>
</body>

</html>