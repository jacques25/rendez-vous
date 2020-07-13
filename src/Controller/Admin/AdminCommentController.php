<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Repository\CommentRepository;
use App\Form\Contact\ResponseType;
use App\Form\AdminCommentType;
use App\Entity\Response;
use App\Entity\Comment;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;

/**
  * @Route("/admin")
  */
class AdminCommentController extends AbstractController
{    

    
    private $commentRepository;
    public function __construct(CommentRepository $commentRepository){
        $this->commentRepository = $commentRepository;
    }
    /**
     * @Route("/liste/commentaires", name="admin_comments_list")
     */
    public function index(Request $request, PaginatorInterface $paginatorInterface)
    {    
     
       $comments = $paginatorInterface->paginate(
           $this->commentRepository->findByPublication(),
           $request->query->getInt('page', 1),
           6
       );   
        
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

     /**
      * @Route("/commentaire/{id}/edit", name="admin_comment_edit", methods={"GET", "POST"})
      *
      * @param [type] $id
      * @param Request $request
      * @param Comment $comment
      */
  public function edit(Request $request,Comment $comment)
  {
         
        $form = $this->createForm(AdminCommentType::class, $comment);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
              $em=  $this->getDoctrine()->getManager();

               $em->persist($comment);
               $em ->flush();

            return $this->redirectToRoute('admin_comments_list');
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
           
        ]);
  }
   /**
     * @Route("/voir/commentaire/message/{id}" ,  name="admin_comment_show")
     *
     * @return void
     */
    public function show($id) {
             $comment = $this->commentRepository->find($id);

             return $this->render('admin/comment/show.html.twig',  [
                 'comment' => $comment
             ]);
    }

  /**
     * @Route("/comment/{id}", name="admin_comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment)
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_comments_list');
    }
    
    /**
     * @Route("/comment/response/{id}", name="admin_comment_response")
     *
     * @param [type] $id
     * @param Comment $comment
     * @param Request $request
     * @param MailerInterface $mailer
     * @return void
     */
    public function ResponseComment( $id,Comment $comment, Request $request, 
     MailerInterface $mailer ) 
    {
               $response = new Response();
               $form = $this->createForm(ResponseType::class, $response);
               $form->handleRequest($request);
           
             
                 
       if($request->isMethod('POST')) {
          $lastname = $form['lastname']->getData();
          $firstname= $form['firstname']->getData();
          $username = $firstname . " " .$lastname;
          $userMail = $form['email']->getData();
          $subject =  $form['subject']->getData();
          $messageMail =  $form['message']->getData();
          
        $mail = (new TemplatedEmail())
        ->from('admin@rvas.fr')
        ->to($userMail)
        ->subject($subject)
        ->htmlTemplate('email/email-comment-response.html.twig')
        ->context([
                    'subject' => $subject,
                    'username' => $username,
                    'userMail' => $userMail,
                    'messageMail' => $messageMail
                ]);

      $mailer->send($mail);

         $manager = $this->getDoctrine()->getManager();
          $comment->setCommentLu(true);
        
         $manager->persist($comment);
         $manager->flush();
     
        return $this->redirectToRoute('admin_comments_list');
       }

         return $this->render('admin/comment/response.html.twig' , [
             'form' => $form->createView(),
             'comment' => $comment,
             'response' => $response
         ]);

               
    }

     public function navComment()
    {      
           $messageCount = $this->commentRepository->getCommentsCount();
           
            $comments = $this->commentRepository
            ->findLastMessagesComment(
                array(),  
            );
           
        return $this->render('admin/comment/nav-comment.html.twig',[
                'comments' => $comments, 
                'messageCount' => $messageCount
              ]);
    }
}
