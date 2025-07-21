<?php
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

////////////////// VERIFICATION DE LA METHODE
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['clientID'])){
        if(is_numeric($_GET['clientID'])){
            /** On va inclure les variables CNX et les classes */
            include('../../config/cnx.php');
            /** On va inclure les variables CNX et les classes */
            
            $clientID = $_GET['clientID'];
            $manager = new ClientManager($cnx);
            $client = $manager->ReadClient($clientID);
            if($client !== null){
                $message = [
                    'clientID' => $client->getClientID(),
                    'Prenom'   => $client->getPrenom(),
                    'Nom'      => $client->getNom(),
                    'Email'    => $client->getEmail()
                ];
                echo json_encode($message);
            } else {
                $message = [
                    'errorMessage' => 'Aucun client trouvé avec l\'ID = '.$clientID
                ];
                
                echo json_encode($message);
            }
        } else {
            $message = [
                'errorMessage' => 'Le clientID doit être numérique'
            ];

            echo json_encode($message);
        }

    } else {
        $message = [
            'errorMessage' => 'Vous devez rentrer un clientID'
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