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
    if(isset($_GET['avisID'])){
        if(is_numeric($_GET['avisID'])){
            /** On va inclure les variables CNX et les classes */
            include('../../config/cnx.php');
            /** On va inclure les variables CNX et les classes */
            
            $avisID = $_GET['avisID'];
            $manager = new AvisManager($cnx);
            $avis = $manager->ReadAvis($avisID);
            if($avis !== null){
                $message = [
                    'avisID'   => $avis->getAvisID(),
                    'avis'     => $avis->getAvis(),
                    'voyageID' => $avis->getVoyageID(),
                    'clientID' => $avis->getClientID(),
                    'voyage' => [
                        'titre' => $avis->getTitre(),
                        'description' => $avis->getDescription()
                    ],
                    'client' => [
                        'prenom' => $avis->getPrenom(),
                        'nom' => $avis->getNom(),
                        'email' => $avis->getEmail()
                    ]
                ];
                echo json_encode($message);
            } else {
                $message = [
                    'errorMessage' => 'Aucun avis trouvé avec l\'ID = '.$avisID
                ];
                
                echo json_encode($message);
            }
        } else {
            $message = [
                'errorMessage' => 'AvisID doit être numérique'
            ];

            echo json_encode($message);
        }

    } else {
        $message = [
            'errorMessage' => 'Vous devez rentrer un avisID'
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