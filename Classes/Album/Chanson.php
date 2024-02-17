<?php
namespace Album;

class Chanson{
    private $idChanson;
    private $idAlbum;
    private $titre;
    
    public function __construct($idChanson, $idAlbum, $titre){
        $this->idChanson = $idChanson;
        $this->idAlbum = $idAlbum;
        $this->titre = $titre;
    }

    public function getIdChanson(){
        return $this->idChanson;
    }

    public function getIdAlbum(){
        return $this->idAlbum;
    }

    public function getTitre(){
        return $this->titre;
    }


}

?>