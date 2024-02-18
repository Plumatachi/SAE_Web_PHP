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
    <link rel="stylesheet" href="static/css/detailAlbum.css">
    <script src="static/js/detailAlbum.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
</head>
<body>
    <?php
        include 'nav.php';
    ?>
    <div class="content">
        <?php
        echo Album::getDetailAlbum($_GET['id']);
        ?>
    </div>
</body>
</html>