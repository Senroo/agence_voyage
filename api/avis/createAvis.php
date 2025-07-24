<?php 
use AgenceVoyage\Avis;
use AgenceVoyage\AvisManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

//Chargement du dossier utilities et classes
require_once('../../config/cnx.php');

//Check de la méthode
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode POST');
}

//Lecture et décodage du JSON
$data = json_decode(file_get_contents('php://input'), true);

//Vérification de la qualité des données
if(!isset($data['avis'], $data['voyageID'], $data['clientID']) || empty($data['avis']) ||
!is_numeric($data['voyageID']) || !is_numeric($data['clientID'])){
    JsonResponse::error('Les champs avis (string), voyageID et clientID (int) sont obligatoire', 400);
}

//Si données OK : Création de l'objet Avis
$avis = (new Avis())
    ->setAvis(trim($data['avis']))
    ->setVoyageID((int)$data['voyageID'])
    ->setClientID((int)$data['clientID']);

//Instanciation du manager pour la création de l'avis
$manager = new AvisManager($cnx);
$manager->AddAvis($avis);

JsonResponse::success('Avis ajouté', 201);

