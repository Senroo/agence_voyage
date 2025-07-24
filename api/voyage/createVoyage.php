<?php 
use AgenceVoyage\Voyage;
use AgenceVoyage\VoyageManager;
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
if(!isset($data['titre'], $data['description']) || empty($data['titre']) || empty($data['description'])){
    JsonResponse::error('Les champs titre et description (string) sont obligatoire', 400);
}

//Vérification de la longueur du titre
if(strlen($data['titre']) > 250){
    JsonResponse::error('Le titre ne doit pas faire plus de 255 caractères', 400);
}

//Si données OK : Création de l'objet voyage
$voyage = (new Voyage())
    ->setTitre(trim($data['titre']))
    ->setDescription(trim($data['description']));

//Instanciation du manager pour la création du voyage
$manager = new VoyageManager($cnx);
$manager->AddTravel($voyage);

JsonResponse::success('Voyage ajouté', 201);

