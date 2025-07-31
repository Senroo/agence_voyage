<?php
use AgenceVoyage\VoyageManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

// Pour éviter les bugs liés à Swagger et swagger-bootstrap
if (php_sapi_name() === 'cli') return;


// Chargement des classes et utilitaires
require_once __DIR__ . '/../../config/cnx.php';


// Vérifie que la méthode HTTP est bien GET
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    JsonResponse::error('Méthode non autorisée', 405, 'Vous devez utiliser la méthode GET');
}

//Vérification de la qualité des données
if(!isset($_GET['voyageID']) || empty($_GET['voyageID']) || !is_numeric($_GET['voyageID'])){
    JsonResponse::error('Le paramètre voyageID (int) est obligatoire', 400);
}

//Instanciation du manager pour lire le voyage
$manager = new VoyageManager($cnx);
$data = $manager->ReadTravel($_GET['voyageID']);
if($data !== null){
    $message = [
        'voyageID'          => $data->getVoyageID(),
        'titre'             => $data->getTitre(),
        'description'       => $data->getDescription()
    ];
    
    JsonResponse::send($message);

} else {
    JsonResponse::error('Aucune donnée trouvée', 404);
}