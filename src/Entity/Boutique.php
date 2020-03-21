<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoutiqueRepository")
 * @UniqueEntity("title")
 */
class Boutique
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Photo", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="boutiques", fetch="EXTRA_LAZY")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", mappedBy="boutiques", fetch="LAZY")
     */

    private $produits;

    /**
     * @ORM\ManyToMany(targetEntity="Bijou", mappedBy="boutiques", indexBy="slug", fetch="LAZY")
     * 
     */
    private $bijous;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=128)
     */
    private $slug;

    public function __construct()
    {

        $this->bijous = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->produit = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * Undocumented function.
     *
     * @param \DateTimeInterface|null $updated_at
     *
     * @return Property
     */
    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of photo.
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of photo.
     *
     * @return self
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

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
            $bijous->addBoutique($this);
        }

        return $this;
    }

    public function removeBijous(Bijou $bijous): self
    {
        if ($this->bijous->contains($bijous)) {
            $this->bijous->removeElement($bijous);
            $bijous->removeBoutique($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }



    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {

        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }
}
