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

    public function getIdChanson(): int{
        return $this->idChanson;
    }

    public function getIdAlbum(): int{
        return $this->idAlbum;
    }

    public function getTitre(): string{
        return $this->titre;
    }


}

?>