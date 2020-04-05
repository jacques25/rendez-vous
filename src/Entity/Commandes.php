<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandesRepository")
 */
class Commandes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valider;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_commande;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero_commande;

    /**
     * @ORM\Column(type="array")
     */
    private $commande = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValider(): ?bool
    {
        return $this->valider;
    }

    public function setValider(bool $valider): self
    {
        $this->valider = $valider;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getNumeroCommande(): ?int
    {
        return $this->numero_commande;
    }

    public function setNumeroCommande(int $numero_commande): self
    {
        $this->numero_commande = $numero_commande;

        return $this;
    }

    public function getCommande(): ?array
    {
        return $this->commande;
    }

    public function setCommande(array $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
