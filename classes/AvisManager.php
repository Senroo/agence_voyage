<?php
namespace AgenceVoyage;
use AgenceVoyage\Avis;
use PDO;
use OpenApi\Attributes as OA;


#[OA\PathItem(path: '/avis')]  // <= 🔥 Important pour Swagger !

class AvisManager{
    private $cnx;

    /** Rendre la variable de connexion obligatoire */ 
    public function __construct($cnx)
    {
        $this->setCNX($cnx);                
    }
    /** Rendre la variable de connexion obligatoire */

    /** Ajouter un avis */ 
#[OA\Post(
    path: '/avis/create',
    tags: ['Avis'],
    summary: 'Ajouter un avis',
    requestBody: new OA\RequestBody(
        required: true,
        content:[
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['avis', 'voyageID', 'clientID'],
                    properties:[
                        new OA\Property(
                            property: 'avis',
                            type: 'string',
                            description: 'Avis du client',
                            example: 'Avis client'
                        ),
                        new OA\Property(
                            property: 'voyageID',
                            type: 'integer',
                            description: 'ID du voyage associé à l\'avis',
                            example: 1
                        ),
                        new OA\Property(
                            property: 'clientID',
                            type: 'integer',
                            description: 'ID du client associé à l\'avis',
                            example: 1
                        )

                    ]
                )
            )
        ]
    ),
    responses: [
        new OA\Response(response: 201, description: 'Inserer les datas'),
        new OA\Response(response: 400, description: 'Tous les champs sont obligatoires'),
        new OA\Response(response: 405, description: 'Méthode non autorisée')
    ]
)]
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
#[OA\Get(
    path: '/avis/read/{avisID}',
    tags: ['Avis'],
    summary: 'Lire un avis',
    parameters: [
        new OA\Parameter(
            name:'avisID', 
            in:'path', 
            description: 'avisID', 
            required:true,
        ),
    ],
    responses:[
        new OA\Response(
            response:200,
            description:'Avis trouvé',
            content: new OA\JsonContent(
                ref: '#/components/schemas/Aviss'
            )
        ),
            
        new OA\Response(response:404, description:'Avis non-trouvé'),
        new OA\Response(response:405, description:'Méthode non-autorisé')
    ]
)]
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

    /** Lire tous les avis */
#[OA\Get(
    path:'/avis/readAll',
    tags: ['Avis'],
    summary:'Afficher tous les avis',
    responses:[
        new OA\Response(
            response:200, 
            description: 'OK',
            content: new OA\JsonContent(
                type:"array",
                items: new OA\Items(
                    ref: "#/components/schemas/Aviss"
                )
            )
        ),
        new OA\Response(response: 405, description: 'Mauvaise Méthode'),
    ]
)]
    public function ReadAllAvis(){
        $sql = 'SELECT *
                FROM certification_avis AS avis
                JOIN certification_voyage AS voyage
                ON voyage.voyageID = avis.voyageID
                JOIN certification_client AS client
                ON client.clientID = avis.clientID';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $datas = []; // Init un tableau pour stocker les objets

        while($data = $req->fetch(PDO::FETCH_ASSOC)){
            $avis = new Avis();
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($avis, $method)){
                    $avis->$method($value);
                }
            }
            $datas[] = $avis;
        }

        return $datas;
    }
    /** Lire tous les avis */ 

    /** Compter le nombre de data dans la table*/
    public function CountAvis(){
        $sql = 'SELECT COUNT(*) AS compte FROM certification_avis';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data['compte'];
    }
    /** Compter le nombre de data dans la table*/

    /** Modifier un avis */
#[OA\Put(
    path: '/avis/update',
    tags: ['Avis'],
    summary: 'Modifier un client',
    requestBody: new OA\RequestBody(
        required: true,
        content:[
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['avis', 'voyageID', 'clientID', 'avisID'],
                    properties:[
                        new OA\Property(
                            property: 'avis',
                            type: 'string',
                            description: 'Avis du client',
                            example: 'Avis client'
                        ),
                        new OA\Property(
                            property: 'voyageID',
                            type: 'integer',
                            description: 'ID du voyage associé à l\'avis',
                            example: 1
                        ),
                        new OA\Property(
                            property: 'clientID',
                            type: 'integer',
                            description: 'ID du client associé à l\'avis',
                            example: 1
                        ),
                        new OA\Property(
                            property: 'avisID',
                            type: 'integer',
                            description: 'ID de l\'avis',
                            example: 1
                        )

                    ]
                )
            )
        ]
    ),
    responses: [
        new OA\Response(response: 201, description: 'Modifier les datas'),
        new OA\Response(response: 400, description: 'Tous les champs sont obligatoires'),
        new OA\Response(response: 405, description: 'Méthode non autorisée')
    ]
)]
    public function UpdateAvis(Avis $avis){
        $sql = 'UPDATE certification_avis SET avis = :avis, voyageID = :voyageID, clientID = :clientID, toID = 1 WHERE avisID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':avis', $avis->getAvis(), PDO::PARAM_STR);
        $req->bindValue(':voyageID', $avis->getVoyageID(), PDO::PARAM_STR);
        $req->bindValue(':clientID', $avis->getClientID(), PDO::PARAM_STR);
        $req->bindValue(':id', $avis->getAvisID(), PDO::PARAM_STR);
        $req->execute();
    }
    /** Modifier un avis */

    /** Supprimer un avis */

#[OA\Delete(
    path: '/avis/delete',
    tags: ['Avis'],
    summary: 'Supprimer un Avis',
    requestBody: new OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['avisID'],
                    properties:[
                        new OA\Property(
                            property:'avisID',
                            type:'integer',
                            description:'ID de l\'avis à supprimer',
                            example: 1
                        )      
                    ] 
                )
            )
        ]
    ),
    responses: [
        new OA\Response(response: 200, description: 'Supprimer les datas'),
        new OA\Response(response: 400, description: 'Tous les champs sont obligatoires'),
        new OA\Response(response: 405, description: 'Méthode non autorisée')
    ]
)]
    public function DeleteAvis(int $id){
        $sql = 'DELETE FROM certification_avis WHERE avisID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    } 
    /** Supprimer un avis */



    /** Connexion PDO */  
    public function setCnx($cnx){
        $this->cnx = $cnx;
    }
    /** Connexion PDO */

}