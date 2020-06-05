<?php

namespace App\Controller\FrontEnd;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\SeanceRepository;
use App\Form\CommentType;
use App\Entity\Seance;
use App\Entity\Comment;

class CommentController  extends AbstractController
{
       /**
        * @Route("comment/{seance_id}", name="seance_comment")
        * @Security("is_granted('ROLE_USER_SEANCE')", message="Vous devez être connecté pour écrire un commentaire.")
        */

        public function new( Request $request, $seance_id) {
                 $seance = $this->getSeance($seance_id );
                 $comment = new Comment();
                 $author = $this->getUser()->getUsername();  
                 
                  $form = $this->createForm(CommentType::class, $comment);
                 $form->handleRequest($request);
                     
                 if($form->isSubmitted() and  $form->isValid()) {
                      dd($form);
                      $em = $this->getDoctrine()->getManager();
                      $comment->setSeance($seance);
                      $comment->setAuthorName($author);
                      $em->persist($comment);
                      $em->flush();
                       
                      return $this->redirectToRoute('seance_show', ['slug' => $seance->getSlug() ]);
                 }
                 return $this->render('comment/seance_comment.html.twig', [
                   'comment' => $comment,
                   'form' => $form->createView(),
                   
                 ]);
        }


        protected function getSeance($seance_id){
                $em = $this->getDoctrine()->getManager();
                 $seance = $em->getRepository(Seance::class)->find($seance_id);
                  if (!$seance){
                       throw $this->createNotFoundException('Aucun résultat');
                  }

                  return  $seance;
        }

     
         /**
        * @Route("comment/{formation_id}", name="formation_comment")
         * @Security("is_granted('ROLE_FORMATION')", message="Vous devez être connecté pour écrire un commentaire.")
        */

        public function addCommentFormation( Request $request, $formation_id) {
                 $formation = $this->getFormation($formation_id );
                 
                 $em = $this->getDoctrine()->getManager();
                 $comment = new Comment();
                 
                  $user = $this->getUser();                 
                  $form = $this->createForm(CommentType::class, $comment);
                 $form->handleRequest($request);
                 if($form->isSubmitted() and  $form->isValid()) {
                      $comment->setFormation($formation);
                      $comment->setAuthorName($user->getUsername());
                      $em->persist($comment);
                      $em->flush();

                      return $this->redirectToRoute('formation_show', ['slug' => $formation->getSlug() ]);
                 }
                 return $this->render('comment/_form.html.twig', [
                   'comment' => $comment,
                   'author' => $author,
                   'form' => $form->createView(),
                   'formation' => $formation
                 ]);
        }
          protected function getFormation($formation_id){
                $em = $this->getDoctrine()->getManager();
                 $formation = $em->getRepository(Seance::class)->find($formation_id);
                  if (!$formation){
                       throw $this->createNotFoundException('Aucun résultat');
                  }

                  return  $formation;
        }
}
