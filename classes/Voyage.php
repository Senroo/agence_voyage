<?php 
namespace AgenceVoyage;
use OpenApi\Attributes as OA;

/**
 * Classe représentant un voyage enregistré dans la base de données.
 */

class Voyage{

#[OA\Schema(
    schema:'Voyage',
    type:'object',
    description: 'Représente un voyage',
    properties:[
        new OA\Property(
            property:'voyageID',
            type:'integer',
            description:'Clé unique du voyage'
        ),
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
)]

    private int $voyageID;
    private string $titre;
    private string $description;
    private int $toID;


    public function setVoyageID($voyageID): self{
        $this->voyageID = $voyageID;
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

    public function setToID(int $toID): self{
        $this->toID = $toID;
        return $this;
    }

    public function getVoyageID(): int{
        return $this->voyageID;
    }

    public function getTitre(): string{
        return $this->titre;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function getToID(): int{
        return $this->toID;
    }

}