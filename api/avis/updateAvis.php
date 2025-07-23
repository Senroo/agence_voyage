<?php

use AgenceVoyage\Avis;
use AgenceVoyage\AvisManager;
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

////////////////// VERIFICATION DE LA METHODE
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $data = json_decode(file_get_contents('php://input'), true);
    if((!empty($data['avis'])) && (!empty($data['voyageID'])) && (!empty($data['clientID'])) && (!empty($data['avisID']))){
        /** On va inclure les variables CNX et les classes */
        include('../../config/cnx.php');
        /** On va inclure les variables CNX et les classes */
        /** On empeche la modification des client avec un ID inférieur à 2 */
        if($data['avisID'] > 2){
            /** On affecte les valeurs à notre objet Client */
            $avis = (new Avis())
                        ->setAvis($data['avis'])
                        ->setVoyageID($data['voyageID'])
                        ->setClientID($data['clientID'])
                        ->setAvisID($data['avisID']);

            /** On va instancier notre manager pour modifier le client*/
            $manager = new AvisManager($cnx);
            $manager->UpdateAvis($avis);


            /** Evoie d'un message pour confirmer la modification du client */
            $message = [
                'Message' => 'Avis modifié, à noté qu\'il ne\'est pas possible de modifier les avis avec l\'id 1 et 2'
            ];
            echo json_encode($message);
        } else {
            $message = [
                'Message' => 'Avis modifié, à noté qu\'il ne\'est pas possible de modifier les avis avec l\'id 1 et 2'
            ];
            echo json_encode($message); 
        }
            /** Evoie d'un message pour confirmer la modification du client */
    } else {
        http_response_code(400);
        $message = [
            'errorMessage' => 'Les champs avisID, avis, voyageID et clientID sont obligatoire'
        ];
        echo json_encode($message);
    }
}else {
    http_response_code(401);
    $message = [
        'errorMessage' => 'Vous avez utiliser la mauvaise méthode',
        'explication'  => 'Vous devez une méthode PUT'
    ];

    echo json_encode($message);
}
////////////////// VERIFICATION DE LA METHODE