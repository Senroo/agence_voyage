<?php 
use AgenceVoyage\Avis;
use AgenceVoyage\AvisManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

if (php_sapi_name() === 'cli') return;


//Chargement du dossier utilities et classes
require_once __DIR__ . '/../../config/cnx.php';

//Check de la méthode
if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode PUT');
}

//Lecture et décodage du JSON
$data = json_decode(file_get_contents('php://input'), true);

//Vérification de la qualité des données
if(!isset($data['avisID'], $data['avis'], $data['voyageID'], $data['clientID']) || empty($data['avis']) ||
!is_numeric($data['voyageID']) || !is_numeric($data['clientID']) || !is_numeric($data['avisID'])){
    JsonResponse::error('Les champs  avis (string), avisID, voyageID et clientID (int) sont obligatoire', 400);
}

// On protege les avis avec les ID 1 et 2
if($data['avisID'] <= 2){
    JsonResponse::error('Impossible de modifier les avis avec l’ID 1 ou 2. Ces avis sont protégés.');
}

//Si données OK : Création de l'objet Avis
$avis = (new Avis())
    ->setAvisID((int)$data['avisID'])
    ->setAvis(trim($data['avis']))
    ->setVoyageID((int)$data['voyageID'])
    ->setClientID((int)$data['clientID']);

//On modifie la donnée si elle existe
$manager = new AvisManager($cnx);
$read = $manager->ReadAvis($data['avisID']);

if($read == null){
    JsonResponse::error('Impossible de modifier l’avis', 404, 'Aucun avis correspondant trouvé');
}

// Modification autorisée uniquement pour les avis dont l'ID est strictement supérieur à 2 et existe
$manager->UpdateAvis($avis);

JsonResponse::success('Avis modifié avec succès', 200);
