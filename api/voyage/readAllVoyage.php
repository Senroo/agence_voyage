<?php
use AgenceVoyage\VoyageManager;
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
        $manager = new VoyageManager($cnx);
        $datas = $manager->ReadAllTravel();
        $count = $manager->CountTravel();
        if($count > 0){
            $message = [];
            foreach($datas as $data){
                $message[] = array(
                    'voyageID'         => $data->getVoyageID(),
                    'Titre'            => $data->getTitre(),
                    'Description'      => $data->getDescription()
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