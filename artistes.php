<?php
require_once 'Classes/Autoloader.php';
    Autoloader::register();
    use Album\Groupe;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="artistes.css">
    <script type="module" src="artistes.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
    <?php
        include 'nav.php';
    ?>
    <div class="content">
        <h1>Artistes</h1>
        <div class="recherche">
            <input type="search" name="search_Artistes" id="search_Artistes">
        </div>
        <div class="artiste">
            <?php
            echo Groupe::getArtistes();
            ?>
        </div>
    </div>
</body>
</html>