<?php

namespace App\Entity;

use Serializable;
use App\Entity\UserAdress;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable()
 * @UniqueEntity(
 * fields={"email"},
 * message="Un utilisateur s'est déjà inscrit avec cette adresse email, merci de la modifier"
 * )
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string" ,  length=20)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseignez votre prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseignez votre nom de famille")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="les mots de passe ne sont pas identiques")
     */

    public $passwordConfirm;

  /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking",  mappedBy="user")
     */
    private $bookings;


        /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

       /**
     * @ORM\ManytoOne(targetEntity="App\Entity\Formation", inversedBy="users")
     */
    private $formation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"firstName"})
     */
    private $slug;


    /**
     * @ORM\Column(type="string" , length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/*")
     * @Vich\UploadableField(mapping="users_images", fileNameProperty="filename")
     *
     * @var File
     */
    private $imageFile;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;


    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(name="subscribedToNewsletter", type="boolean", nullable=true)
     */
    private $subscribedToNewsletter;
    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    /**
     * @var string le token qui servira pour inscription
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $confirmToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserAdress", mappedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandes", mappedBy="user")
     */
    private $commandes;

    public function __construct()
    {
        $this->enabled = false;
        $this->subscribedToNewsletter = false;
        $this->addresses = new ArrayCollection();
        $this->commandes = new ArrayCollection();
  
       $this->bookings = new ArrayCollection();
   
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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
     * @return User
     */
    public function setUpdatedAt(\DateTimeInterface $updated_at): User
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface 
     
     */
    public function getRoles()
    {
       $tmpRoles = $this->roles;
     
      if(in_array('ROLE_USER', $tmpRoles) === false ){
          $tmpRoles[] = 'ROLE_USER';
      }

      return $tmpRoles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    function addRole($role) {
        $this->roles[] = $role;
    }
   



    public function getSalt()
    {
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials()
    {
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

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->enabled,
            $this->confirmToken,
         
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->enabled,
            $this->confirmToken,
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }



    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function setConfirmToken(?string $confirmToken): self
    {
        $this->confirmToken = $confirmToken;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|UserAdress[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(UserAdress $address): self
    {

        $this->addresses[] = $address;
        $address->setUser($this);

        return $this;
    }

    public function removeAddress(UserAdress $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    public function getSubscribedToNewsletter(): ?bool
    {
        return $this->subscribedToNewsletter;
    }

    public function setSubscribedToNewsletter(bool $subscribedToNewsletter): self
    {
        $this->subscribedToNewsletter = $subscribedToNewsletter;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

   public function getDateNaissance(): ?\DateTimeInterface
   {
       return $this->date_naissance;
   }

   public function setDateNaissance(\DateTimeInterface $date_naissance): self
   {
       $this->date_naissance = $date_naissance;

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


   
}
