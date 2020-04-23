<?php

namespace App\Entity;

class Recherche
{      
       /**
        *
        * @var int|null
        */
         private $reference;
         
         /**
          * @var int|null
          */
         private $prix; 
         
        /**
         *  @var string|null
         */
         private $title;

         /**
          * Get the value of reference
          *
          * @return  string|null
          */ 
         public function getReference(): ?string
         {
                  return $this->reference;
         }

         /**
          * Set the value of reference
          *
          * @param  int|null  $reference
          *
          * @return  self
          */ 
         public function setReference(string $reference): Recherche
         {
                  $this->reference = $reference;

                  return $this;
         }

         /**
          * Get the value of prix
          *
          * @return  int|null
          */ 
         public function getPrix(): ?int
         {
                  return $this->prix;
         }

         /**
          * Set the value of prix
          *
          * @param  int|null  $prix
          *
          * @return  self
          */ 
         public function setPrix(int $prix): Recherche
         {
                  $this->prix = $prix;

                  return $this;
         }

         /**
          * Get the value of title
          *
          * @return  string|null
          */ 
         public function getTitle()
         {
                  return $this->title;
         }

         /**
          * Set the value of title
          *
          * @param  string|null  $title
          *
          * @return  self
          */ 
         public function setTitle($title)
         {
                  $this->title = $title;

                  return $this;
         }
}
