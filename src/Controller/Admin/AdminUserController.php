<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FormationService;
use App\Repository\UserRepository;
use App\Repository\FormationRepository;
use App\Repository\BookingRepository;
use App\Entity\User;
use App\Entity\Formation;
 
/**
 * @Route("/admin")
 */
class AdminUserController extends AbstractController
{
    
    /**
     * @Route("/users" , name="admin_users_index")
     */
    public  function index(UserRepository $userRepository, PaginatorInterface $paginatorInterface, Request $request) {

            
     $users = $paginatorInterface->paginate(
            $userRepository->findAll(),
           $request->query->getInt('page' ,  1),
                    10
     );
   
         return $this->render('admin/users/index.html.twig', ['users' => $users]);
    }


     /**
     * @Route("/user/edit/{id}" , name="admin_user_edit")
     */
    public function edit($id , UserRepository $userRepository) {

         $user = $userRepository->findOneBy(['id' => $id]);
        
         return $this->render('admin/users/edit.html.twig', ['user' => $user]);
    }

  /**
   * @Route("/inscrits-seance/", name="admin_inscrits_seance")
   *
   * @return void
   */
    public function getBookingByUser(UserRepository $userRepository) {
      
         $users = $userRepository->findAll();

         return $this->render('admin/users/user_seance.html.twig', ['users' => $users]);

    }

    /**
     *  @Route("/inscrits-formation/", name="admin_inscrits_formation") 
     */
    public function getUsersFormation(UserRepository $userRepository){
            $users = $userRepository->findAll();
            foreach($users as $user) {
                   foreach($user->getFormations() as $formation){
                        $formation = $formation;
                      
                   }
                      
            } 
       

            return  $this->render('admin/users/user_formation.html.twig', ['users' => $users, 'formation' => $formation]);
    }
}
