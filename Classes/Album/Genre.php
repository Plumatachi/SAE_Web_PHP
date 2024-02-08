<?php
namespace Album;
use Album\Database;

class Genre{
    protected $idGenre;
    protected $nom;

    public function __construct($idGenre, $nom){
        $this->idGenre = $idGenre;
        $this->nom = $nom;
    }

    public function getIdGenre(){
        return $this->idGenre;
    }

    public function getNom(){
        return $this->nom;
    }

    public static function getGenres(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GENRE');
        $query->execute();
        $genres = $query->fetchAll();
        $html = '';
        foreach ($genres as $genre){
            $instance = new Genre($genre['idGenre'], $genre['nom']);
            $html .= $instance->render();
        }
        return $html;
    }

    public static function getGenresOption(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GENRE ORDER BY nom ASC');
        $query->execute();
        $genres = $query->fetchAll();
        $html = '<select name="genre" id="genre" onchange="getAlbumsFilter()">
                    <option value="-1">Genre</option>';
        foreach ($genres as $genre){
            $instance = new Genre($genre['idGenre'], $genre['nom']);
            $html .= '<option value="'.$instance->getIdGenre().'">'.$instance->getNom().'</option>';
        }
        return $html .='</select>';
    }
}


?>