<?php
use AgenceVoyage\AvisManager;
////////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');
////////////////// ZONE DE CONTROLE

////////////////// VERIFICATION DE LA METHODE
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    /** On va inclure les variables CNX et les classes */
    include('../../config/cnx.php');
    /** On va inclure les variables CNX et les classes */

    $manager = new AvisManager($cnx);
    $datas = $manager->ReadAllAvis();
    $count = $manager->CountAvis();

    if($count > 0){
        $message = [];
        foreach($datas as $data){
            $message[] = array(
                    'avisID'   => $data->getAvisID(),
                    'avis'     => $data->getAvis(),
                    'voyageID' => $data->getVoyageID(),
                    'clientID' => $data->getClientID(),
                    'voyage' => [
                        'titre' => $data->getTitre(),
                        'description' => $data->getDescription()
                    ],
                    'client' => [
                        'prenom' => $data->getPrenom(),
                        'nom' => $data->getNom(),
                        'email' => $data->getEmail()
                    ]
                );
        }
        echo json_encode($message);

    } else {
        $message = [
            'Message' => 'Aucune donées trouvées',
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