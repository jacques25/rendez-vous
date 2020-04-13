<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact 
{
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

  private $subject;

  /**
   * 
   * @Assert\NotBlank()
   * @Assert\Regex(
   * pattern="/^[0-9]{10}$/",
   * htmlPattern="/^[0-9]{10}$/"
   * )
   * @var string|null
   */
  private $phone;

  /**
   * 
   * @Assert\NotBlank()
   * @Assert\Email
   * @var string|null
   */
  private $email;

  /**
   * 
   * @Assert\NotBlank()
   * @Assert\Length(min=10)
   * @var string|null
   */
  private $message;

 
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
}
