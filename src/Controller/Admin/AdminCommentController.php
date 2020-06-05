<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CommentRepository;

use App\Form\AdminCommentType;
use App\Entity\Comment;

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
    public function index()
    {    
          $comments = $this->commentRepository->findAll();
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
      * @return Response
      */
  public function edit(Request $request,Comment $comment): Response
  {
        
        $form = $this->createForm(AdminCommentType::class, $comment);
        $form->handleRequest($request);
         $approved = $comment->getApproved();
         
        if ($form->isSubmitted() && $form->isValid()) {
            //get rid of the ones that bijou got rid of in the interface(DOM)
              $em=  $this->getDoctrine()->getManager();
              if($approved == true) {
                  $comment->setApproved(true) ;
              }else{
                  $comment->setApproved(false);
              }
              
               $em ->flush();

            return $this->redirectToRoute('admin_comments_list');
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,

            'form' => $form->createView(),
           
        ]);
  }
}
