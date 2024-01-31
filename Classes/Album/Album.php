<?php
namespace Album;

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
                    <div>
                        <a href="#">
                            <img src="Data/images/'.$this->imageAlbum.'" alt="'.$this->titre.'">
                        </a>
                    </div>
                </li>';
    }

    public static function getAlbums(int $limit=null){
        $pdo = Database::getPdo();
        if ($limit){
            $query = $pdo->prepare('SELECT * FROM ALBUM LIMIT '.$limit);
        }
        else{
            $query = $pdo->prepare('SELECT * FROM ALBUM');
        }
        $query->execute();
        $albums = $query->fetchAll();
        $html = '';
        foreach ($albums as $album){
            $instance = new Album($album['idAlbum'], $album['idChanteur'], $album['idProducteur'], $album['titre'], $album['annee'], $album['imageAlbum'], $album['entryID']);
            $html .= $instance->render();
        }
        return $html;
    }

    public static function getAnneesOption(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT DISTINCT annee FROM ALBUM ORDER BY annee DESC');
        $query->execute();
        $annees = $query->fetchAll();
        $html = '<select name="anne" id="anne">
                <option value="">Année</option>';
        foreach ($annees as $annee){
            $html .= '<option value="'.$annee['annee'].'">'.$annee['annee'].'</option>';
        }
        return $html .= '</select>';
    }

}

?>