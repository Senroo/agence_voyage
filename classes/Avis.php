<?php
namespace AgenceVoyage;
class Avis{
    /** Attribut de la table avis */
    private $avisID;
    private $avis;
    private $voyageID;
    private $clientID;
    /** Attribut de la table avis */

    /** Attribut de la table voyage */
    private $titre;
    private $description;
    /** Attribut de la table voyage */

    /** Attribut de la table client */
    private $prenom;
    private $nom;
    private $email;
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