<?php
namespace AgenceVoyage;
use PDO;
use OpenApi\Attributes as OA;

#[OA\PathItem(path: '/voyages')]
class VoyageManager{

    private $cnx;

/** Initialise la connexion PDO (obligatoire) */

    public function __construct($cnx)
    {
        $this->setCnx($cnx);
    }

/** Initialise la connexion PDO (obligatoire) */


/** Insère un nouveau voyage en base de données */

#[OA\Post(
    path: '/voyage/create',
    tags: ['Voyage'],
    summary: 'Ajouter un voyage',
    requestBody: new OA\RequestBody(
        required: true,
        content:[
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['titre', 'description'],
                    properties:[
                        new OA\Property(
                            property:'titre',
                            type:'string',
                            example:'Titre du voyage'
                        ),
                        new OA\Property(
                            property:'description',
                            type:'string',
                            example:'Description du voyage'
                        ),
                    ]
                )
            )
        ]
    ),
    responses: [
        new OA\Response(response: 201, description: 'Voyage ajouté avec succès'),
        new OA\Response(response: 400, description: 'Tous les champs sont obligatoires'),
        new OA\Response(response: 405, description: 'Méthode non autorisée')
    ]
)]
    public function AddTravel(Voyage $voyage){
        $sql = 'INSERT INTO certification_voyage (titre, description, toID) VALUES (:titre, :description, 1)';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':titre', $voyage->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':description', $voyage->getDescription(), PDO::PARAM_STR);
        $req->execute();
    }   

/** Insère un nouveau voyage en base de données */


/** Récupère un voyage par son ID */

#[OA\Get(
    path: '/voyage/read/{voyageID}',
    tags: ['Voyage'],
    summary: 'Voir un voyage',
    parameters: [
        new OA\Parameter(
            name:'voyageID', 
            in:'path', 
            description: 'voyageID', 
            required:true,
        ),
    ],
    responses:[
        new OA\Response(
            response:200,
            description:'Voyage trouvé',
            content: new OA\JsonContent(
                ref: '#/components/schemas/Voyage'
            )
        ),  
        new OA\Response(response:404, description:'Voyage non-trouvé'),
        new OA\Response(response:405, description:'Méthode non-autorisé')
    ]
)]
    public function ReadTravel(int $id){
        $sql = 'SELECT * FROM certification_voyage WHERE voyageID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);

        if(!empty($data)){
            $voyage = new Voyage();
            foreach($data as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($voyage, $method)){
                    $voyage->$method($value);
                }
            }
            return $voyage;
        } else {
            return null;
        }
    }

/** Récupère un voyage par son ID */


/** Récupère la liste de tous les voyages */

#[OA\Get(
    path:'/voyage/readAll',
    tags: ['Voyage'],
    summary:'Afficher tous les voyages',
    responses:[
        new OA\Response(
            response:200, 
            description: 'OK',
            content: new OA\JsonContent(
                type:"array",
                items: new OA\Items(
                    ref: "#/components/schemas/Voyage"
                )
            )
        ),
        new OA\Response(response: 405, description: 'Mauvaise Méthode'),
    ]
)]
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
    
/** Récupère la liste de tous les voyages */


/** Retourne le nombre total de voyages enregistrés */

    public function CountTravel(){
        $sql = 'SELECT COUNT(*) as compte FROM certification_voyage';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data['compte'];
    }

/** Retourne le nombre total de voyages enregistrés */


/** Met à jour les informations d’un voyage */

#[OA\Put(
    path: '/voyage/update',
    tags: ['Voyage'],
    summary: 'Modifier un voyage',
    requestBody: new OA\RequestBody(
        required: true,
        content:[
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['voyageID','titre', 'description'],
                    properties:[
                        new OA\Property(
                            property:'voyageID',
                            type:'integer',
                            example:1
                        ),
                        new OA\Property(
                            property:'titre',
                            type:'string',
                            example:'Titre du voyage'
                        ),
                        new OA\Property(
                            property:'description',
                            type:'string',
                            example:'Description du voyage'
                        ),
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
    public function UpdateVoyage(Voyage $voyage){
        $sql = 'UPDATE certification_voyage SET titre = :titre, description = :description, toID = 1 WHERE voyageID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':titre', $voyage->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':description', $voyage->getDescription(), PDO::PARAM_STR);
        $req->bindValue(':id', $voyage->getVoyageID(), PDO::PARAM_INT);
        $req->execute();

    }

/** Met à jour les informations d’un voyage */

/** Supprime un voyage à partir de son ID */

#[OA\Delete(
    path: '/voyage/delete',
    tags: ['Voyage'],
    summary: 'Supprimer un voyage',
    requestBody: new OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['voyageID'],
                    properties:[
                        new OA\Property(
                            property:'voyageID',
                            type:'integer',
                            description:'ID du voyage à supprimer',
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
    public function DeleteTravel(int $id){
        $sql = 'DELETE FROM certification_voyage WHERE voyageID = :id';
        $req = $this->cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
    } 

/** Supprime un voyage à partir de son ID */

/** Injecte la connexion PDO */

    public function setCnx($cnx){
        $this->cnx = $cnx;
    }

/** Injecte la connexion PDO */

}