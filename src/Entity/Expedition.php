<?php

namespace App\Entity;

class Expedition
{
      /**
       *  @var datetime
       */

       private $dateExpedition;
        
       private $numeroCommande;

       private $message;

       private $email;
       
       private $gender;
       
       private $firstname;
       private $lastname;

       private $subject;

       private $street;

       private $cp;
       private $city;

       /**
        * Get the value of dateExpedition
        */ 
       public function getDateExpedition()
       {
              return $this->dateExpedition;
       }

       /**
        * Set the value of dateExpedition
        *
        * @return  self
        */ 
       public function setDateExpedition($dateExpedition)
       {
              $this->dateExpedition = $dateExpedition;

              return $this;
       }

       /**
        * Get the value of message
        */ 
       public function getMessage()
       {
              return $this->message;
       }

       /**
        * Set the value of message
        *
        * @return  self
        */ 
       public function setMessage($message)
       {
              $this->message = $message;

              return $this;
       }

       /**
        * Get the value of email
        */ 
       public function getEmail()
       {
              return $this->email;
       }

       /**
        * Set the value of email
        *
        * @return  self
        */ 
       public function setEmail($email)
       {
              $this->email = $email;

              return $this;
       }

       /**
        * Get the value of firstname
        */ 
       public function getFirstname()
       {
              return $this->firstname;
       }

       /**
        * Set the value of firstname
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
        */ 
       public function getLastname()
       {
              return $this->lastname;
       }

       /**
        * Set the value of lastname
        *
        * @return  self
        */ 
       public function setLastname($lastname)
       {
              $this->lastname = $lastname;

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
        * Get the value of numeroCommande
        */ 
       public function getNumeroCommande()
       {
              return $this->numeroCommande;
       }

       /**
        * Set the value of numeroCommande
        *
        * @return  self
        */ 
       public function setNumeroCommande($numeroCommande)
       {
              $this->numeroCommande = $numeroCommande;

              return $this;
       }



       /**
        * Get the value of street
        */ 
       public function getStreet()
       {
              return $this->street;
       }

       /**
        * Set the value of street
        *
        * @return  self
        */ 
       public function setStreet($street)
       {
              $this->street = $street;

              return $this;
       }

       /**
        * Get the value of cp
        */ 
       public function getCp()
       {
              return $this->cp;
       }

       /**
        * Set the value of cp
        *
        * @return  self
        */ 
       public function setCp($cp)
       {
              $this->cp = $cp;

              return $this;
       }

       /**
        * Get the value of city
        */ 
       public function getCity()
       {
              return $this->city;
       }

       /**
        * Set the value of city
        *
        * @return  self
        */ 
       public function setCity($city)
       {
              $this->city = $city;

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
