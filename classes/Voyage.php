<?php 
namespace AgenceVoyage;
class Voyage{
    private $voyageID;
    private $titre;
    private $description;
    private $toID;

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