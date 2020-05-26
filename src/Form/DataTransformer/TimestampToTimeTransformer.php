<?php

namespace App\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;


class TimestampToTimeTransformer implements DataTransformerInterface
{
       /**
        * @param \DateTime $datetime
        */
        public function transform($time)
        {  
            if($time === null ){
                return $time;
            }
            return \strtotime($time);
        }
        public function reverseTransform($time) {
               return  strtotime($time);
         
        }
}
