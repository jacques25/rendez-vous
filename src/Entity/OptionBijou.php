<?php

namespace App\Entity;

use App\Entity\Bijou;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OptionBijouRepository")
 */
class OptionBijou
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="prix", type="decimal", scale=2)
     */
    private $prix = 00.00;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"taille"})
     */
    private $taille;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dimensions;

    /**
     * @var bool
     * @ORM\Column(name="disponible", type="boolean")
     */
    private $disponible = false;


    /**
     * @ORM\ManyToOne(targetEntity="Bijou", inversedBy="option_bijou")
     * @ORM\JoinColumn(name="bijou_id", referencedColumnName="id")
     */
    private $bijou;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getBijou(): ?Bijou
    {
        return $this->bijou;
    }

    public function setBijou(?Bijou $bijou): self
    {
        $this->bijou = $bijou;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }
}