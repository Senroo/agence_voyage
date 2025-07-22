<?php
namespace AgenceVoyage;
use PDO;
class ClientManager{
    private $cnx;

    /** Rendre la variable de connexion obligatoire */ 
    public function __construct($cnx)
    {
        $this->setCNX($cnx);                
    }
    /** Rendre la variable de connexion obligatoire */ 

    /** Ajouter un client */ 
    public function AddClient(Client $client){
        $sql = 'INSERT INTO certification_client (prenom, nom, email, toID) VALUES (:prenom, :nom, :email, 1)';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);
        $req->bindValue(':email', $client->getEmail(), PDO::PARAM_STR);

        $req->execute();
    }   
    /** Ajouter un client */ 

    /** Afficher un client*/
    public function ReadClient(int $id){
        $sql = 'SELECT * FROM certification_client WHERE clientID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        if(!empty($data)){
            $client = new Client();
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($client, $method)){
                    $client->$method($value);
                }
            }
            return $client;
        } else {
            return null;
        }
    }
    /** Afficher un client */ 

    /** Afficher tous les clients*/ 
    public function ReadAllClient(){
        $sql = 'SELECT * FROM certification_client';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $clients = [];
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            $client = new Client();
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($client, $method)){
                    $client->$method($value);
                }
            }
            $clients[] = $client;
        }

        return $clients;
    }   
    /** Afficher tous les clients*/ 
    
    /** Compter le nombre de data dans la table*/
    public function CountClient(){
        $sql = 'SELECT COUNT(*) as compte FROM certification_client';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data['compte'];
    }
    /** Compter le nombre de data dans la table*/

    /** Modifier un client*/
    public function UpdateClient(Client $client){
        $sql = 'UPDATE certification_client SET prenom = :prenom, nom = :nom, email = :email, toID = 1 WHERE clientID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);
        $req->bindValue(':email', $client->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':id', $client->getClientID(), PDO::PARAM_INT);
        $req->execute();

    }
    /** Modifier un client*/   

    /** Supprimer un client*/  
    public function DeleteClient(int $id){
        $sql = 'DELETE FROM certification_client WHERE clientID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    } 
    /** Supprimer un client*/   
    
    /** Connexion PDO */  
    public function setCNX($cnx){
        $this->cnx = $cnx;
    }
    /** Connexion PDO */
}