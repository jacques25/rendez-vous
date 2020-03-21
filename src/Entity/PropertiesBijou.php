<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertiesBijouRepository")
 */
class PropertiesBijou
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aimant;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=2, nullable=true)
     */
    private $puissance_aimant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $revetement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $finition;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur_pierre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre_propriete;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matiere;

    /**
     * @ORM\OneToMany(targetEntity="Bijou", mappedBy="properties_bijou")
     * 
     */
    private $bijous;

    public function __construct()
    {
        $this->bijous = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAimant(): ?string
    {
        return $this->aimant;
    }

    public function setAimant(?string $aimant): self
    {
        $this->aimant = $aimant;

        return $this;
    }

    public function getPuissanceAimant()
    {
        return $this->puissance_aimant;
    }

    public function setPuissanceAimant($puissance_aimant): self
    {
        $this->puissance_aimant = $puissance_aimant;

        return $this;
    }

    public function getRevetement(): ?string
    {
        return $this->revetement;
    }

    public function setRevetement(?string $revetement): self
    {
        $this->revetement = $revetement;

        return $this;
    }

    public function getFinition(): ?string
    {
        return $this->finition;
    }

    public function setFinition(?string $finition): self
    {
        $this->finition = $finition;

        return $this;
    }

    public function getCouleurPierre(): ?string
    {
        return $this->couleur_pierre;
    }

    public function setCouleurPierre(?string $couleur_pierre): self
    {
        $this->couleur_pierre = $couleur_pierre;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getAutrePropriete(): ?string
    {
        return $this->autre_propriete;
    }

    public function setAutrePropriete(?string $autre_propriete): self
    {
        $this->autre_propriete = $autre_propriete;

        return $this;
    }


    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(?string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @return Collection|Bijou[]
     */
    public function getBijous(): Collection
    {
        return $this->bijous;
    }

    public function addBijous(Bijou $bijous): self
    {
        if (!$this->bijous->contains($bijous)) {
            $this->bijous[] = $bijous;
            $bijous->setPropertiesBijou($this);
        }

        return $this;
    }

    public function removeBijous(Bijou $bijous): self
    {
        if ($this->bijous->contains($bijous)) {
            $this->bijous->removeElement($bijous);
            // set the owning side to null (unless already changed)
            if ($bijous->getPropertiesBijou() === $this) {
                $bijous->setPropertiesBijou(null);
            }
        }

        return $this;
    }
}