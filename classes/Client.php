<?php
class Client{
    private $clientID;
    private $prenom;
    private $nom;
    private $email;
    private $toID;

    public function setClientID($clientID): self{
        $this->clientID = $clientID;
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

    public function setToID(int $toID): self{
        $this->toID = $toID;
        return $this;
    }

    public function getClientID(){
        return $this->clientID;
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

    public function getToID(): int{
        return $this->toID;
    }

}