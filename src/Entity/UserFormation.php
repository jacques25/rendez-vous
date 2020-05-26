<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as  Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserFormationRepository;
use App\Entity\User as BaseUser;


/**
 * @ORM\Entity(repositoryClass=UserFormationRepository::class)
 * @UniqueEntity("email")
 */
class UserFormation
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
     * @ORM\Column(type="date")
     */
    private $date_naissance;

       /**
     * @ORM\ManytoOne(targetEntity="App\Entity\Formation", inversedBy="userFormations")
     */
    private $formation;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\Email()
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

    
    public function getId(): ?int
    {
        return $this->id;
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


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    
}
