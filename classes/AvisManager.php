<?php
namespace AgenceVoyage;
use AgenceVoyage\Avis;
use PDO;
class AvisManager{
    private $cnx;

    /** Rendre la variable de connexion obligatoire */ 
    public function __construct($cnx)
    {
        $this->setCNX($cnx);                
    }
    /** Rendre la variable de connexion obligatoire */

    /** Ajouter un avis */ 
    public function AddAvis(Avis $avis){
        $sql = 'INSERT INTO certification_avis (avis, voyageID, clientID, toID) VALUES (:avis, :voyageID, :clientID, 1)';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':avis', $avis->getAvis(), PDO::PARAM_STR);
        $req->bindValue(':voyageID', $avis->getVoyageID(), PDO::PARAM_INT);
        $req->bindValue(':clientID', $avis->getClientID(), PDO::PARAM_INT);
        $req->execute();
    }   
    /** Ajouter un avis */ 

    /** Lire un avis */
    public function ReadAvis(int $id){
        $sql = 'SELECT *
                FROM certification_avis AS avis
                JOIN certification_voyage AS voyage
                ON voyage.voyageID = avis.voyageID
                JOIN certification_client AS client
                ON client.clientID = avis.clientID
                WHERE avisID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        if(!$data){
            return null;
        }

        $avis = new Avis();
        foreach($data as $key => $value){
            $method = 'set'.ucfirst($key);
            if(method_exists($avis, $method)){
                $avis->$method($value);
            }
        }
        return $avis;
    }
    /** Lire un avis */ 

    /** Connexion PDO */  
    public function setCnx($cnx){
        $this->cnx = $cnx;
    }
    /** Connexion PDO */

}