<?php
include_once 'Reservations.php';
class Creneaux{

    private $connexion;
    private $table = "creneaux";
    // Ici, placer les méthodes pour les catégories
    // object properties
    public $id;
    public $heure_debut;
    public $heure_fin;
    
    

     /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    
   
    

    /**
     * Lecture des produits
     *
     * @return void
     */
    public function lireCreneauxDispo()
    {
        // On écrit la requête
        // $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id ORDER BY p.created_at DESC";

        $sql = "SELECT * FROM creneaux WHERE id NOT IN(SELECT id_creneau FROM reservations WHERE date_reservation= ?)";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute([$this->date_reservation]);

        // On retourne le résultat
        return $query;
    }

    public function verificationCreneau() {

        $query = " SELECT *FROM creneau WHERE id_creneau NOT IN(SELECT fk_creneau FROM rdv WHERE date= ?)";

        $req = $this->conn->prepare($query);
        $req->execute([$this->date]);

        return  $req;
    }



   

   

    
}

