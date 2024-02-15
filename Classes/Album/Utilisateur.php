<?php
namespace Album;
use Album\Database;
use PDO;

class Utilisateur{
    protected $idRole;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $pseudo;
    protected $mdp;

    public function __construct($nom, $prenom, $email, $pseudo, $mdp){
        $this->idRole = 2;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->mdp = $mdp;
    }

    public function getIdRole(){
        return $this->idRole;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPseudo(){
        return $this->pseudo;
    }

    public function getMDP(){
        return $this->mdp;
    }

    public static function addUser($nom, $prenom, $email, $pseudo, $mdp){
        $pdo = Database::getPdo();
        $idRole = 2;
        $query = 'INSERT INTO UTILISATEUR (idRole, nom, prenom, email, pseudo, motDePasse) VALUES (?,?,?,?,?,?)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $idRole, PDO::PARAM_INT);
        $stmt->bindParam(2, $nom, PDO::PARAM_STR);
        $stmt->bindParam(3, $prenom, PDO::PARAM_STR);
        $stmt->bindParam(4, $email, PDO::PARAM_STR);
        $stmt->bindParam(5, $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(6, $mdp, PDO::PARAM_STR);
        $stmt->execute();
    }
}
?>