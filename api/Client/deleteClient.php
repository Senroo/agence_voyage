<?php
use AgenceVoyage\ClientManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

// Pour éviter les bugs liés à Swagger et swagger-bootstrap
if (php_sapi_name() === 'cli') return;

// Chargement des classes et utilitaires
require_once __DIR__ . '/../../config/cnx.php';

// Vérifie que la méthode HTTP est bien DELETE
if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
    JsonResponse::error('Méthode non autorisée', 405, 'Vous devez utiliser la méthode DELETE');
}

// Lecture et décodage du corps JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérifie la présence et la validité du champ clientID
if(!isset($data['clientID']) || empty($data['clientID']) || !is_numeric($data['clientID'])){
    JsonResponse::error('Le champ clientID (int) est obligatoire', 400);
}

// Suppression du client uniquement s’il existe
$manager = new ClientManager($cnx);
$read = $manager->ReadClient($data['clientID']);

if($read == null){
    JsonResponse::error('Client introuvable', 404);
}

// Protection des clients avec les ID 1 ou 2 (non supprimables)
if($data['clientID'] <= 2){
    JsonResponse::error('Impossible de supprimer les clients avec l’ID 1 ou 2. Ces clients sont protégés.', 403);
}

// Suppression du client autorisée (ID strictement supérieur à 2)
$manager->DeleteClient($data['clientID']);
JsonResponse::success('Client supprimé avec succès', 200);
