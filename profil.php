<!DOCTYPE>
<html lang="fr">
    <head>
        <title>Profil</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            require_once 'Classes/Autoloader.php';
            Autoloader::register();
            use Album\Utilisateur;
            include 'nav.php';
            echo '<h1>' . $_SESSION['pseudo'] . '</h1>';

            if (isset($_POST['submit'])){
                Utilisateur::deconnexion();
                exit();
            }
        ?>
        <form action="" method="POST">
            <button type="submit" name="submit">Se déconnecter</button>
        </form>
    </body>
</html>