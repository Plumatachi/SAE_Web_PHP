<?php
namespace Album;
use Album\Database;
use Album\Groupe;
use Album\Genre;
use Album\Chanson;

class Album{
    protected $idAlbum;
    protected $idChanteur;
    protected $idProducteur;
    protected $titre;
    protected $annee;
    protected $imageAlbum;
    protected $entryID;

    public function __construct($idAlbum, $idChanteur, $idProducteur, $titre, $annee, $imageAlbum, $entryID){
        $this->idAlbum = $idAlbum;
        $this->idChanteur = $idChanteur;
        $this->idProducteur = $idProducteur;
        $this->titre = $titre;
        $this->annee = $annee;
        $this->imageAlbum = $imageAlbum;
        $this->entryID = $entryID;
    }

    public function getIdAlbum(){
        return $this->idAlbum;
    }

    public function getIdChanteur(){
        return $this->idChanteur;
    }

    public function getIdProducteur(){
        return $this->idProducteur;
    }

    public function getTitre(){
        return $this->titre;
    }

    public function getAnnee(){
        return $this->annee;
    }

    public function getImage(){
        return $this->imageAlbum;
    }

    public function getEntryID(){
        return $this->entryID;
    }

    public function render(){
        return '<li>
                    <div class="flex album-item">
                        <div class="album-details">
                            <a href="detailAlbum.php?id='.$this->idAlbum.'">
                                <img src="static/images/'.str_replace("%","%25",$this->imageAlbum).'" alt="'.$this->titre.'">
                            </a>
                            <h2 class="title">'.$this->titre.'</h2>
                        </div>
                    </div>
                </li>';
    }

    public function toJson(){
        return json_encode([
            'idAlbum' => $this->idAlbum,
            'idChanteur' => $this->idChanteur,
            'idProducteur' => $this->idProducteur,
            'titre' => $this->titre,
            'annee' => $this->annee,
            'imageAlbum' => $this->imageAlbum,
            'entryID' => $this->entryID,
        ]);
    }

    public static function createAlbum(string $titre, int $idChanteur, int $idProducteur, int $annee, string $imageAlbum, array $genres, int $entryID=1){
        $pdo = Database::getPdo();
        $maxIdAlbum = $pdo->query('SELECT MAX(idAlbum) FROM ALBUM')->fetchColumn() + 1;
        $query = 'INSERT INTO ALBUM (idAlbum, idChanteur, idProducteur, titre, annee, imageAlbum, entryID) VALUES (:idAlbum, :idChanteur, :idProducteur, :titre, :annee, :imageAlbum, :entryID)';
        $statement = $pdo->prepare($query);
        $statement->bindValue(':idAlbum', $maxIdAlbum);
        $statement->bindValue(':idChanteur', $idChanteur);
        $statement->bindValue(':idProducteur', $idProducteur);
        $statement->bindValue(':titre', $titre);
        $statement->bindValue(':annee', $annee);
        $statement->bindValue(':imageAlbum', $imageAlbum);
        $statement->bindValue(':entryID', $entryID);
        $statement->execute();
        foreach ($genres as $genreNom){
            $query = 'SELECT idGenre FROM GENRE WHERE nom = :nom';
            $statement = $pdo->prepare($query);
            $statement->bindValue(':nom', $genreNom);
            $statement->execute();
            $genreId = $statement->fetchColumn();

            $query = 'INSERT INTO ALBUMGENRES (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)';
            $statement = $pdo->prepare($query);
            $statement->bindValue(':idAlbum', $maxIdAlbum);
            $statement->bindValue(':idGenre', $genreId);
            $statement->execute();
        }
    }

    

    public static function getAlbums(int $limit=null){
        $pdo = Database::getPdo();
        if ($limit){
            $query = $pdo->prepare('SELECT * FROM ALBUM LIMIT '.$limit);
        }
        else{
            $query = $pdo->prepare('SELECT * FROM ALBUM ORDER BY titre');
        }
        $query->execute();
        $albums = $query->fetchAll();
        $html = '<ul id="ul-albums">';
        foreach ($albums as $album){
            $instance = new Album($album['idAlbum'], $album['idChanteur'], $album['idProducteur'], $album['titre'], $album['annee'], $album['imageAlbum'], $album['entryID']);
            $html .= $instance->render();
        }
        $html .= '</ul>';
        return $html;
    }

    public static function getAnneesOption(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT DISTINCT annee FROM ALBUM ORDER BY annee DESC');
        $query->execute();
        $annees = $query->fetchAll();
        $html = '<select name="annee" id="annee">
                <option value="">Année</option>';
        foreach ($annees as $annee){
            $html .= '<option value="'.$annee['annee'].'">'.$annee['annee'].'</option>';
        }
        return $html .= '</select>';
    }

    public static function getAlbumsFiltre(string $recherche = '', int $artiste = -1, string $annee = null, int $genre = -1){
        $pdo = Database::getPdo();
        error_log(print_r($recherche, true));
        error_log(print_r($artiste, true));
        error_log(print_r($annee, true));
        error_log(print_r($genre, true));
        $query = 'SELECT * FROM ALBUM WHERE 1=1';
        if ($recherche) {
            $query .= ' AND titre LIKE :recherche';
        }
        if ($artiste != -1) {
            $query .= ' AND idChanteur = (SELECT idGroupe FROM GROUPE WHERE idGroupe = :artiste)';
        }
        if ($annee != 'null') {
            $query .= ' AND annee = :annee';
        }
        if ($genre != -1) {
            $query .= ' AND idAlbum IN (SELECT idAlbum FROM ALBUMGENRES WHERE idGenre = :genre)';
        }
        $query .= ' ORDER BY titre';
        $stmt = $pdo->prepare($query);
        if ($recherche) {
            $stmt->bindValue(':recherche', '%' . $recherche . '%');
        }
        if ($artiste != -1)  {
            $stmt->bindValue(':artiste', $artiste);
        }
        if ($annee != 'null') {
            $stmt->bindValue(':annee', $annee);
        }
        if ($genre != -1) {
            $stmt->bindValue(':genre', $genre);
        }
        $stmt->execute();
        $albums = $stmt->fetchAll();
        $newAlbums = array();
        foreach ($albums as $album) {
            $instance = new Album($album['idAlbum'], $album['idChanteur'], $album['idProducteur'], $album['titre'], $album['annee'], $album['imageAlbum'], $album['entryID']);
            $newAlbums[] = $instance->toJson();
        }
        return $newAlbums;
    }

    public static function createAlbumForm(): string{
        $html = '<form enctype="multipart/form-data" id="album-form" action="enregistreAlbum.php" method="post">
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" required>
                        <label for="annee">Année</label>
                        <input type="number" name="annee" id="annee" value="2022" required>
                        <label for="imageAlbum">Image</label>
                        <input type="file" name="imageAlbum" id="imageAlbum" required>
                        <label for="genre">Genre</label>
                        <input type="hidden" name="genres" id="genres">';
            $html .= Genre::getGenresOptionadd();
            $html .= '<label for="entryID">entryID</label>
                        <input type="number" name="entryID" id="entryID" required>
                    </div>
                    <div>
                    <label for="artiste">Chanteur</label>';
            $html .= Groupe::getArtistesOption();
            $html .= '<label for="producteur">Producteur</label>';
            $html .= Groupe::getProducteurOption();
            $html .= '</div>';
            $html .= '<input type="submit" value="Ajouter">
                </form>';
    }
  
    public static function getGenresAlbums(int $idAlbum) {
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT idGenre FROM AlbumGenres WHERE idAlbum = :idAlbum');
        $query->bindValue(':idAlbum', $idAlbum);
        $query->execute();
        $idsGenres = $query->fetchAll();
        $res = '';
        foreach ($idsGenres as $idGenre) {
            $res .= Genre::getNomGenreById($idGenre[0]) . ", ";
        }
        return $res;
    }

    public static function getDetailAlbum(int $idAlbum){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM ALBUM WHERE idAlbum = :idAlbum');
        $query->bindValue(':idAlbum', $idAlbum);
        $query->execute();
        $album = $query->fetchAll();
        $instance = new Album($album[0]['idAlbum'], $album[0]['idChanteur'], $album[0]['idProducteur'], $album[0]['titre'], $album[0]['annee'], $album[0]['imageAlbum'], $album[0]['entryID']);
        $html = '<div class="partie-gauche">
                    <h1><input type="text" id="titre" name="titre" value="'.$instance->getTitre().'"></h1>
                    <img src="static/images/'.str_replace("%","%25",$instance->getImage()).'" alt="'.$instance->getTitre().'">
                </div>
                <div class="partie-droite">
                    <input type="hidden" id="idAlbum" name="idAlbum" value="'.$instance->getIdAlbum().'">
                    <input type="hidden" id="idChanteur" name="idChanteur" value="'.$instance->getIdChanteur().'">
                    <input type="hidden" id="idProducteur" name="idProducteur" value="'.$instance->getIdProducteur().'">
                    <input type="hidden" id="titre" name="titre" value="'.$instance->getTitre().'">
                    <input type="hidden" id="hiddenannee" name="hiddenannee" value="'.$instance->getAnnee().'">

                    <label for="artiste"><strong>Chanteur</strong></label>
                    '.Groupe::getArtistesOption().'
                    <label for="Genres"><strong>Genres</strong></label>
                    <input type="text" id="Genres" name="Genres" value="'.$instance->getGenresAlbums($instance->getIdAlbum()).'" disabled>
                    <label for="annee"><strong>Année</strong></label>
                    <input type="number" id="annee" name="annee" value="'.$instance->getAnnee().'">
                    <p><strong>Chansons</strong></p>
                    <div>';
                        $chansons = self::getChansonsAlbum($idAlbum);
                        for ($i = 0; $i < count($chansons); $i++){
                            $html .= '<p>'.$chansons[$i]->getTitre().'</p>';
                        }
                $html .= '</div>';
        Utilisateur::isAdmin() ? $html .= '<button id="btn-modifier">Modifier</button>' : '';
        Utilisateur::isAdmin() ? $html .= '<button id="btn-supprimer">Supprimer</button>' : '';
        $html .='</div>';
        return $html;
    }

    public static function getAlbumsByArtiste(int $artiste){
        $pdo = Database::getPdo();
        $stmt = $pdo->prepare('SELECT * FROM ALBUM WHERE idChanteur=:artiste');
        $stmt->bindValue(':artiste', $artiste);
        $stmt->execute();
        $albums = $stmt->fetchAll();
        $html = '<ul id="ul-albums">';
        foreach ($albums as $album){
            $instance = new Album($album['idAlbum'], $album['idChanteur'], $album['idProducteur'], $album['titre'], $album['annee'], $album['imageAlbum'], $album['entryID']);
            $html .= $instance->render();
        }
        $html .= '</ul>';
        return $html;
    }
      
    public static function getChansonsAlbum(int $idAlbum): array {
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM CHANSON WHERE idAlbum = :idAlbum');
        $query->bindValue(':idAlbum', $idAlbum);
        $query->execute();
        $chansons = $query->fetchAll();
        $array = array();
        foreach ($chansons as $chanson){
            $instance = new Chanson($chanson['idChanson'], $chanson['idAlbum'], $chanson['titre']);
            $array[] = $instance;
        }
        return $array;
    }

}

?>