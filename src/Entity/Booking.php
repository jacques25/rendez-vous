<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=250)
    */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt;

   
   /**
    * @ORM\ManyToOne(targetEntity="App\Entity\SeanceOption",  inversedBy="bookings")
    */
   private $seanceOption;

  
   /**
     * @Groups("formation")
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="booking")
     * @ORM\JoinColumn(name="formation_id", referencedColumnName="id")
     */
    
    private $formation;

      /**
    * @ORM\ManyToOne(targetEntity="App\Entity\UserSeance",  inversedBy="bookings")
    */
   private $userSeance;



    public function __construct(){
        $this->beginAt = new DateTime();
     
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt = null): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    
    public function getSeanceOption(): ?SeanceOption
    {
        return $this->seanceOption;
    }

    public function setSeanceOption(?SeanceOption $seanceOption): self
    {
        $this->seanceOption = $seanceOption;

        return $this;
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

    public function getUserSeance(): ?UserSeance
    {
        return $this->userSeance;
    }

    public function setUserSeance(?UserSeance $userSeance): self
    {
        $this->userSeance = $userSeance;

        return $this;
    }

   
    public function __toString()
    {
         return $this->title;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }



}
