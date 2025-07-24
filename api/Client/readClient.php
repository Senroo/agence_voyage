<?php
use AgenceVoyage\ClientManager;
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
if(!isset($_GET['clientID']) || empty($_GET['clientID']) || !is_numeric($_GET['clientID'])){
    JsonResponse::error('Le parametre clientID (int) est obligatoire', 400);
}

//Instanciation du manager pour la lire le client
$manager = new ClientManager($cnx);
$data = $manager->ReadClient($_GET['clientID']);
if($data !== null){
    $message = [
        'clientID'  => $data->getClientID(),
        'prenom'    => $data->getPrenom(),
        'nom'       => $data->getNom(),
        'email'     => $data->getEmail()
    ];
    
    JsonResponse::send($message);

} else {
    JsonResponse::error('Aucune donées trouvé', 404);
}