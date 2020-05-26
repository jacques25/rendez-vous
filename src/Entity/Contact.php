<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $gender;
  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\NotBlank()
   * @Assert\Length(min=2, max=100)
   * @var string|null
   */
  private $firstname;

  /**
   * @ORM\Column(type="string", length=250)
   * @Assert\NotBlank()
   * @Assert\Length(min=2, max=100)
   * @var string|null
   */
  private $lastname;


  /**
   * @ORM\Column(type="string", length=30)
   * @Assert\NotBlank()
   * @Assert\Regex(
   * pattern="/^[0-9]{10}$/",
   * htmlPattern="/^[0-9]{10}$/"
   * )
   * @var string|null
   */
  private $phone;

  /**
   * @ORM\Column(type="string",  length=255)
   * @Assert\NotBlank()
   * @Assert\Email
   * @var string|null
   */
  private $email;
 
  /**
   * @ORM\Column(type="string",  length=255)
   * @Assert\NotBlank()
   */
   private $subject;
  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   * @Assert\Length(min=10)
   * @var string|null
   */
  private $message;

  /**
   * @ORM\column(type="datetime", nullable=true)
   */
  private $dateMessage;
 
   /**
   * @ORM\column(type="boolean")
   */
  private $messageLu;
 
  /**
   * @ORM\Column(type="boolean")
   */
  private $response;

  public function __construct(){
    $this->dateMessage = new \DateTime();
    $this->messageLu = false;
    $this->response = false;
  }
  /**
   * Get the value of firstname
   *
   * @return  string|null
   */
  public function getFirstname()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   *
   * @param  string|null  $firstname
   *
   * @return  self
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get the value of lastname
   *
   * @return  string|null
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @param  string|null  $lastname
   *
   * @return  self
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get )
   *
   * @return  string|null
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Set )
   *
   * @param  string|null $phone
   *
   * @return  self
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;

    return $this;
  }

  /**
   * Get the value of email
   *
   * @return  string|null
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @param  string|null  $email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of message
   *
   * @return  string|null
   */
  public function getMessage()
  {
    return $this->message;
  }

  /**
   * Set the value of message
   *
   * @param  string|null  $message
   *
   * @return  self
   */
  public function setMessage($message)
  {
    $this->message = $message;

    return $this;
  }

  /**
   * Get the value of subject
   */
  public function getSubject()
  {
    return $this->subject;
  }

  /**
   * Set the value of subject
   *
   * @return  self
   */
  public function setSubject($subject)
  {
    $this->subject = $subject;

    return $this;
  }

  public function getId(): ?int
  {
      return $this->id;
  }

  public function getDateMessage(): ?\DateTimeInterface
  {
      return $this->dateMessage;
  }

  public function setDateMessage(?\DateTimeInterface $dateMessage): self
  {
      $this->dateMessage = $dateMessage;

      return $this;
  }

  public function getMessageLu(): ?bool
  {
      return $this->messageLu;
  }

  public function setMessageLu(bool $messageLu): self
  {
      $this->messageLu = $messageLu;

      return $this;
  }

  public function getResponse(): ?bool
  {
      return $this->response;
  }

  public function setResponse(bool $response): self
  {
      $this->response = $response;

      return $this;
  }

  

    /**
     * Get the value of gender
     */ 
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }
}
