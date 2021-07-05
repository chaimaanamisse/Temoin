<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../config/Database.php';
include_once '../models/Reservations.php';
include_once '../models/Users.php';


$database = new Database();
$db = $database->getConnection();


$reservation = new Reservations($db);
$users =new Users ($db);

$data = json_decode(file_get_contents("php://input"));
$reservation->id = $data->id;

$result = $reservation->lireById();
$num = $result->rowCount();
if ($num) {
    $reservation_arr = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $reservation_item = array(
            'cin' => $cin,
            'fullName' => $fullName,
            'id' => $id,
            'date_reservation' => $date_reservation,
            'heure_debut' => $heure_debut,
            'sujet' => $sujet
        );

        array_push($reservation_arr, $reservation_item);
    }
    echo json_encode($reservation_arr);
} else {
    echo json_encode(
        array("no")
    );
}