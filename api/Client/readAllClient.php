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

//Instanciation du manager pour la lire tous les clients
$manager = new ClientManager($cnx);
$datas = $manager->ReadAllClient();
if(!empty($datas)){
    $messages = [];
    foreach($datas as $data){
        $messages[] = array(
            'clientID'  => $data->getClientID(),
            'prenom'    => $data->getPrenom(),
            'nom'       => $data->getNom(),
            'email'     => $data->getEmail()
        );
    }
    JsonResponse::send($messages);
} else {
    JsonResponse::error('Aucune donées trouvé', 404);
}