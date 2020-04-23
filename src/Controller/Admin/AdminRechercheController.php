<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Bijou;

/**
 * @Route("/admin")
 */
class AdminRechercheController extends AbstractController
{
     /**
     *
     * @Route("/recherche", name="admin_recherche")
     */
    public function recherche(Request $request, PaginatorInterface $paginatorInterface)
    {

        $motcle = $request->get('motcle');
     
        $em = $this->getDoctrine()->getManager();
         
        $listeBijoux = $em->getRepository(Bijou::class)->findBijousByTitle($motcle);


        if ($request->isMethod('GET')) {
                $bijous = $paginatorInterface->paginate(
                $listeBijoux,
                $request->query->getInt('page', 1),
                8
            );
        }


        return $this->render('admin/recherche/recherche_bijou.html.twig', [
            'bijous' => $bijous,
            'motcle' => $motcle
        ]);
    }
}

