<?php
namespace AgenceVoyage;
use PDO;
use OpenApi\Attributes as OA;

#[OA\PathItem(path: '/client')]  // <= 🔥 Important pour Swagger !

class ClientManager{
    private $cnx;

    /** Rendre la variable de connexion obligatoire */ 
    public function __construct($cnx)
    {
        $this->setCNX($cnx);                
    }
    /** Rendre la variable de connexion obligatoire */ 

    /** Ajouter un client */ 

#[OA\Post(
    path: '/client/create',
    tags: ['Client'],
    summary: 'Ajouter un client',
    requestBody: new OA\RequestBody(
        required: true,
        content:[
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['prenom', 'nom', 'email'],
                    properties:[
                        new OA\Property(
                            property:'prenom',
                            type:'string',
                            example:'John'
                            
                        ),
                        new OA\Property(
                            property:'nom',
                            type:'string',
                            example: 'Doe'
                        ),
                        new OA\Property(
                            property:'email',
                            type:'string',
                            example:'John.Doe@gmail.com'
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
#[OA\Get(
    path: '/client/read/{clientID}',
    tags: ['Client'],
    summary: 'Voir un client',
    parameters: [
        new OA\Parameter(
            name:'clientID', 
            in:'path', 
            description: 'clientID', 
            required:true,
        ),
    ],
    responses:[
        new OA\Response(
            response:200,
            description:'Client trouvé',
            content: new OA\JsonContent(
                ref: '#/components/schemas/Client'
            )
        ),  
        new OA\Response(response:404, description:'Client non-trouvé'),
        new OA\Response(response:405, description:'Méthode non-autorisé')
    ]
)]
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
#[OA\Get(
    path:'/client/readAll',
    tags: ['Client'],
    summary:'Afficher tous les clients',
    responses:[
        new OA\Response(
            response:200, 
            description: 'OK',
            content: new OA\JsonContent(
                type:"array",
                items: new OA\Items(
                    ref: "#/components/schemas/Client"
                )
            )
        ),
        new OA\Response(response: 405, description: 'Mauvaise Méthode'),
    ]
)]
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
#[OA\Put(
    path: '/client/update',
    tags: ['Client'],
    summary: 'Modifier un client',
    requestBody: new OA\RequestBody(
        required: true,
        content:[
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['clientID','prenom', 'nom', 'email'],
                    properties:[
                        new OA\Property(
                            property:'prenom',
                            type:'string',
                            example:'John'
                            
                        ),
                        new OA\Property(
                            property:'nom',
                            type:'string',
                            example: 'Doe'
                        ),
                        new OA\Property(
                            property:'email',
                            type:'string',
                            example:'John.Doe@gmail.com'
                        ),
                        new OA\Property(
                            property:'clientID',
                            type:'integer',
                            example: 1
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

#[OA\Delete(
    path: '/client/delete',
    tags: ['Client'],
    summary: 'Supprimer un client',
    requestBody: new OA\RequestBody(
        required: true,
        content: [
            new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['clientID'],
                    properties:[
                        new OA\Property(
                            property:'clientID',
                            type:'integer',
                            description:'ID du client à supprimer',
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