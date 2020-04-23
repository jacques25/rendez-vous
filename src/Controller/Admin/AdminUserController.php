<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\UserRepository;
 
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
}
