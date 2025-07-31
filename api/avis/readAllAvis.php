<?php
use AgenceVoyage\AvisManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

// Pour éviter les bugs liés à Swagger et swagger-bootstrap
if (php_sapi_name() === 'cli') return;


// Chargement des classes et utilitaires
require_once __DIR__ . '/../../config/cnx.php';

// Vérifie que la méthode HTTP est bien GET
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    JsonResponse::error('Méthode non autorisée', 405, 'Vous devez utiliser la méthode GET');
}

// Instanciation du manager pour lire tous les avis
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
    JsonResponse::error('Aucune donnée trouvée', 404);
}