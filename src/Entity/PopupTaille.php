<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PopupTailleRepository")
 */
class PopupTaille
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $popup;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Bijou", mappedBy="popuptailles")
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPopup(): ?string
    {
        return $this->popup;
    }

    public function setPopup(string $popup): self
    {
        $this->popup = $popup;

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
        }

        return $this;
    }

    public function removeBijous(Bijou $bijous): self
    {
        if ($this->bijous->contains($bijous)) {
            $this->bijous->removeElement($bijous);
        }

        return $this;
    }
}
