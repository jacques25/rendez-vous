<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Formation;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @Groups("formation")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=250, nullable=false)
    */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * 
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $endAt;

   
   /**
    * @ORM\ManyToOne(targetEntity="App\Entity\SeanceOption",  inversedBy="bookings")
    * @ORM\JoinColumn(name="seance_option_id", referencedColumnName="id")
    */
   private $seanceOption;

  
    /** 
     * @Groups("formation")
     * @ORM\ManyToOne(targetEntity="App\Entity\Formation", inversedBy="booking")
     * @ORM\JoinColumn(name="formation_id", referencedColumnName="id")
     * @ORM\JoinTable(name="formation_users")
     */
    private $formation;

      /**
     * @ORM\ManyToMany(targetEntity=User::class,  mappedBy="bookings", fetch="EXTRA_LAZY", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="user_booking")
     * 
     */
     private $users;

     public function __construct()
     {
         $this->users = new ArrayCollection();
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


    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addBooking($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeBooking($this);
        }

        return $this;
    }

 
}
