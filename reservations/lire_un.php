<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

    $donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $reservation->id = $donnees->id;

        // On récupère le produit
        $reservation->lireUn();
        var_dump( $reservation);

        // On vérifie si le produit existe
        if($reservation->date_reservation != null){

            $prod = [
                "id" => $reservation->id,
                "date_reservation" => $reservation->date_reservation,
                "heure_debut" => $reservation->heure_debut,
                "heure_fin" => $reservation->heure_fin
                
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($prod);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "La reservation n'existe pas."));
        }
        
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}