<?php
use AgenceVoyage\AvisManager;
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
if(!isset($data['avisID']) || empty($data['avisID']) || !is_numeric($data['avisID'])){
    JsonResponse::error('Le champ avisID (int) est obligatoire', 400);
}

//On supprime l'avi seulement si elle existe
$manager = new AvisManager($cnx);
$read = $manager->ReadAvis($data['avisID']);

if($read == null){
    JsonResponse::error('Impossible de supprimer l’avis', 403, 'Aucun avis correspondant trouvé');
}

// On protege les avis avec les ID 1 et 2
if($data['avisID'] <= 2){
    JsonResponse::error('Impossible de supprimer les avis avec l’ID 1 ou 2. Ces avis sont protégés.', 403);
}

//Instanciation du manager pour supprimer l'avis si son ID est strictement supérieur à 2
$manager->DeleteAvis($data['avisID']);
JsonResponse::success('Avis supprimé avec succès', 200);
