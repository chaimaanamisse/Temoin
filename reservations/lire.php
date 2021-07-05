<?php
// Headers requis  // sont necessaires pour effectuer dy controle ou pour faire des autorisations
header("Access-Control-Allow-Origin: *");  // autoriser ou interdir l'acces à votre api selon l'origine d'utilisateur
header("Content-Type: application/json; charset=UTF-8"); // quel est le contenu de la reponse pourquoi une reponse en json la norme rest envoyer des donnes qui sont consultables
header("Access-Control-Allow-Methods: GET"); // la methode acceptes pour la requete en question
header("Access-Control-Max-Age: 3600"); // la duree de vie de la requte
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // filter et empecher certain type de donnes d'tre pris en compte

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Reservations.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les produits
    $reservation = new Reservations($db);

    // On récupère les données
    $s = $reservation->lire();
    
    // On vérifie si on a au moins 1 produit
    if($s->rowCount() > 0){
        // On initialise un tableau associatif
        $tableauReservations = [];
        $tableauReservations['reservations'] = [];

        // On parcourt les produits
        while($row = $s->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $prod = [
                "id" => $id,
                "date_reservation" => $date_reservation,
                // "id_creneaux" => $id_creneaux,
                "heure_debut" => $heure_debut,
                "heure_fin" => $heure_fin
            ];

            $tableauReservations['reservations'][] = $prod;
        }

        // On envoie le code réponse 200 OK
        http_response_code(200);

        // On encode en json et on envoie
        echo json_encode($tableauReservations);
    }

}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}


   