<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Sign in</title>
        <meta charset="utf-8">
        <!-- <link rel="stylesheet" href="navbar.css"> -->
    </head>
    <body>
        <?php
            require_once 'Classes/Autoloader.php';
            Autoloader::register();
            use Album\Utilisateur;
            include 'nav.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $pseudo = $_POST['pseudo'];
                $mdp = $_POST['mdp'];
                Utilisateur::connexion($pseudo, $mdp);
                exit();
            }
        ?>
        <form action="" method="POST">
        <h1>Connectez-vous</h1>
            <p>Nom d'utilisateur</p>
            <input type="text" id="pseudo" name="pseudo" required>
            <p>Mot de passe</p>
            <input type="password" id="mdp" name="mdp" required>
            <button type="submit">Se connecter</button>
            <a href="page_inscription.php">Vous n'avez pas encore de compte ?</a>
        </form>
    </body>
</html>