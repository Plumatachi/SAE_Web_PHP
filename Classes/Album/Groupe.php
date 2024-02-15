<?php
Namespace Album;
use Album\Database;
class Groupe{
    protected $idGroupe;
    protected $nom;

    public function __construct($idGroupe, $nom){
        $this->idGroupe = $idGroupe;
        $this->nom = $nom;
    }

    public function getIdGroupe(){
        return $this->idGroupe;
    }

    public function getNom(){
        return $this->nom;
    }

    public function render(){
        return '<li>
                    <div class="flex album2-item">
                        <a class="album2-details">
                            <div class="groupe">
                                <img src="https://picsum.photos/100" alt="'.$this->nom.'">
                                <h2>'.$this->nom.'</h2>
                            </div>
                        </a>
                    </div>
                </li>';
    }

    public static function getArtistes(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE');
        $query->execute();
        $groupes = $query->fetchAll();
        $html = '';
        foreach ($groupes as $groupe){
            $instance = new Groupe($groupe['idGroupe'], $groupe['nom']);
            $html .= $instance->render();
        }
        return $html;
    }

    public static function getArtistesOption(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE ORDER BY nom ASC');
        $query->execute();
        $groupes = $query->fetchAll();
        $html = '<select name="artiste" id="artiste" onchange="getAlbumsFilter()">';
        $html .= self::OptionArtistes($groupes);
        return $html .='</select>';
    }

    public static function getProducteurOption(){
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE ORDER BY nom ASC');
        $query->execute();
        $groupes = $query->fetchAll();
        $html = '<select name="producteur" id="producteur">';
        $html .= self::OptionArtistes($groupes);
        return $html .='</select>';
    }

    private static function OptionArtistes($groupes):string{
        $html = '<option value="-1">Artiste</option>';
        foreach ($groupes as $groupe){
            $instance = new Groupe($groupe['idGroupe'], $groupe['nom']);
            $html .= '<option value="'.$instance->getIdGroupe().'">'.$instance->getNom().'</option>';
        }
        return $html;
    }

}
?>