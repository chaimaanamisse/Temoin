<?php
class Reservations
{
    // Connexion
    private $connexion;
    private $table = "reservations";

    // object properties
    public $id;
    public $sujet;
    public $date_reservation;
    public $id_creneau;
    public $id_user;
    // public $created_at;


    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Lecture des produits
     *
     * @return void
     */
    public function lire()
    {
        // On écrit la requête
        // $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id ORDER BY p.created_at DESC";

        $sql = "SELECT c.heure_debut, c.heure_fin, r.date_reservation, r.id FROM " . $this->table . " r LEFT JOIN creneaux c ON r.id_creneau = c.id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On exécute la requête
        $query->execute();

        // On retourne le résultat
        return $query;
    }

    /**
     * Créer une réservation
     *
     * @return void
     */
    public function creer()
    {

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET sujet=:sujet, date_reservation=:date_reservation,  id_creneau=:id_creneau, id_user=:id_user"; //, id=:id

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        // $this->id = htmlspecialchars(strip_tags($this->id));
        $this->sujet = htmlspecialchars(strip_tags($this->sujet));
        $this->date_reservation = htmlspecialchars(strip_tags($this->date_reservation));
        $this->id_creneau = htmlspecialchars(strip_tags($this->id_creneau));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        // $this->categories_id=htmlspecialchars(strip_tags($this->ref));
        // $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        // Ajout des données protégées
        $query->bindParam(":sujet", $this->sujet);
        $query->bindParam(":date_reservation", $this->date_reservation);
        $query->bindParam(":id_creneau", $this->id_creneau);
        $query->bindParam(":id_user", $this->id_user);
        // $query->bindParam(":id", $this->id);
        // $query->bindParam(":ref", $this->categories_id);
        // $query->bindParam(":created_at", $this->created_at);
        // Exécution de la requête
        if ($query->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Lire une réservation
     *
     * @return void
     */
    public function lireUn()
    {
        // On écrit la requête
        $sql = "SELECT c.heure_debut, c.heure_fin, r.date_reservation, r.id FROM " . $this->table . " r LEFT JOIN creneaux c ON r.id_creneau = c.id WHERE p.id = ? LIMIT 0,1";
        // $sql = "SELECT c.heure_debut, c.heure_fin, r.date_reservation, r.id FROM " . $this->table . " r LEFT JOIN creneaux c ON r.id_creneau = c.id";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        $query->execute();

        // on récupère la ligne
        $row = $query->fetch(PDO::FETCH_ASSOC);

        // On hydrate l'objet
        $this->heure_debut = $row['heure_debut'];
        $this->heure_fin = $row['heure_fin'];
        $this->date_reservation = $row['date_reservation'];
        $this->id = $row['id'];
        // $this->categories_id = $row['categories_id'];
        // $this->categories_nom = $row['categories_nom'];
    }


    /**
     * Lire une réservation
     *
     * @return void
     */
    public function lireById()
    
    {
        // On écrit la requête
        $sql = "SELECT * FROM reservations r INNER JOIN creneaux c ON c.id = r.id_creneau INNER JOIN users u ON u.id = r.id_user where r.id =:id";
        // On prépare la requête
        $query = $this->connexion->prepare($sql);
        $this->id=htmlspecialchars(strip_tags($this->id));
        // On attache l'id
        $query->bindParam(":id", $this->id);
         // On exécute la requête
        $query-> execute();
    
    
        return $query;
    }

    

    /**
     * Supprimer un produit
     *
     * @return void
     */
    public function supprimer()
    {
        // On écrit la requête
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache l'id
        $query->bindParam(1, $this->id);

        // On exécute la requête
        if ($query->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Mettre à jour un produit
     *
     * @return void
     */
    public function modifier()
    {
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET date_reservation = :date_reservation, id_creneau = :id_creneau, id_user = :id_user WHERE id = :id";


        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->date_reservation = htmlspecialchars(strip_tags($this->date_reservation));
        $this->id_creneau = htmlspecialchars(strip_tags($this->id_creneau));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        // $this->categories_id=htmlspecialchars(strip_tags($this->categories_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // On attache les variables
        $query->bindParam(':date_reservation', $this->date_reservation);
        $query->bindParam(':id_creneau', $this->id_creneau);
        $query->bindParam(':id_user', $this->id_user);
        // $query->bindParam(':categories_id', $this->categories_id);
        $query->bindParam(':id', $this->id);

        // On exécute
        if ($query->execute()) {
            return true;
        }

        return false;
    }

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
}
