<?php
require_once 'Classes/Autoloader.php';
Autoloader::register();
use Album\Utilisateur;
?>

<nav class="nav-bar">
    <ul>
        <li><a href="index.php"><img src="static/images/logo.png" alt="Logo"></a></li>
        <li><a href="artistes.php">Artistes</a></li>
        <li><a href="albums.php">Albums</a></li>
        <?php
        session_start();
        if (isset($_SESSION['pseudo'])) {
            if (Utilisateur::isAdmin()) {
                echo '<li><a href="createAlbum.php">Ajout</a></li>';
            }
            echo '<li><a href="profil.php">' . $_SESSION['pseudo'] . '</a></li>';
        } else {
            echo '<li><a href="page_login.php">Login</a></li>';
        }
        ?>
    </ul>
</nav>
