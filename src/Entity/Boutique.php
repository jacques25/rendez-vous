<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoutiqueRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable()
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
     * @ORM\Column(type="string" , length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/*")
     * @Vich\UploadableField(mapping="boutiques_images", fileNameProperty="filename")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="boutiques")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", mappedBy="boutiques")
     */

    private $produits;

    /**
     * @ORM\ManyToMany(targetEntity="Bijou", mappedBy="boutiques", indexBy="slug")
     * 
     */
    private $bijous;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=128)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DescriptionProduit", mappedBy="boutiques")
     * @ORM\JoinTable(name="boutique_description")
     */
    private $introductions;

    public function __construct()
    {

        $this->bijous = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->produit = new ArrayCollection();
        $this->descriptionProduit = new ArrayCollection();
        $this->introductions = new ArrayCollection();
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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }


    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return Collection|DescriptionProduit[]
     */
    public function getIntroductions(): Collection
    {
        return $this->introductions;
    }

    public function addIntroduction(DescriptionProduit $introduction): self
    {
        if (!$this->introductions->contains($introduction)) {
            $this->introductions[] = $introduction;
            $introduction->addBoutique($this);
        }

        return $this;
    }

    public function removeIntroduction(DescriptionProduit $introduction): self
    {
        if ($this->introductions->contains($introduction)) {
            $this->introductions->removeElement($introduction);
            $introduction->removeBoutique($this);
        }

        return $this;
    }

    public function addBijou(Bijou $bijou): self
    {
        if (!$this->bijous->contains($bijou)) {
            $this->bijous[] = $bijou;
            $bijou->addBoutique($this);
        }

        return $this;
    }

    public function removeBijou(Bijou $bijou): self
    {
        if ($this->bijous->contains($bijou)) {
            $this->bijous->removeElement($bijou);
            $bijou->removeBoutique($this);
        }

        return $this;
    }

    
}
