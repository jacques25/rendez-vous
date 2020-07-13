<?php

namespace App\Controller\FrontEnd;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\UserAdress;
use App\Form\UserAdressType;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Form\FormAccount\ProfileType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class AccountController extends AbstractController
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    /**
     * @Route("/connexion", name="account_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_homepage');
        }
      

        $error = $authenticationUtils->getLastAuthenticationError();
         
         
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        if ($error) {
            $this->addFlash('danger', 'un problème est survenue veuillez recommencer.');
            $this->redirectToRoute('account_login');
        }

        return $this->render('account/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
         
        ]);
    }

    /**
     * @Route("/deconnexion", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {
    }




    /**
     * @Route("/mon-compte/profil", name="account_profile")
     *
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function profile(Request $request, TokenGeneratorInterface $tokenGenerator, LoggerInterface $logger)
    {
        $manager = $this->getDoctrine()->getManager();
        $logger->debug('Vous êtes connecté en tant que ' . $this->getUser()->getUsername());
        $user = $this->getUser();

        $originalAddress = new ArrayCollection();
        
        foreach ($user->getAddresses() as $address) {
            $originalAddress->add($address);
        }

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return  $this->redirectToRoute('account_login');
            $this->addFlash('danger', " Vous n' êtes pas connecté !");
        } elseif ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $form = $this->createForm(ProfileType::class, $user);
            $form->handleRequest($request);
            $token = $tokenGenerator->generateToken();

            if ($form->isSubmitted() && $form->isValid()) {
                foreach ($originalAddress as $address) {
                    if ($user->getAddresses()->contains($address) === false) {
                        // remove the Task from the Tag
                        $manager->remove($address);
                    }
                }


                $slugger = new AsciiSlugger();
                $user->setSlug($slugger->slug(strtolower($user->getFirstName() . ' ' . $user->getLastName())));
                $user->setUpdatedAt(new \DateTime());

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Votre profil a bien été modifié');
                $this->redirectToRoute('account_profile');
            }

            return $this->render('account/profile.html.twig', [
                'form' => $form->createView(),
                'user' => $user,
                'token' => $token,
                'logger' => $logger,
                'commandes' => $user->getCommandes()
            ]);
        }
        return $this->redirectToRoute('accueil');
    }


    /**
     *
     * @Route("/profil/utilisateur/adresse", name="profile_user_address")
     */
    public function adresse(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $userAddress = new UserAdress();

        $form = $this->createForm(UserAdressType::class, $userAddress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $userAddress->setUser($user);
            $em->persist($userAddress);
            $em->flush();

            $this->addFlash('notice', "L'adresse a bien été ajouter");
            return $this->redirectToRoute('account_profile', ['user' => $user->getId()]);
        }

        return $this->render('user/adresse.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }


    /**
     * @Route("/mot-de-passe-oublie", name="app_forget_password")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Response $response
     * @return void
     */
    public function forgotPassword(
        UserRepository $userRepository,
        Request $request,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $manager = $this->getDoctrine()->getManager();

            $user = $userRepository->findOneByEmail($email);

            if ($user === null) {
                $this->addFlash('danger', "Cet email n'est pas connu de nos services");
                return $this->redirectToRoute('account_login');
            }
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('account_login');
            }
            $username = $user->getFirstName();
            $url = $this->generateUrl('app_reset_password', array('token' => $token, 'username' => $username), UrlGeneratorInterface::ABSOLUTE_URL);

            $email = (new TemplatedEmail())
                ->from('admin@rvas.fr')
                ->To($user->getEmail())
                ->subject('Réinitialiser votre mot de passe')
                ->htmlTemplate('email/forget_password.html.twig')
                ->context([
                    'username' => $username,
                    'url' => $url
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Un lien vient de vous être envoyé dans votre boite mail afin de réinitialiser votre mot de passe');

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/forget_password.html.twig');
    }

    /**
     * @Route("/reinitialiser-mot-de-passe/{token}", name="app_reset_password")
     */

    public function resetPassword(
        UserRepository $userRepository,
        Request $request,
        string $token,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        if ($request->isMethod('POST')) {
            $manager = $this->getDoctrine()->getManager();
 
            $user = $userRepository->findOneByResetToken($token);
             
            if ($user === null) {
                $this->addFlash('danger', "Token inconnu");
                return $this->redirectToRoute("app_forget_password");
            }

            $user->setResetToken(null);
             $password = $request->get('password');
            $passwordConfirm = $request->get('passwordConfirm');
            

            if ($password !== $passwordConfirm) {
                $this->addFlash('warning', 'Les mots de passe ne sont pas identiques');
            } else {
                $password =  $passwordEncoder->encodePassword($user, $request->get('password'));
                $user->setPassword($password);
                $manager->flush();
                $this->addFlash('success', 'Réinitialiation de votre mot de passe réussie !');

                return $this->redirectToRoute('account_login');
            }
        }

        return $this->render('account/reset_password.html.twig', ['token' => $token]);
    }
}
