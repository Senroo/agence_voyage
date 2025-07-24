<?php 
use AgenceVoyage\Client;
use AgenceVoyage\ClientManager;
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
if(!isset($data['prenom'], $data['nom'], $data['email']) || empty($data['prenom']) ||
empty($data['nom']) || empty($data['email'])){
    JsonResponse::error('Les champs prenom, nom et email (string) sont obligatoire', 400);
}

//Si données OK : Création de l'objet Client
$client = (new Client())
    ->setPrenom(trim($data['prenom']))
    ->setNom(trim($data['nom']))
    ->setEmail(trim($data['email']));

//Instanciation du manager pour la création du client
$manager = new ClientManager($cnx);
$manager->AddClient($client);

JsonResponse::success('Client ajouté', 201);

