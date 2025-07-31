<?php
use AgenceVoyage\ClientManager;
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

// Instanciation du manager pour récupérer tous les clients
$manager = new ClientManager($cnx);
$datas = $manager->ReadAllClient();
if(!empty($datas)){
    $messages = [];
    foreach($datas as $data){
        $messages[] = array(
            'clientID'  => $data->getClientID(),
            'prenom'    => $data->getPrenom(),
            'nom'       => $data->getNom(),
            'email'     => $data->getEmail()
        );
    }
    JsonResponse::send($messages);
} else {
    JsonResponse::error('Aucune donnée trouvée', 200);
}