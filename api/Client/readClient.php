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

// Vérifie que le paramètre GET "clientID" est présent et valide
if(!isset($_GET['clientID']) || empty($_GET['clientID']) || !is_numeric($_GET['clientID'])){
    JsonResponse::error('Le paramètre clientID (int) est obligatoire', 400);
}

// Instanciation du manager pour récupérer le client
$manager = new ClientManager($cnx);
$data = $manager->ReadClient($_GET['clientID']);
if($data !== null){
    $message = [
        'clientID'  => $data->getClientID(),
        'prenom'    => $data->getPrenom(),
        'nom'       => $data->getNom(),
        'email'     => $data->getEmail()
    ];
    
    JsonResponse::send($message);

} else {
    JsonResponse::error('Aucune donnée trouvée', 200);
}