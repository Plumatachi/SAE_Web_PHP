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

    public function getIdRole(): int{
        return $this->idRole;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPseudo(): string{
        return $this->pseudo;
    }

    public function getMDP(): string{
        return $this->mdp;
    }

    public function verifEmail($email): bool{
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function addUser($nom, $prenom, $email, $pseudo, $mdp): void{
        $pdo = Database::getPdo();
        $emails = $pdo->query("SELECT email FROM UTILISATEUR");
        foreach ($mail as $emails){
            if ($mail == $email){
                
            }
        }
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

        $_SESSION['pseudo'] = $pseudo;
        header("Location: index.php");
        exit();
    }

    public static function connexion($pseudo, $mdp): void{
        if ($pseudo != ""){
            $pdo = Database::getPdo();
            try{
                $mdpPDO = $pdo->query('SELECT motDePasse FROM UTILISATEUR where pseudo = "' . $pseudo. '"')->fetchColumn();
            }
            catch(PDOException $e){
                var_dump($e->getMessage());
            }
            if ($mdpPDO == $mdp){
                $_SESSION['pseudo'] = $pseudo;
                header("Location: index.php");
                exit();
            }else{
                header("Location: page_login.php");
                exit();
            }
        }
    }

    public static function isAdmin(): bool{
        $pdo = Database::getPdo();
        if (!isset($_SESSION['pseudo'])){
            return false;
        }
        $pseudo = $_SESSION['pseudo'];
        $idRole = $pdo->query('SELECT idRole FROM UTILISATEUR where pseudo = "' . $pseudo. '"')->fetchColumn();
        if ($idRole == 1){
            return true;
        }else{
            return false;
        }
    }


    public static function deconnexion(): void{
        session_destroy();
        header("Location: index.php");
    }
}
?>