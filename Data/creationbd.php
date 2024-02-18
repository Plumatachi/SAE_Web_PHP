<?php
define('SQLITE_DB', __DIR__.'/../Data/Music.sqlite');
require_once __DIR__.'/../Classes/Album/Spyc.php';
$pdo = new PDO('sqlite:' . SQLITE_DB);

switch ($argv[1]) {
    case 'create-database':
        echo '→ Go create database "Music.sqlite"' . PHP_EOL;
        shell_exec('sqlite3 ' . SQLITE_DB);
        break;

    case 'create-table':
        echo '→ Go create "groupe" table' . PHP_EOL;
        $query =<<<EOF
            CREATE TABLE IF NOT EXISTS GROUPE (
                idGroupe     INTEGER NOT NULL PRIMARY KEY,
                nom          TEXT NOT NULL
            );
            CREATE TABLE IF NOT EXISTS ALBUM (
                idAlbum      INTEGER NOT NULL,
                idChanteur   INTEGER NOT NULL,
                idProducteur INTEGER NOT NULL,
                titre        TEXT NOT NULL,
                annee        INTEGER NOT NULL,
                imageAlbum   TEXT NOT NULL,
                entryID      INTEGER NOT NULL,
                PRIMARY KEY(idAlbum, idChanteur, idProducteur),
                FOREIGN KEY(idChanteur) REFERENCES GROUPE(idGroupe),
                FOREIGN KEY(idProducteur) REFERENCES GROUPE(idGroupe)
            );
            CREATE TABLE IF NOT EXISTS GENRE (
                idGenre      INTEGER NOT NULL PRIMARY KEY,
                nom          TEXT NOT NULL
            );
            CREATE TABLE IF NOT EXISTS ALBUMGENRES (
                idAlbum      INTEGER NOT NULL,
                idGenre      INTEGER NOT NULL,
                PRIMARY KEY(idAlbum, idGenre),
                FOREIGN KEY(idAlbum) REFERENCES ALBUM(idAlbum),
                FOREIGN KEY(idGenre) REFERENCES GENRE(idGenre)
            );
            CREATE TABLE IF NOT EXISTS ROLE (
                idRole        INTEGER NOT NULL PRIMARY KEY,
                nomRole       TEXT NOT NULL
            );
            CREATE TABLE IF NOT EXISTS UTILISATEUR (
                email         TEXT NOT NULL PRIMARY KEY,
                idRole        INTEGER NOT NULL,
                nom           TEXT NOT NULL,
                prenom        TEXT NOT NULL,
                pseudo        TEXT NOT NULL,
                motDePasse    TEXT NOT NULL,
                FOREIGN KEY(idRole) REFERENCES ROLE(idRole)
            );
            CREATE TABLE IF NOT EXISTS CHANSON (
                idChanson     INTEGER NOT NULL,
                idAlbum       INTEGER NOT NULL,
                titre         TEXT NOT NULL,
                PRIMARY KEY(idChanson, idAlbum),
                FOREIGN KEY(idAlbum) REFERENCES ALBUM(idAlbum)
            );
            CREATE TABLE IF NOT EXISTS PlaylistLike (
                idUtilisateur  INTEGER NOT NULL,
                idChanson      INTEGER NOT NULL,
                PRIMARY KEY (idUtilisateur, idChanson),
                FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur),
                FOREIGN KEY (idChanson) REFERENCES Chanson(idChanson)
            );
            CREATE TABLE IF NOT EXISTS AlbumsLike (
                idUtilisateur  INTEGER NOT NULL,
                idAlbum        INTEGER NOT NULL,
                PRIMARY KEY (idUtilisateur, idAlbum),
                FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur),
                FOREIGN KEY (idAlbum) REFERENCES Album(idAlbum)
            );
            CREATE TABLE IF NOT EXISTS Notation (
                idUtilisateur  INTEGER NOT NULL,
                idChanson      INTEGER NOT NULL,
                Note           INTEGER NOT NULL,
                PRIMARY KEY (idUtilisateur, idChanson),
                FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur),
                FOREIGN KEY (idChanson) REFERENCES Chanson(idChanson)
            );
        EOF;
        try {
            $pdo->exec($query);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        break;

    case 'delete-table':
        echo '→ Go delete tables' . PHP_EOL;
        $query =<<<EOF
            DROP TABLE IF EXISTS PlaylistLike;
            DROP TABLE IF EXISTS AlbumsLike;
            DROP TABLE IF EXISTS Notation;
            DROP TABLE IF EXISTS UTILISATEUR;
            DROP TABLE IF EXISTS CHANSON;
            DROP TABLE IF EXISTS ALBUMGENRES;
            DROP TABLE IF EXISTS GENRE;
            DROP TABLE IF EXISTS ALBUM;
            DROP TABLE IF EXISTS GROUPE;        
        EOF;
        try {
            $pdo->exec($query);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        break;

    case 'load-data':
        echo '→ Go load data to tables' . PHP_EOL;
        $yamlContents = file_get_contents('Data/extrait.yml');
        $data = Spyc::YAMLLoadString($yamlContents);
        foreach ($data as $album) {
            $idartiste = $pdo->query('SELECT idGroupe FROM GROUPE WHERE nom = "'.$album['by'].'"')->fetchColumn();
            if (!$idartiste){
                $maxIdGroupe = $pdo->query('SELECT MAX(idGroupe) FROM GROUPE')->fetchColumn() + 1;
                $query = 'INSERT INTO GROUPE (idGroupe, nom) VALUES (?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $maxIdGroupe, PDO::PARAM_INT);
                $stmt->bindParam(2, $album['by'], PDO::PARAM_STR);
                $stmt->execute();
                $idartiste = $maxIdGroupe;
            }
            $genres = $album['genre'];
            $idGenres = array();
            foreach ($genres as $genre) {
                $idGenre = $pdo->query('SELECT idGenre FROM GENRE WHERE nom = "'.$genre.'"')->fetchColumn();
                if (!$idGenre){
                    $maxIdGenre = $pdo->query('SELECT MAX(idGenre) FROM GENRE')->fetchColumn() + 1;
                    $query = 'INSERT INTO GENRE (idGenre, nom) VALUES (?,?)';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(1, $maxIdGenre, PDO::PARAM_INT);
                    $stmt->bindParam(2, $genre, PDO::PARAM_STR);
                    $stmt->execute();
                    $idGenre = $maxIdGenre;
                }
                $idGenres[] += $idGenre;
            }
            $idProducteur = $pdo->query('SELECT idGroupe FROM GROUPE WHERE nom = "'.$album['parent'].'"')->fetchColumn();
            if (!$idProducteur){
                $maxIdGroupe = $pdo->query('SELECT MAX(idGroupe) FROM GROUPE')->fetchColumn() + 1;
                $query = 'INSERT INTO GROUPE (idGroupe, nom) VALUES (?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $maxIdGroupe, PDO::PARAM_INT);
                $stmt->bindParam(2, $album['parent'], PDO::PARAM_STR);
                $stmt->execute();
                $idProducteur = $maxIdGroupe;
            }
            $idAlbum = $pdo->query('SELECT idAlbum FROM ALBUM WHERE titre = "'.$album['title'].'"')->fetchColumn();
            if(!$idAlbum){
                $maxIdAlbum = $pdo->query('SELECT MAX(idAlbum) FROM ALBUM')->fetchColumn() + 1;
                $image = ($album['img'] == null) ? 'default.jpg' : $album['img'];
                $query = 'INSERT INTO ALBUM (idAlbum, idChanteur, idProducteur, titre, annee, imageAlbum, entryID) VALUES (?,?,?,?,?,?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $maxIdAlbum, PDO::PARAM_INT);
                $stmt->bindParam(2, $idartiste, PDO::PARAM_INT);
                $stmt->bindParam(3, $idProducteur, PDO::PARAM_INT);
                $stmt->bindParam(4, $album['title'], PDO::PARAM_STR);
                $stmt->bindParam(5, $album['releaseYear'], PDO::PARAM_INT);
                $stmt->bindParam(6, $image, PDO::PARAM_STR);
                $stmt->bindParam(7, $album['entryId'], PDO::PARAM_INT);
                $stmt->execute();
                $idAlbum = $maxIdAlbum;
            }
            foreach ($idGenres as $idGenre) {
                $query = 'INSERT OR IGNORE INTO ALBUMGENRES (idAlbum, idGenre) VALUES (?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $idAlbum, PDO::PARAM_INT);
                $stmt->bindParam(2, $idGenre, PDO::PARAM_INT);
                $stmt->execute();
            }
            if (isset($album['chansons']) && is_array($album['chansons'])) {
                foreach ($album['chansons'] as $chanson) {
                    $idChanson = $pdo->query('SELECT idChanson FROM CHANSON WHERE titre = "'.$chanson.'"')->fetchColumn();
                    if(!$idChanson){
                        $maxIdChanson = $pdo->query('SELECT MAX(idChanson) FROM CHANSON')->fetchColumn() + 1;
                        $query = 'INSERT INTO CHANSON (idChanson,idAlbum, titre) VALUES (?, ?, ?)';
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(1, $maxIdChanson, PDO::PARAM_INT);
                        $stmt->bindParam(2, $idAlbum, PDO::PARAM_INT);
                        $stmt->bindParam(3, $chanson, PDO::PARAM_STR);
                        $stmt->execute();
                        $query = '';
                    }
                }
            }
            $idRole = $pdo->query('SELECT idRole FROM ROLE WHERE nomRole = "admin"')->fetchColumn();
            if (!$idRole){
                $idRole = 1;
                $name = 'admin';
                $query = 'INSERT INTO `ROLE` (idRole, nomRole) VALUES (?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $idRole, PDO::PARAM_INT);
                $stmt->bindParam(2, $name, PDO::PARAM_STR);
                $stmt->execute();
            }
            $idrole = $pdo->query('SELECT idRole FROM ROLE WHERE nomRole = "user"')->fetchColumn();
            if (!$idrole){
                $idRole = 2;
                $name = 'user';
                $query = 'INSERT INTO `ROLE` (idRole, nomRole) VALUES (?,?)';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(1, $idRole, PDO::PARAM_INT);
                $stmt->bindParam(2, $name, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
        $admin = $pdo->query('SELECT email FROM UTILISATEUR WHERE nom = "admin"')->fetchColumn();
        if (!$admin){
            $idRole = $pdo->query('SELECT idRole FROM ROLE WHERE nomRole = "admin"')->fetchColumn();
            $query = 'INSERT INTO UTILISATEUR (email, idRole, nom, prenom, pseudo, motDePasse) VALUES (?,?,?,?,?,?)';
            $stmt = $pdo->prepare($query);
            $email = 'admin';
            $nom = 'admin';
            $prenom = 'admin';
            $pseudo = 'admin';
            $mdp = 'admin';
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->bindParam(2, $idRole, PDO::PARAM_INT);
            $stmt->bindParam(3, $nom, PDO::PARAM_STR);
            $stmt->bindParam(4, $prenom, PDO::PARAM_STR);
            $stmt->bindParam(5, $pseudo, PDO::PARAM_STR);
            $stmt->bindParam(6, $mdp, PDO::PARAM_STR);
            $stmt->execute();
        }
        break;

    default:
        echo 'No action defined 🙀'.PHP_EOL;
        break;
}
?>
