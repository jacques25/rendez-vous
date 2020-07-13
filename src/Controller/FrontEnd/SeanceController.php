<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\OptionSeanceService;
use App\Repository\SeanceRepository;
use App\Repository\SeanceOptionRepository;
use App\Repository\CommentRepository;

use App\Notification\CommentNotification;
use App\Form\CommentType;
use App\Entity\Comment;

class SeanceController extends AbstractController
{

  /**
   * @Route("/seance/{slug}", name="seance_show")
   *  
   */
  public function show(Request $request, $slug, SeanceRepository $repo, CommentRepository $commentRepository, OptionSeanceService $optionSeanceService, CommentNotification $commentNotification )
  { 
    $referer = $request->headers->get('referer');
   $user = $this->getUser();
    $seance = $repo->findOneBy(['slug' => $slug]);
     $ratingsData = $commentRepository ->getRatingCommentBySeance($seance);
   
    $nbComments = $commentRepository->getNumberCommentBySeance($seance);
    
    $averageRatings = $ratingsData['averageRatings'];
    $comment = new Comment();
    $form =  $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);
    $comments = $commentRepository->getCommentsForSeance($seance);
  
    $options =  $optionSeanceService->findBy($seance);
     if($form->isSubmitted() and !$form->isValid())
     {
        $this->addFlash('warning', ' Certains champs ne sont remplis, veuillez recommencer.' );
        return new RedirectResponse($referer);
     }
                
         if ($form->isSubmitted() and  $form->isValid()) {
           
             $em = $this->getDoctrine()->getManager();
             $comment->setSeance($seance);
             $comment->setUser($user);
             $comment->setCommentLu(false);
             $em->persist($comment);
             $em->flush();
                 $commentNotification->notify($comment, $user);
            $this->addFlash('success', ' Merci, ' . $user->getFirstname(). " pour votre commentaire. Votre commentaire sera publié  dès  que nous l 'aurons approuvé");          
             return $this->redirectToRoute('seance_show', ['slug' => $seance->getSlug() ]);
         
     }
    return $this->render('seances/show.html.twig', [
      'seance' => $seance,
      'options' => $options,
     'comments' => $comments,
     'comment' => $comment,
     'form' => $form->createView(),
     'averageRatings' => $averageRatings,
     'nbComments' => $nbComments
    ]);
  }
   
    
}
