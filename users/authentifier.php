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
    
    if(!empty($donnees->ref)){ 
        // Ici on a reçu les données
        // On hydrate notre objet

        $user->ref = $donnees->ref;
        $count=$user->authentifier();
        

        $id = $user->authentifier();
    
    if($user->authentifier()){
        $arr = array('id' => $id, 'existe'=> true);
        echo json_encode($arr);
    }
    else
    {
        $arr = array('id' => null, 'existe'=> false);
        echo json_encode($arr);
    }
    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
