<?php 
use AgenceVoyage\Client;
use AgenceVoyage\ClientManager;
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
if(!isset($data['prenom'], $data['nom'], $data['email']) || empty($data['prenom']) ||
empty($data['nom']) || empty($data['email'])){
    JsonResponse::error('Les champs "prenom", "nom" et "email" (string) sont obligatoires', 400);
}

// Vérifie si email valide
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    JsonResponse::error('L’adresse email fournie est invalide.', 400);
}

// Création de l’objet Client si les données sont valides
$client = (new Client())
    ->setPrenom(trim($data['prenom']))
    ->setNom(trim($data['nom']))
    ->setEmail(trim($data['email']));

//Instanciation du manager pour la création du client
$manager = new ClientManager($cnx);
$manager->AddClient($client);

JsonResponse::success('Client ajouté', 201);

