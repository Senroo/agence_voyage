<?php
use AgenceVoyage\Voyage;
use AgenceVoyage\VoyageManager;
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

////////////////// VERIFICATION DE LA METHODE
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $data = json_decode(file_get_contents('php://input'), true);
    if((!empty($data['titre'])) && (!empty($data['description'])) && (!empty($data['voyageID']))){
        /** On va inclure les variables CNX et les classes */
        include('../../config/cnx.php');
        /** On va inclure les variables CNX et les classes */
        /** On empeche la modification des voyage avec un ID inférieur à 2 */
        if($data['voyageID'] > 2){
            /** On affecte les valeurs à notre objet voyage */
            $voyage = (new Voyage())
                        ->setTitre($data['titre'])
                        ->setDescription($data['description'])
                        ->setVoyageID($data['voyageID']);

            /** On va instancier notre manager pour modifier le voyage*/
            $manager = new VoyageManager($cnx);
            $manager->UpdateVoyage($voyage);


            /** Evoie d'un message pour confirmer la modification du voyage */
            $message = [
                'Message' => 'Voyage modifié, à noté qu\'il ne\'est pas possible de modifier les voyages avec l\'id 1 et 2'
            ];
            echo json_encode($message);
        } else {
            $message = [
                'Message' => 'Voyage modifié, à noté qu\'il ne\'est pas possible de modifier les voyages avec l\'id 1 et 2'
            ];
            echo json_encode($message); 
        }
            /** Evoie d'un message pour confirmer la modification du voyage */
    } else {
        http_response_code(400);
        $message = [
            'errorMessage' => 'Les champs voyageID, titre, description sont obligatoire'
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