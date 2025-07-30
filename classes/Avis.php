<?php
namespace AgenceVoyage;

use OpenApi\Attributes as OA;
class Avis{

#[OA\Schema(
    schema: 'Avis',
    type: 'object',
    description: 'Représente un avis client',
    properties:[
        new OA\Property(
            property:'avisID',
            type: 'integer',
            description:'Clé unique de l\'avis'
        ),
        new OA\Property(
            property:'avis',
            type:'string',
            description:'avis du client sur le voyage'
        ),
        new OA\Property(
            property:'voyageID',
            type:'integer',
            description:'Identifiant du voyage'
        ),
        new OA\Property(
            property:'clientID',
            type:'integer',
            description:'Identifiant du client'
        )
    ],
)]

#[OA\Schema(
    schema: 'Aviss',
    type:'object',
    description: 'Affichage d\'un avis client',
    properties:[
        new OA\Property(
            property:'avisID',
            type: 'integer',
            description:'Clé unique de l\'avis'
        ),
        new OA\Property(
            property:'avis',
            type:'string',
            description:'avis du client sur le voyage'
        ),
        new OA\Property(
            property:'voyageID',
            type:'integer',
            description:'Identifiant du voyage'
        ),
        new OA\Property(
            property:'clientID',
            type:'integer',
            description:'Identifiant du client'
        ),
        new OA\Property(
            property: 'voyage',
            type:'object',
            description:'Détails du voyage',
            properties: [
                new OA\Property(
                    property:'titre',
                    type:'string',
                    description:'Titre du voyage'
                ),
                new OA\Property(
                    property:'description',
                    type:'string',
                    description:'Description du voyage'
                ),
            ]
        ),
        new OA\Property(
            property:'client',
            type:'object',
            description:'Détails du client',
            properties:[
                new OA\Property(
                    property:'prenom',
                    type:'string',
                    description: 'Prénom du client'
                ),
                new OA\Property(
                    property:'nom',
                    type:'string',
                    description: 'Nom du client'
                ),
                new OA\Property(
                    property:'email',
                    type:'string',
                    description: 'Email du client'
                ),
            ]
        )
    ]

)]
    /** Attribut de la table avis */
    private int $avisID;
    private string $avis;
    private int $voyageID;
    private int $clientID;
    /** Attribut de la table avis */

    /** Attribut de la table voyage */
    private string $titre;
    private string $description;
    /** Attribut de la table voyage */

    /** Attribut de la table client */
    private string $prenom;
    private string $nom;
    private string $email;
    /** Attribut de la table client */

    public function setAvisID($avisID): self{
        $this->avisID = $avisID;
        return $this;
    }

    public function setAvis(string $avis): self{
        $this->avis = $avis;
        return $this;
    }

    public function setVoyageID(int $voyageID): self{
        $this->voyageID = $voyageID;
        return $this;
    }

    public function setClientID(int $clientID): self{
        $this->clientID = $clientID;
        return $this;
    }

    public function setTitre(string $titre): self{
        $this->titre = $titre;
        return $this;
    }

    public function setDescription(string $description): self{
        $this->description = $description;
        return $this;
    }

    public function setPrenom(string $prenom): self{
        $this->prenom = $prenom;
        return $this;
    }

    public function setNom(string $nom): self{
        $this->nom = $nom;
        return $this;
    }

    public function setEmail(string $email): self{
        $this->email = $email;
        return $this;
    }

    public function getAvisID(): int{
        return $this->avisID;
    }

    public function getAvis(): string{
        return $this->avis;
    }

    public function getVoyageID(): int{
        return $this->voyageID;
    }

    public function getClientID(): int{
        return $this->clientID;
    }

    public function getTitre(): string{
        return $this->titre;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getEmail(): string{
        return $this->email;
    }
}