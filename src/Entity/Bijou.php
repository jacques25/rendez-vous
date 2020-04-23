<?php

namespace App\Entity;

use App\Entity\Picture;
use App\Entity\OptionBijou;
use App\Entity\PropertiesBijou;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BijouRepository")
 * @Vich\Uploadable()
 */
class Bijou
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=128)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string" , length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/*")
     * @Vich\UploadableField(mapping="bijoux_images", fileNameProperty="filename")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Produit",inversedBy="bijous")
     * )
     * 
     */
    private $produits;

    /**
     * @var array
     * @ORM\ManyToMany(targetEntity="Boutique", inversedBy="bijous")
     * 
     */
    private $boutiques;

    /**
     * @ORM\OneToMany(targetEntity="OptionBijou", mappedBy="bijou", cascade={"persist", "remove"})
     * @ORM\OrderBy({"taille"="ASC"})
     */
    private $option_bijou;



    /**
     * @ORM\ManyToOne(targetEntity="PropertiesBijou", inversedBy="bijous",cascade={"persist"})
     * @ORM\JoinColumn(name="properties_bijou", referencedColumnName="id", )
     */
    private $properties_bijou;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="bijou", cascade={"persist"}, orphanRemoval=true)
     */
    private $pictures;

    /**
     * @Assert\All({ 
     * @Assert\Image(mimeTypes="image/*")
     * })
     *
     */
    private $pictureFiles;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo = false;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\PopupTaille", inversedBy="bijous",  cascade={"persist"})
     */
    private $popuptailles;



    public function __construct()
    {

        $this->option_bijou = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->boutiques = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->popuptailles = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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



    /**
     * @return Collection|OptionBijou[]
     */
    public function getOptionBijou(): Collection
    {
        return $this->option_bijou;
    }

    public function addOptionBijou(OptionBijou $optionBijou): self
    {
        $this->option_bijou[] = $optionBijou;
        $optionBijou->setBijou($this);


        return $this;
    }

    public function removeOptionBijou(OptionBijou $optionBijou): self
    {
        if ($this->option_bijou->contains($optionBijou)) {
            $this->option_bijou->removeElement($optionBijou);
            // set the owning side to null (unless already changed)
            if ($optionBijou->getBijou() === $this) {
                $optionBijou->setBijou(null);
            }
        }

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

    public function getPropertiesBijou(): ?PropertiesBijou
    {
        return $this->properties_bijou;
    }

    public function setPropertiesBijou(?PropertiesBijou $properties_bijou): self
    {
        $this->properties_bijou = $properties_bijou;

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
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setBijou($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getBijou() === $this) {
                $picture->setBijou(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPictureFiles()
    {
        return $this->pictureFiles;
    }

    /**
     * @param mixed $pictureFiles
     * @return Bijou
     */
    public function setPictureFiles($pictureFiles): self
    {
        foreach ($pictureFiles as $pictureFile) {
            $picture = new Picture();
            $picture->setImageFile($pictureFile);
            $this->addPicture($picture);
        }
        $this->pictureFiles = $pictureFiles;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|PopupTaille[]
     */
    public function getPopuptailles(): Collection
    {
        return $this->popuptailles;
    }

    public function addPopuptailles(PopupTaille $popuptaille): self
    {
        if (!$this->popuptailles->contains($popuptaille)) {
            $this->popuptailles[] = $popuptaille;
            $popuptaille->addBijous($this);
        }

        return $this;
    }

    public function removePopuptailles(PopupTaille $popuptaille): self
    {
        if ($this->popuptailles->contains($popuptaille)) {
            $this->popuptailles->removeElement($popuptaille);
            $popuptaille->removeBijous($this);
        }

        return $this;
    }

    public function addPopuptaille(PopupTaille $popuptaille): self
    {
        if (!$this->popuptailles->contains($popuptaille)) {
            $this->popuptailles[] = $popuptaille;
        }

        return $this;
    }

    public function removePopuptaille(PopupTaille $popuptaille): self
    {
        if ($this->popuptailles->contains($popuptaille)) {
            $this->popuptailles->removeElement($popuptaille);
        }

        return $this;
    }
}
