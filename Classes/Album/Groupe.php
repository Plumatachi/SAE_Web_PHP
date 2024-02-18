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

    public function getIdGroupe(): int{
        return $this->idGroupe;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getPhoto(): string{
        return 'https://picsum.photos/100';
    }

    public function render(): string{
        return '<li>
                    <div class="flex album2-item">
                        <div class="album2-details">
                            <a href="detailArtiste.php?id='.$this->idGroupe.'">
                                <img src="'.$this->getPhoto().'" alt="'.$this->nom.'">
                            </a>
                            <h2>'.$this->nom.'</h2>
                        </div>
                    </div>
                </li>';
    }

    public function toJSON(): string{
        return json_encode([
            'idGroupe' => $this->idGroupe,
            'nom' => $this->nom
        ]);
    }

    public static function getArtistes(): string{
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE ORDER BY nom ASC');
        $query->execute();
        $groupes = $query->fetchAll();
        $html = '<ul id="ul-artistes">';
        foreach ($groupes as $groupe){
            $instance = new Groupe($groupe['idGroupe'], $groupe['nom']);
            $html .= $instance->render();
        }
        return $html .='</ul>';
        return $html;
    }

    public static function getArtistesOption(): string{
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE ORDER BY nom ASC');
        $query->execute();
        $groupes = $query->fetchAll();
        $html = '<select name="artiste" id="artiste">';
        $html .= self::OptionArtistes($groupes);
        return $html .='</select>';
    }

    public static function getProducteurOption(): string{
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

    public static function getNomArtiste(int $idArt) : string{
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE WHERE idGroupe = :idArt');
        $query->bindValue(':idArt', $idArt);
        $query->execute();
        $groupe = $query->fetchAll();
        $instance = new Groupe($groupe[0]['idGroupe'], $groupe[0]['nom']);
        $nom = $instance->getNom();
        return $nom;
    }


    public static function getArtisteById(int $idArt) : string{
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE WHERE idGroupe = :idArt');
        $query->bindValue(':idArt', $idArt);
        $query->execute();
        $groupe = $query->fetchAll();
        $instance = new Groupe($groupe[0]['idGroupe'], $groupe[0]['nom']);
        $html = '<h2>'.$instance->nom.'</h2>
                <img src="https://picsum.photos/100" alt="'.$instance->nom.'">';
        return $html;
    }
    public static function getArtisteFilter($recherche): array{
        $pdo = Database::getPdo();
        $query = $pdo->prepare('SELECT * FROM GROUPE WHERE nom LIKE :recherche ORDER BY nom ASC');
        $query->bindValue(':recherche', '%'.$recherche.'%');
        $query->execute();
        $groupes = $query->fetchAll();
        $array = [];
        foreach ($groupes as $groupe){
            $instance = new Groupe($groupe['idGroupe'], $groupe['nom']);
            array_push($array, $instance->toJSON());
        }
        return $array;
    }

}
?>