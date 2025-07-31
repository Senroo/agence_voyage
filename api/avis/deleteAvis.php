<?php
use AgenceVoyage\AvisManager;
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

// Vérification de la validité de l'ID transmis
if(!isset($data['avisID']) || empty($data['avisID']) || !is_numeric($data['avisID'])){
    JsonResponse::error('Le champ avisID (int) est obligatoire', 400);
}

// Suppression uniquement si l'avis existe
$manager = new AvisManager($cnx);
$read = $manager->ReadAvis($data['avisID']);

if($read == null){
    JsonResponse::error('Impossible de supprimer l’avis', 403, 'Aucun avis correspondant trouvé');
}

// Protection des avis avec l’ID 1 ou 2 (non supprimables)
if($data['avisID'] <= 2){
    JsonResponse::error('Impossible de supprimer les avis avec l’ID 1 ou 2. Ces avis sont protégés.', 403);
}

// Suppression de l’avis autorisée (ID strictement supérieur à 2)
$manager->DeleteAvis($data['avisID']);
JsonResponse::success('Avis supprimé avec succès', 200);
