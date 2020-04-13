<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
/**
 * @Route("/admin")
 */
class AdminUserController extends AbstractController
{
    
    /**
     * @Route("/users" , name="admin_users_index")
     */
    public  function index(UserRepository $userRepository) {

         $users = $userRepository->findAll();
       
         return $this->render('admin/users/index.html.twig', ['users' => $users]);
    }


     /**
     * @Route("/user/edit/{id}" , name="admin_user_edit")
     */
    public function edit($id , UserRepository $userRepository) {

         $user = $userRepository->findOneBy(['id' => $id]);
       
         return $this->render('admin/users/edit.html.twig', ['user' => $user]);
    }
}
