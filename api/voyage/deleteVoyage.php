<?php
use AgenceVoyage\VoyageManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

if (php_sapi_name() === 'cli') return;


//Chargement du dossier utilities et classes
require_once __DIR__ . '/../../config/cnx.php';


if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
    JsonResponse::error('Méthode non-autorisé', 405, 'Vous devez utiliser la méthode DELETE');
}

//Lecture et décodage du JSON
$data = json_decode(file_get_contents('php://input'), true);

//Vérification de la qualité des données
if(!isset($data['voyageID']) || empty($data['voyageID']) || !is_numeric($data['voyageID'])){
    JsonResponse::error('Le champ voyageID (int) est obligatoire', 400);
}

//On supprime le voyage seulement si elle existe
$manager = new VoyageManager($cnx);
$read = $manager->ReadTravel($data['voyageID']);

if($read == null){
    JsonResponse::error('Voyage introuvable', 404);
}

// On protege les avis avec les ID 1 et 2
if($data['voyageID'] <= 2){
    JsonResponse::error('Impossible de supprimer les voyages avec l’ID 1 ou 2. Ces voyages sont protégés.', 403);
}

//Instanciation du manager pour supprimer le voyage si son ID est strictement supérieur à 2
$manager->DeleteTravel($data['voyageID']);
JsonResponse::success('Voyage supprimé avec succès', 200);
