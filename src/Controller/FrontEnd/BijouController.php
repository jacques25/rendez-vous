<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PromoService;
use App\Service\OptionBijouService;
use App\Repository\OptionBijouRepository;
use App\Repository\BijouRepository;
use App\Form\SearchFormType;
use App\Form\Contact\BijouContactType;
use App\Entity\OptionBijou;
use App\Entity\BijouContact;
use App\Entity\Bijou;
use App\Data\SearchData;
use App\Repository\PromoRepository;

/**
 * @Route("/boutique/bijou")
 */
class BijouController extends AbstractController
{



    /**
     * @Route("/{slug}", name="bijou_show")
     * @param Bijou $bijou
     * @return JsonResponse
     */


    public function show(BijouRepository $repo, OptionBijouRepository $optionBijouRepository, Request $request, $slug, OptionBijouService $options, SerializerInterface $serializer)
    {
        
     
        $bijou = $repo->findOneBy(['slug' => $slug]);
        $optionBijous = $options->findBy($bijou);
   
           $options = $serializer->serialize($optionBijous, 'json', ['attributes' => ['id', 'taille', 'reference', 'dimensions', 'disponible', 'prix']]);
           
          $promo = $serializer->serialize($bijou,  'json', ['attributes' => ['dateStart' , 'dateEnd', 'promoIsActive', 'multiplicate', 'port']]);
         
        return $this->render('bijou/show.html.twig', [

            'bijou' => $bijou,
            'current_menu' => 'bijou',
            'options' => $options,
            'promo' => $promo,
            
        ]);
    }
}
