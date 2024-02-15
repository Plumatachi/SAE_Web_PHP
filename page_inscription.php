<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Sign up</title>
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
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $pseudo = $_POST['pseudo'];
                $mdp = $_POST['mdp'];
                $user = new Utilisateur($nom, $prenom, $email, $pseudo, $mdp);
                Utilisateur::addUser($nom, $prenom, $email, $pseudo, $mdp);
                exit();
            }
        ?>
        <form action="page_login.php" method="POST">
            <h1>Inscrivez-vous</h1>
            <p>Nom</p>
            <input type="text" id="nom" name="nom">
            <p>Prénom</p>
            <input type="text" id="prenom" name="prenom">
            <p>Email</p>
            <input type="text" id="email" name="email">
            <p>Nom d'utilisateur</p>
            <input type="text" id="pseudo" name="pseudo">
            <p>Mot de passe</p>
            <input type="password" id="mdp" name="mdp">
            <button type="submit">S'inscrire</button>
            <a href="page_login.php">Vous possédez déjà un compte ?</a>
        </form>
    </body>
</html>