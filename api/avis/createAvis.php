<?php 
use AgenceVoyage\Avis;
use AgenceVoyage\AvisManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

// Pour éviter les bugs liés à Swagger et swagger-bootstrap
if (php_sapi_name() === 'cli') return;


// Chargement des classes et utilitaires
require_once __DIR__ . '/../../config/cnx.php';


// Vérifie que la méthode HTTP est bien POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode POST');
}

// Lecture et décodage du corps JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérification de la validité des données reçues
if(!isset($data['avis'], $data['voyageID'], $data['clientID']) || empty($data['avis']) ||
!is_numeric($data['voyageID']) || !is_numeric($data['clientID'])){
    JsonResponse::error('Les champs "avis" (string), "voyageID" et "clientID" (entiers) sont obligatoires.', 400);
}

// Création de l’objet Avis si les données sont valides
$avis = (new Avis())
    ->setAvis(trim($data['avis']))
    ->setVoyageID((int)$data['voyageID'])
    ->setClientID((int)$data['clientID']);

// Instanciation du manager et insertion de l’avis
$manager = new AvisManager($cnx);
$manager->AddAvis($avis);

JsonResponse::success('Avis ajouté', 201);

