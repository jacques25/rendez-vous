<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
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
    private $label;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=128)
     * @Gedmo\Slug(fields={"label"})
     */
    private $slug;

         /**
     * @ORM\Column(name="promoIsActive", type="boolean", nullable=true)
     *
     */
    private $promoIsActive =  false;
  
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @param DateTime|null 
     */
    private $date_start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @param DateTime|null 
     */
    private $date_end;

    /**
     *
     * @ORM\Column(type="float",   scale=2, nullable=true)
     */
    private $port = 2.00;

      /**
     * @ORM\Column(type="float",  scale=2, nullable=true)
     */
    private $multiplicate;

     /**
     * 
     * @ORM\OneToMany(targetEntity="Bijou", mappedBy="promo")
     * @ORM\JoinColumn(name="bijou_id", referencedColumnName="id")
     */
    private $bijou;

    public function __construct()
    {
        $this->bijou = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getPromoIsActive(): ?bool
    {
        return $this->promoIsActive;
    }

    public function setPromoIsActive(?bool $promoIsActive): self
    {
        $this->promoIsActive = $promoIsActive;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getPort(): ?float
    {
        return $this->port;
    }

    public function setPort(?float $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getMultiplicate(): ?float
    {
        return $this->multiplicate;
    }

    public function setMultiplicate(?float $multiplicate): self
    {
        $this->multiplicate = $multiplicate;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function addBijou(Bijou $bijou): self
    {
        if (!$this->bijou->contains($bijou)) {
            $this->bijou[] = $bijou;
            $bijou->setPromo($this);
        }

        return $this;
    }

    public function removeBijou(Bijou $bijou): self
    {
        if ($this->bijou->contains($bijou)) {
            $this->bijou->removeElement($bijou);
            // set the owning side to null (unless already changed)
            if ($bijou->getPromo() === $this) {
                $bijou->setPromo(null);
            }
        }

        return $this;
    }
}
