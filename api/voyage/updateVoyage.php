<?php 
use AgenceVoyage\Voyage;
use AgenceVoyage\VoyageManager;
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
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode PUT');
}

//Lecture et décodage du JSON
$data = json_decode(file_get_contents('php://input'), true);

//Vérification de la qualité des données
if(!isset($data['titre'], $data['description'], $data['voyageID']) || empty($data['titre']) || empty($data['description'])
    || !is_numeric($data['voyageID'])){
    JsonResponse::error('Les champs titre et description (string) et voyageID (int) sont obligatoires', 400);
}

if(strlen($data['titre']) > 250){
    JsonResponse::error('Le titre ne doit pas dépasser 255 caractères', 400);
}

// On protege les voyages avec les ID 1 et 2
if($data['voyageID'] <= 2){
    JsonResponse::error('Impossible de modifier les voyages avec l’ID 1 ou 2. Ces voyages sont protégés.');
}

//Si données OK : Création de l'objet voyages
$voyage = (new Voyage())
    ->setVoyageID($data['voyageID'])
    ->setTitre(trim($data['titre']))
    ->setDescription(trim($data['description']));

//On modifie la donnée si elle existe
$manager = new VoyageManager($cnx);
$read = $manager->ReadTravel((int)$data['voyageID']);

if($read == null){
    JsonResponse::error('Impossible de modifier le voyage', 404, 'Aucun voyage correspondant trouvé');
}

// Modification autorisée uniquement pour les voyage dont l'ID est strictement supérieur à 2 et existe
$manager->UpdateVoyage($voyage);

JsonResponse::success('Voyage modifié avec succès', 200);
