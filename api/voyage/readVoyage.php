<?php
use AgenceVoyage\VoyageManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

//Chargement du dossier utilities et classes
require_once('../../config/cnx.php');

//Check de la méthode
if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode GET');
}

//Vérification de la qualité des données
if(!isset($_GET['voyageID']) || empty($_GET['voyageID']) || !is_numeric($_GET['voyageID'])){
    JsonResponse::error('Le parametre voyageID (int) est obligatoire', 400);
}

//Instanciation du manager pour la lire le voyage
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
    JsonResponse::error('Aucune donées trouvé', 404);
}