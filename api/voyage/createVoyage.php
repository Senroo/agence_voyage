<?php 
use AgenceVoyage\Voyage;
use AgenceVoyage\VoyageManager;
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
    JsonResponse::error('Méthode non autorisée', 405, 'Vous devez utiliser la méthode POST');
}

// Lecture et décodage du corps JSON
$data = json_decode(file_get_contents('php://input'), true);

// Vérifie la présence et la validité des champs requis
if(!isset($data['titre'], $data['description']) || empty($data['titre']) || empty($data['description'])){
    JsonResponse::error('Les champs "titre" et "description" (string) sont obligatoires', 400);
}

//Vérification de la longueur du titre
if(strlen($data['titre']) > 255){
    JsonResponse::error('Le titre ne doit pas dépasser 255 caractères', 400);
}

// Création de l’objet Voyage si les données sont valides
$voyage = (new Voyage())
    ->setTitre(trim($data['titre']))
    ->setDescription(trim($data['description']));

//Instanciation du manager pour la création du voyage
$manager = new VoyageManager($cnx);
$manager->AddTravel($voyage);

JsonResponse::success('Voyage ajouté', 201);

