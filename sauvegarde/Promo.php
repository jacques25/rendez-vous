<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Bijou;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PromoRepository")
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
     * @ORM\Column(name="prix", type="decimal", scale=2)
     */
    private $prix = 00.00;
   

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
     * @ORM\Column(name="port", type="decimal",   scale=2, nullable=true)
     */
    private $port = 2.00;

    
    public function __construct()
    {
        $this->date_start = new \DateTime();
        
    }
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    private $isActive =  false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reduce")
     * @ORM\JoinColumn(nullable=true)
     */
    private $reduce;

       /**
     *  @ORM\ManyToOne(targetEntity="OptionBijou", inversedBy="promo", cascade={"persist"})
     * @ORM\JoinColumn(name="option_bijou", referencedColumnName="id", )
     *  @Groups("option_bijou")
     */
    private $option_bijou;
  


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * Get the value of isActive
     */ 
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @return  self
     */ 
    public function setIsActive($isActive = false)
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function setPort(string $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getReduce(): ?Reduce
    {
        return $this->reduce;
    }

    public function setReduce(?Reduce $reduce): self
    {
        $this->reduce = $reduce;

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

    public function getOptionBijou(): ?OptionBijou
    {
        return $this->option_bijou;
    }

    public function setOptionBijou(?OptionBijou $option_bijou): self
    {
        $this->option_bijou = $option_bijou;

        return $this;
    }

   

    
 
}
