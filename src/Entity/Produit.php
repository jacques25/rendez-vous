<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable()
 */
class Produit
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
     * @Vich\UploadableField(mapping="produits_images", fileNameProperty="filename")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Boutique", inversedBy="produits")
     */
    private $boutiques;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Bijou", mappedBy="produits")
     * 
     */

    private $bijous;

    /**
     * @var string
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=128)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DescriptionProduit",  mappedBy="produits")
     */
    private $descriptionProduits;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->bijous = new ArrayCollection();
        $this->boutiques = new ArrayCollection();
        $this->descriptionProduits = new ArrayCollection();
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
    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * Undocumented function.
     *
     * @param \DateTimeInterface|null $created_at
     *
     * @return Property
     */
    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
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


    public function __toString()
    {
        return $this->title;
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
            $bijous->addProduit($this);
        }

        return $this;
    }

    public function removeBijous(Bijou $bijous): self
    {
        if ($this->bijous->contains($bijous)) {
            $this->bijous->removeElement($bijous);
            $bijous->removeProduit($this);
        }

        return $this;
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
     * @return Collection|Boutique[]
     */
    public function getBoutiques(): Collection
    {
        return $this->boutiques;
    }

    public function addBoutique(Boutique $boutique): self
    {
        if (!$this->boutiques->contains($boutique)) {
            $this->boutiques[] = $boutique;
        }

        return $this;
    }

    public function removeBoutique(Boutique $boutique): self
    {
        if ($this->boutiques->contains($boutique)) {
            $this->boutiques->removeElement($boutique);
        }

        return $this;
    }

    /**
     * @return Collection|DescriptionProduit[]
     */
    public function getDescriptionProduits(): Collection
    {
        return $this->descriptionProduits;
    }

    public function addDescriptionProduit(DescriptionProduit $descriptionProduit): self
    {
        if (!$this->descriptionProduits->contains($descriptionProduit)) {
            $this->descriptionProduits[] = $descriptionProduit;
            $descriptionProduit->addProduit($this);
        }

        return $this;
    }

    public function removeDescriptionProduit(DescriptionProduit $descriptionProduit): self
    {
        if ($this->descriptionProduits->contains($descriptionProduit)) {
            $this->descriptionProduits->removeElement($descriptionProduit);
            $descriptionProduit->removeProduit($this);
        }

        return $this;
    }

    public function addBijou(Bijou $bijou): self
    {
        if (!$this->bijous->contains($bijou)) {
            $this->bijous[] = $bijou;
            $bijou->addProduit($this);
        }

        return $this;
    }

    public function removeBijou(Bijou $bijou): self
    {
        if ($this->bijous->contains($bijou)) {
            $this->bijous->removeElement($bijou);
            $bijou->removeProduit($this);
        }

        return $this;
    }

    
}
