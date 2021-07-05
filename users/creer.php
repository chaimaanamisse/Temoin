<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie la méthode
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Users.php';

    // On instancie la base de données
    $database = new Database();
    $db = $database->getConnection();

    // On instancie les utilisateurs
    $user = new Users($db);

    // On récupère les informations envoyées
    $donnees = json_decode(file_get_contents("php://input"));
    
    if(!empty($donnees->fullName) && !empty($donnees->cin)&& !empty($donnees->phoneNumber) ){ //&& !empty($donnees->phoneNumber && !empty($donnees->ref))
        // Ici on a reçu les données
        // On hydrate notre objet
        
        $user->fullName = $donnees->fullName;
        $user->cin = $donnees->cin;
        $user->phoneNumber = $donnees->phoneNumber;
        $user->ref = $donnees->phoneNumber.''.bin2hex(random_bytes(8));

        if($user->creer()){
            // Ici la création a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "L'ajout a été effectué", "ref" =>" $user->ref"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué"]);         
        }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}


