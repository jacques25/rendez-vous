<?php
namespace App\Controller\FrontEnd;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Bijou;

/**
 * Description of RechercheController
 *
 * @author jacques
 */
class RechercheController extends AbstractController
{

    /**
     *
     * @Route("/recherche", name="recherche")
     */
    public function recherche(Request $request, PaginatorInterface $paginatorInterface)
    {

        $motcle = $request->get('motcle');

        $em = $this->getDoctrine()->getManager();

        $listeBijoux = $em->getRepository(Bijou::class)->findBijousByTitle($motcle);


        if ($request->isMethod('GET')) {
                $bijous = $paginatorInterface->paginate(
                $listeBijoux,
                $request->query->get('page', 1),
                8
            );
        }


        return $this->render('recherche/recherche_bijou.html.twig', [
            'bijous' => $bijous,
            'motcle' => $motcle
        ]);
    }
}

