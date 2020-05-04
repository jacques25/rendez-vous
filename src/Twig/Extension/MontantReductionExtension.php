<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MontantReductionExtension extends  AbstractExtension
{
      public function getFilters()
      {
                return [
                       new TwigFilter('montantReduction', array($this, 'montantReduction')),
                ];
      }

      public function montantReduction($prix,  $reduction) 
      {
            return round ((($prix / $reduction) - $prix), 1);

      }
   /*    
       public function getName()
    {
        return 'montant_reduction_extension';
    } */
      
}
