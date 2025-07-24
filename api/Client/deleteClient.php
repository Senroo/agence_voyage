<?php
use AgenceVoyage\ClientManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

//Chargement du dossier utilities et classes
require_once('../../config/cnx.php');

if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
    JsonResponse::error('Méthode non-autorisé', 405, 'Vous devez utiliser la méthode DELETE');
}

//Lecture et décodage du JSON
$data = json_decode(file_get_contents('php://input'), true);

//Vérification de la qualité des données
if(!isset($data['clientID']) || empty($data['clientID']) || !is_numeric($data['clientID'])){
    JsonResponse::error('Le champ clientID (int) est obligatoire', 400);
}

//On supprime le client seulement si elle existe
$manager = new ClientManager($cnx);
$read = $manager->ReadClient($data['clientID']);

if($read == null){
    JsonResponse::error('Client introuvable', 404);
}

// On protege les avis avec les ID 1 et 2
if($data['clientID'] <= 2){
    JsonResponse::error('Impossible de supprimer les clients avec l’ID 1 ou 2. Ces client sont protégés.', 403);
}

//Instanciation du manager pour supprimer le client si son ID est strictement supérieur à 2
$manager->DeleteClient($data['clientID']);
JsonResponse::success('Client supprimé avec succès', 200);
