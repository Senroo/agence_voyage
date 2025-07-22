<?php
namespace AgenceVoyage;
use PDO;
class VoyageManager{
    private $cnx;

    /** Rendre la variable de connexion obligatoire */ 
    public function __construct($cnx)
    {
        $this->SetCnx($cnx);
    }
    /** Rendre la variable de connexion obligatoire */ 

    /** Ajouter un voyage */ 
    public function AddTravel(Voyage $voyage){
        $sql = 'INSERT INTO certification_voyage (titre, description, toID) VALUES (:titre, :description, 1)';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':titre', $voyage->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':description', $voyage->getDescription(), PDO::PARAM_STR);
        $req->execute();
    }   
    /** Ajouter un voyage */ 

    /** Afficher un voyage*/
    public function ReadTravel(int $id){
        $sql = 'SELECT * FROM certification_voyage WHERE voyageID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        if(!empty($data)){
            $client = new Voyage();
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
    /** Afficher un voyage */ 

    /** Afficher tous les voyage*/ 
    public function ReadAllTravel(){
        $sql = 'SELECT * FROM certification_voyage';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $voyages = [];
        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            $voyage = new Voyage();
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($voyage, $method)){
                    $voyage->$method($value);
                }
            }
            $voyages[] = $voyage;
        }

        return $voyages;
    }   
    /** Afficher tous les voyage*/ 

    /** Compter le nombre de data dans la table*/
    public function CountTravel(){
        $sql = 'SELECT COUNT(*) as compte FROM certification_voyage';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data['compte'];
    }
    /** Compter le nombre de data dans la table*/

    /** Modifier un voyage*/
    public function UpdateVoyage(Voyage $voyage){
        $sql = 'UPDATE certification_voyage SET titre = :titre, description = :description, toID = 1 WHERE voyageID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':titre', $voyage->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':description', $voyage->getDescription(), PDO::PARAM_STR);
        $req->bindValue(':id', $voyage->getVoyageID(), PDO::PARAM_INT);
        $req->execute();

    }
    /** Modifier un voyage*/   

    /** Supprimer un voyage*/  
    public function DeleteTravel(int $id){
        $sql = 'DELETE FROM certification_voyage WHERE voyageID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    } 
    /** Supprimer un voyage*/   

    /** Connexion PDO */  
    public function SetCnx($cnx){
        $this->cnx = $cnx;
    }
    /** Connexion PDO */  
}