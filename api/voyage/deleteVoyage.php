<?php
use AgenceVoyage\VoyageManager;
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['voyageID'])){
        if(!empty($data['voyageID'])){
                /** On va inclure les variables CNX et les classes */
                include('../../config/cnx.php');
                /** On va inclure les variables CNX et les classes */
                if($data['voyageID'] > 2){
                    $manager = new VoyageManager($cnx);
                    $manager->DeleteTravel($data['voyageID']);

                    $message = [
                        'Message' => 'Voyage supprimé. à noté qu\'il ne\'est pas possible de supprimer les voyage avec l\'id 1 et 2'
                    ];
                    echo json_encode($message);
                } else {
                    $message = [
                        'Message' => 'Voyage supprimé. à noté qu\'il ne\'est pas possible de supprimer les voyage avec l\'id 1 et 2'
                    ];
                    echo json_encode($message);  
                }
            } else {
                $message = [
                    'Message' => 'Il faut rentrer un voyageID'
                ];
                echo json_encode($message);
            }
    } else {
        $message = [
            'Message' => 'Il faut rentrer un voyageID'
        ];
        echo json_encode($message);
    }
}else {
    http_response_code(401);
    $message = [
        'errorMessage' => 'Vous avez utiliser la mauvaise méthode',
        'explication'  => 'Vous devez une méthode DELETE'
    ];

    echo json_encode($message);
}