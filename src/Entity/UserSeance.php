<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSeanceRepository")
 */

class UserSeance
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
       /**
     * @ORM\Column(type="string" ,  length=20, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Vous devez renseignez votre prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Vous devez renseignez votre nom de famille")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="Veuillez renseigner un email valide!")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true) 
     * @Assert\Length(
     *  min=10 , 
     * max=10,  
     * minMessage="Le numéro de téléphone doit avoir 10 chiffres",  
     * maxMessage="Le numéro de téléphone doit avoir 10 chiffres max")
    */
   private $phone;
   
   /**
    * @ORM\column(type="string", nullable=true)
    */
   private $backgroundColor;
   
   /**
    * @ORM\column(type="string", nullable=true)
    */
   private $color;

 /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking",  mappedBy="userSeance")
     */
    private $bookings;

   public function __construct()
   {
       $this->bookings = new ArrayCollection();
   }

   public function getId(): ?int
    {
        return $this->id;
    }


   public function getGender(): ?string
   {
       return $this->gender;
   }

   public function setGender(?string $gender): self
   {
       $this->gender = $gender;

       return $this;
   }

   public function getFirstName(): ?string
   {
       return $this->firstName;
   }

   public function setFirstName(?string $firstName): self
   {
       $this->firstName = $firstName;

       return $this;
   }

   public function getLastName(): ?string
   {
       return $this->lastName;
   }

   public function setLastName(?string $lastName): self
   {
       $this->lastName = $lastName;

       return $this;
   }

   public function getEmail(): ?string
   {
       return $this->email;
   }

   public function setEmail(?string $email): self
   {
       $this->email = $email;

       return $this;
   }

   public function getPhone(): ?string
   {
       return $this->phone;
   }

   public function setPhone(?string $phone): self
   {
       $this->phone = $phone;

       return $this;
   }

   public function getBackgroundColor(): ?string
   {
       return $this->backgroundColor;
   }

   public function setBackgroundColor(?string $backgroundColor): self
   {
       $this->backgroundColor = $backgroundColor;

       return $this;
   }

   public function getColor(): ?string
   {
       return $this->color;
   }

   public function setColor(?string $color): self
   {
       $this->color = $color;

       return $this;
   }

   /**
    * @return Collection|booking[]
    */
   public function getBookings(): Collection
   {
       return $this->bookings;
   }

   public function addBooking(booking $booking): self
   {
       if (!$this->bookings->contains($booking)) {
           $this->bookings[] = $booking;
           $booking->setUserSeance($this);
       }

       return $this;
   }

   public function removeBooking(booking $booking): self
   {
       if ($this->bookings->contains($booking)) {
           $this->bookings->removeElement($booking);
           // set the owning side to null (unless already changed)
           if ($booking->getUserSeance() === $this) {
               $booking->setUserSeance(null);
           }
       }

       return $this;
   }


}
