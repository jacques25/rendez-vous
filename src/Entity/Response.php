<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;



class Response 
{                        
     /**
      * @Assert\NotBlank()
   * @Assert\Length(max=20)
   * @var string|null
      */

      private $gender;
     /**
   * @Assert\NotBlank()
   * @Assert\Length(min=2, max=100)
   * @var string|null
   */
  private $firstname;

  /**
   * @Assert\NotBlank()
   * @Assert\Length(min=2, max=100)
   * @var string|null
   */
  private $lastname;



  /**
   * @Assert\NotBlank()
   * @Assert\Email
   * @var string|null
   */
  private $email;

  /**
   * @Assert\NotBlank()
   * @Assert\Length(min=10)
   * @var string|null
   */
  private $message;

  
  private $subject;
  private $dateMessage;

  
 public function  __construct()
 {
   $this->dateMessage = new \DateTime();
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
   * Get the value of dateMessage
   */ 
  public function getDateMessage()
  {
    return $this->dateMessage;
  }

  /**
   * Set the value of dateMessage
   *
   * @return  self
   */ 
  public function setDateMessage($dateMessage)
  {
    $this->dateMessage = $dateMessage;

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
