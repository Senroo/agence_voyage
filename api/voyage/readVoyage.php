<?php
use AgenceVoyage\Voyage;
use AgenceVoyage\VoyageManager;
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

////////////////// VERIFICATION DE LA METHODE
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['voyageID'])){
        if(is_numeric($_GET['voyageID'])){
            /** On va inclure les variables CNX et les classes */
            include('../../config/cnx.php');
            /** On va inclure les variables CNX et les classes */
            
            $voyageID = $_GET['voyageID'];
            $manager = new VoyageManager($cnx);
            $voyage = $manager->ReadTravel($voyageID);
            if($voyage !== null){
                $message = [
                    'voyageID'         => $voyage->getVoyageID(),
                    'Titre'            => $voyage->getTitre(),
                    'Description'      => $voyage->getDescription()
                ];
                echo json_encode($message);
            } else {
                $message = [
                    'errorMessage' => 'Aucun voyage trouvé avec l\'ID = '.$voyageID
                ];
                
                echo json_encode($message);
            }
        } else {
            $message = [
                'errorMessage' => 'Le voyageID doit être numérique'
            ];

            echo json_encode($message);
        }

    } else {
        $message = [
            'errorMessage' => 'Vous devez rentrer un voyageID'
        ];

        echo json_encode($message);
    }
} else {
    http_response_code(401);
    $message = [
        'errorMessage' => 'Vous avez utiliser la mauvaise méthode',
        'explication'  => 'Vous devez une méthode GET'
    ];

    echo json_encode($message);
} 
////////////////// VERIFICATION DE LA METHODE