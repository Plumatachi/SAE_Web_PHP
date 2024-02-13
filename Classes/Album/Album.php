<?php
namespace Album;
use Album\Database;

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
                            <a href="#">
                                <img src="Data/images/'.str_replace("%","%25",$this->imageAlbum).'" alt="'.$this->titre.'">
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
        $html = '<select name="annee" id="annee" onchange="getAlbumsFilter()">
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


}

?>