<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ReductionExtension   extends AbstractExtension
{
        public function getFilters()
        {
                   return [
                     new TwigFilter('reduction' , [$this, 'calculReduction']),
                   ];

        }

        public function calculReduction($prix, $reduction)
        {
          return round(($prix/$reduction) , 1);
        }
}
