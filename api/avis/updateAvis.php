<?php 
use AgenceVoyage\Avis;
use AgenceVoyage\AvisManager;
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

// Vérifie la validité des données reçues
if(!isset($data['avisID'], $data['avis'], $data['voyageID'], $data['clientID']) || empty($data['avis']) ||
!is_numeric($data['voyageID']) || !is_numeric($data['clientID']) || !is_numeric($data['avisID'])){
    JsonResponse::error('Les champs avis (string), avisID, voyageID et clientID (int) sont obligatoires', 400);
}

// Protection des avis avec les ID 1 ou 2 (non modifiables)
if($data['avisID'] <= 2){
    JsonResponse::error('Impossible de modifier les avis avec l’ID 1 ou 2. Ces avis sont protégés.');
}

// Création de l'objet Avis si les données sont valides
$avis = (new Avis())
    ->setAvisID((int)$data['avisID'])
    ->setAvis(trim($data['avis']))
    ->setVoyageID((int)$data['voyageID'])
    ->setClientID((int)$data['clientID']);

// Vérifie l’existence de l’avis à modifier
$manager = new AvisManager($cnx);
$read = $manager->ReadAvis($data['avisID']);

if($read == null){
    JsonResponse::error('Impossible de modifier l’avis', 404, 'Aucun avis correspondant trouvé');
}

// Modification de l’avis autorisée (ID strictement supérieur à 2)
$manager->UpdateAvis($avis);

JsonResponse::success('Avis modifié avec succès', 200);
