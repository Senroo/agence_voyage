<?php
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

////////////////// VERIFICATION DE LA METHODE
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /** On récupere les data envoyé via un json */
    $data = json_decode(file_get_contents('php://input'), true);
    if((!empty($data['titre'])) && (!empty($data['description']))){
        http_response_code(201);

        /** On va inclure les variables CNX et les classes */
        include('../../config/cnx.php');
        /** On va inclure les variables CNX et les classes */

        /** On affecte les valeurs à notre objet Client */
        $voyage = (new Voyage())
                    ->setTitre($data['titre'])
                    ->setDescription($data['description']);
        /** On affecte les valeurs à notre objet Client */

        /** On va instancier notre manager pour créer le voyage*/
        $manager = new VoyageManager($cnx);
        $manager->AddTravel($voyage);
        /** On va instancier notre manager pour créer le voyage*/

        /** Evoie d'un message pour confirmer la création du voyage */
        $message = [
            'message' => 'Le voyage à bien été crée'
        ];

        echo json_encode($message);
        /** Evoie d'un message pour confirmer la création du voyage */

    } else {
        http_response_code(400);
        $message = [
            'errorMessage' => 'Les champs titre, description'
        ];
        echo json_encode($message);
    }

} else {
    http_response_code(401);
    $message = [
        'errorMessage' => 'Vous avez utiliser la mauvaise méthode',
        'explication'  => 'Vous devez une méthode POST'
    ];

    echo json_encode($message);
} 
////////////////// VERIFICATION DE LA METHODE