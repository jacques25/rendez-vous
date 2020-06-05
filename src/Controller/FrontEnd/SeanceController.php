<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\OptionSeanceService;
use App\Repository\SeanceRepository;
use App\Repository\SeanceOptionRepository;
use App\Repository\CommentRepository;
use App\Form\CommentType;

use App\Entity\Comment;


class SeanceController extends AbstractController
{

  /**
   * @Route("/seance/{slug}", name="seance_show")
   *  
   */
  public function show(Request $request, $slug, SeanceRepository $repo, CommentRepository $commentRepository, OptionSeanceService $optionSeanceService, SerializerInterface $serializer)
  { 
   $user = $this->getUser();
    $seance = $repo->findOneBy(['slug' => $slug]);
    $comment = new Comment();
    $form =  $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);
    $comments = $commentRepository-> getCommentsForSeance($seance->getId());
    $options =  $optionSeanceService->findBy($seance);
     
                
         if ($form->isSubmitted() and  $form->isValid()) {
             $author = $user->getFirstName();
             $em = $this->getDoctrine()->getManager();
             $comment->setSeance($seance);
             $comment->setAuthorName($author);
             $em->persist($comment);
             $em->flush();
                       
             return $this->redirectToRoute('seance_show', ['slug' => $seance->getSlug() ]);
         
     }
    return $this->render('seances/show.html.twig', [
      'seance' => $seance,
      'options' => $options,
     'comments' => $comments,
     'comment' => $comment,
     'form' => $form->createView()
    ]);
  }
   
}
