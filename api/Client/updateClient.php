<?php 
use AgenceVoyage\Client;
use AgenceVoyage\ClientManager;
use Utilities\JsonResponse;

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods, Content-Type, Authorization, x-Requested-With');

if (php_sapi_name() === 'cli') return;


//Chargement du dossier utilities et classes
require_once __DIR__ . '/../../config/cnx.php';


//Check de la méthode
if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
    JsonResponse::error('Méthode non autorisé', 405, 'Vous devez utiliser la méthode PUT');
}

//Lecture et décodage du JSON
$data = json_decode(file_get_contents('php://input'), true);

//Vérification de la qualité des données
if(!isset($data['clientID'], $data['prenom'], $data['nom'], $data['email']) || empty($data['prenom']) ||
!is_numeric($data['clientID']) || empty($data['nom']) || empty($data['email'])){
    JsonResponse::error('Les champs  prenom, nom et email (string) et clientID (int) sont obligatoire', 400);
}

// On protege les clients avec les ID 1 et 2
if($data['clientID'] <= 2){
    JsonResponse::error('Impossible de modifier les clients avec l’ID 1 ou 2. Ces avis sont protégés.');
}

//Si données OK : Création de l'objet Client
$client = (new Client())
    ->setClientID((int)$data['clientID'])
    ->setPrenom(trim($data['prenom']))
    ->setNom(trim($data['nom']))
    ->setEmail(trim($data['email']));

//On modifie la donnée si elle existe
$manager = new ClientManager($cnx);
$read = $manager->ReadClient((int)$data['clientID']);

if($read == null){
    JsonResponse::error('Impossible de modifier le client', 404, 'Aucun client correspondant trouvé');
}

// Modification autorisée uniquement pour les clients dont l'ID est strictement supérieur à 2 et existe
$manager->UpdateClient($client);

JsonResponse::success('Client modifié avec succès', 200);
