<?php
use AgenceVoyage\AvisManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

if (php_sapi_name() === 'cli') return;


//Chargement du dossier utilities et classes
require_once __DIR__ . '/../../config/cnx.php';

//Check de la méthode
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode GET');
}

//Instanciation du manager pour la lire tous les avis
$manager = new AvisManager($cnx);
$datas = $manager->ReadAllAvis();
if(!empty($datas)){
    $messages = [];
    foreach($datas as $data){
        $messages[] = array(
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
    JsonResponse::send($messages);
} else {
    JsonResponse::error('Aucune donées trouvé', 404);
}