<?php
class Users{

    private $connexion;
    private $table = "users";
    // Ici, placer les méthodes pour les catégories
    // object properties
    public $id;
    public $fullName;
    public $phoneNumber;
    public $cin;
    public $ref;
    

     /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    
    /**
     * Créer un produit
     *
     * @return void
     */
    public function creer(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET  fullName=:fullName, phoneNumber=:phoneNumber, cin=:cin, ref=:ref ";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        // $this->id=htmlspecialchars(strip_tags($this->id));
        $this->fullName=htmlspecialchars(strip_tags($this->fullName));
        $this->cin=htmlspecialchars(strip_tags($this->cin));
        $this->ref=htmlspecialchars(strip_tags($this->ref));
        $this->phoneNumber=htmlspecialchars(strip_tags($this->phoneNumber));
        // $this->categories_id=htmlspecialchars(strip_tags($this->ref));
        // $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        // Ajout des données protégées
        $query->bindParam(":fullName", $this->fullName);
        $query->bindParam(":cin", $this->cin);
        $query->bindParam(":phoneNumber", $this->phoneNumber);
        $query->bindParam(":ref", $this->ref);
        // $query->bindParam(":id", $this->id);
        // $query->bindParam(":ref", $this->categories_id);
        // $query->bindParam(":created_at", $this->created_at);

        // Exécution de la requête
        if($query->execute()){
            return true;
        }
        return false;
    }



    public function authentifier(){

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = 'SELECT * FROM ' . $this->table . '   WHERE  ref = :ref';

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
       
        $this->ref=htmlspecialchars(strip_tags($this->ref));
       
        // Ajout des données protégées
        $query->bindParam(":ref", $this->ref);
       

        // Exécution de la requête
        $query->execute();

        $row   = $query->fetch(PDO::FETCH_ASSOC);
     
        $count = $query->rowCount();        

       if($count == 1)
       {
        $this->id = $row['id'];
        return  $row['id'];
        } 
        else {
         return false;
      }  
       
    }


   

    
}


 