<?php

namespace App\Controller\FrontEnd;

use App\Entity\Bijou;
use App\Data\SearchData;
use App\Entity\BijouContact;
use App\Form\SearchFormType;
use App\Repository\BijouRepository;
use App\Service\OptionBijouService;
use App\Form\Contact\BijouContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/boutique/bijou")
 */
class BijouController extends AbstractController
{



    /**
     * @Route("/{id}", name="bijou_show")
     * @param Bijou $bijou
     * @return JsonResponse
     */


    public function show(BijouRepository $repo, Request $request, $id, OptionBijouService $options, SerializerInterface $serializer)
    {


        $bijou = $repo->findOneBy(['id' => $id]);

        /*  $optionBijou = $options->findBy($bijou); */
        $optionBijous = $options->findBy($bijou);
        $options = $serializer->serialize($optionBijous, 'json', ['attributes' => ['id', 'taille', 'reference', 'dimensions', 'disponible', 'prix', 'bijou_id']]);


        return $this->render('bijou/show.html.twig', [

            'bijou' => $bijou,
            'current_menu' => 'bijou',
            'options' => $options,
        ]);
    }
}
