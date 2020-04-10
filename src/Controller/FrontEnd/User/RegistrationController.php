<?php

namespace App\Controller\FrontEnd\User;

use App\Entity\User;

use Symfony\Component\Mime\Email;

use App\Form\FormAccount\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{



  /**

   * @Route("/inscription", name="account_register")
   * @param AuthenticationUtils $authenticationUtils
   * @param Request $request
   * @param UserPasswordEncoderInterface $passwordEncoder
   * @return Response
   * @throws \Exception
   * @return Response
   */
  public function register(
    Request $request,
    AuthenticationUtils $authenticationUtils,
    UserPasswordEncoderInterface $encoder,
    TokenGeneratorInterface $tokenGenerator,
    MailerInterface $mailer
  ): Response {
    $user = $authenticationUtils->getLastUsername();
    $user = new User();
    $form = $this->createForm(RegistrationType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $token = $tokenGenerator->generateToken();
      $slugger = new AsciiSlugger();
      $user->setSlug($slugger->slug(strtolower($user->getFirstName() . ' ' . $user->getLastName())));
      $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
      $user->setConfirmToken($token);
      $user->setRoles(["ROLE_USER"]);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($user);
      $entityManager->flush();

      $token = $user->getConfirmToken($token);
      $email = $user->getEmail();
      $username = $user->getLastName();
      $url = $this->generateUrl('confirm_account', array('email' => $email, 'token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
      $mail = (new Email())
        ->from('admin@rvas.fr')
        ->to($email)
        ->subject("Lien de vérification d'inscription")
        ->text(
          ' Bonjour ' . $username .
            ' Voici le lien pour confirmer votre inscription: <a href="' . $url . ' "> ' . $url . '</a>',
          'text/html'
        );

      $mailer->send($mail);

      $this->addFlash('success', 'Votre compte a bien été crée, un lien vous a été envoyé pour activé votre compte dans votre boite mail');
      return $this->redirectToRoute('account_login');
    }
    return $this->render('account/registration.html.twig', [
      'form' => $form->createView(),

    ]);
  }

  /**
   * @Route("activation-de-compte/{token}/{email}", name="confirm_account")
   * confirmAccount
   * @param   $token
   * @param   $email
   * 
   */
  public function confirmAccount($token, $email, AuthenticationUtils $authenticationUtils)
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
    $error = $authenticationUtils->getLastAuthenticationError();
    $last_username = $user->getUsername();
    $tokenExist = $user->getConfirmToken();
    if ($token === $tokenExist) {
      $user->setConfirmToken(null);
      $user->setEnabled(true);
      $em->persist($user);
      $em->flush();
      $this->addFlash('success', "Votre compte est activé");
      return $this->render('account/login.html.twig', ['error' => $error, 'last_username' => $last_username]);
    } else {

      $this->addFlash('success', "Votre compte est déjà activé");
      return $this->render('account/login.html.twig', ['error' => $error, 'last_username' => $last_username]);
    }
  }
}
