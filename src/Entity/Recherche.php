<?php

namespace App\Entity;

class Recherche
{      
       /**
        *
        * @var string|null
        */
         private $reference;
         
         /**
          * @var string|null
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
          * @param  string|null  $reference
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
          * @return  string|null
          */ 
         public function getPrix(): ?string
         {
                  return $this->prix;
         }

         /**
          * Set the value of prix
          *
          * @param  string|null  $prix
          *
          * @return  self
          */ 
         public function setPrix(string $prix): Recherche
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
