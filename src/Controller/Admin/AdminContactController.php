<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\ContactRepository;
use App\Form\Contact\ResponseType;
use App\Entity\Response;
use App\Entity\Contact;
use Knp\Component\Pager\PaginatorInterface;

/**
 *  @Route("/admin")
 */

class AdminContactController extends AbstractController
{
     private $contactRepository;
     public function __construct(ContactRepository $contactRepository)
     {
          $this->contactRepository = $contactRepository;
     }
    /**
     * @Route("/liste/messages", name="admin_contact_index")
     */
    public function index( Request $request, PaginatorInterface $paginatorInterface )
    {  

        $contacts = $paginatorInterface->paginate(
                   $this->contactRepository->findAll(),
                    $request->query->getInt('page' ,  1),
                    6
      );
      
        return $this->render('admin/contact/index.html.twig', [
             'contacts' => $contacts
        ]);
    }
    
    /**
     * @Route("/voir/message/{id}" ,  name="admin_contact_show")
     *
     * @return void
     */
    public function show($id) {
             $contact = $this->contactRepository->find($id);

             return $this->render('admin/contact/show.html.twig',  [
                 'contact' => $contact
             ]);
    }

    public function navContact()
    {      
           $messageCount = $this->contactRepository->getContactsCount();
           
            $contacts = $this->contactRepository
            ->findLastMessages(
                array(),  
            );
           
        return $this->render('admin/contact/nav-contact.html.twig',[
                'contacts' => $contacts, 
                'messageCount' => $messageCount
              ]);
    }

    /**
     *  @Route("/message/reponse/{id}",  name="admin_contact_response")
     */

     public function response( $id, Request $request,  MailerInterface $mailer)
     { 
         
        $response = new Response();
        $form = $this->createForm(ResponseType::class, $response);
        $form->handleRequest($request);

        $contact = $this->contactRepository->find($id);
        
        
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
        ->htmlTemplate('email/email-response.html.twig')
        ->context([
                    'subject' => $subject,
                    'username' => $username,
                    'userMail' => $userMail,
                    'messageMail' => $messageMail
                ]);

      $mailer->send($mail);

         $manager = $this->getDoctrine()->getManager();
          $contact->setMessageLu(true);
          $contact->setResponse(true);
         $manager->persist($contact);
         $manager->flush();
     
        return $this->redirectToRoute('admin_contact_index');
       }

         return $this->render('admin/contact/response.html.twig' , [
             'form' => $form->createView(),
             'contact' => $contact,
             'response' => $response
         ]);
     }
  
     /**
    * @Route("/delete/message/{id}", name="admin_contact_delete")
    */
    public function  messageDelete(Request $request, Contact $contact) 
    {
                 if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_contact_index');
    }
}
