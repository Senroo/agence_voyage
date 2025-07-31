<?php 
use AgenceVoyage\Client;
use AgenceVoyage\ClientManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

// Pour éviter les bugs liés à Swagger et swagger-bootstrap
if (php_sapi_name() === 'cli') return;

// Chargement des classes et utilitaires
require_once __DIR__ . '/../../config/cnx.php';

// Vérifie que la méthode HTTP est bien PUT
if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
    JsonResponse::error('Méthode non autorisée', 405, 'Vous devez utiliser la méthode PUT');
}

// Lecture et décodage du corps JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérifie que tous les champs obligatoires sont présents et valides
if(!isset($data['clientID'], $data['prenom'], $data['nom'], $data['email']) || empty($data['prenom']) ||
!is_numeric($data['clientID']) || empty($data['nom']) || empty($data['email'])){
    JsonResponse::error('Les champs "prenom", "nom", "email" (string) et "clientID" (int) sont obligatoires', 400);
}

// Protection des clients avec les ID 1 ou 2 (non modifiables)
if($data['clientID'] <= 2){
    JsonResponse::error('Impossible de modifier les clients avec l’ID 1 ou 2. Ces clients sont protégés.');
}

// Création de l’objet Client si les données sont valides
$client = (new Client())
    ->setClientID((int)$data['clientID'])
    ->setPrenom(trim($data['prenom']))
    ->setNom(trim($data['nom']))
    ->setEmail(trim($data['email']));

// Vérifie si le client existe avant modification
$manager = new ClientManager($cnx);
$read = $manager->ReadClient((int)$data['clientID']);

if($read == null){
    JsonResponse::error('Impossible de modifier le client', 404, 'Aucun client correspondant trouvé');
}

// Modification du client autorisée (ID strictement supérieur à 2)
$manager->UpdateClient($client);
JsonResponse::success('Client modifié avec succès', 200);
