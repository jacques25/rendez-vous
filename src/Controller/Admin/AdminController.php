<?php

namespace  App\Controller\Admin;

use App\Repository\BijouRepository;
use App\Repository\BookingRepository;
use App\Repository\CommandesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{  
    private $bijouRepository;
    private $commandesRepository;
    private $bookingRepository;
    public function __construct(BijouRepository $bijouRepository, CommandesRepository $commandesRepository, BookingRepository $bookingRepository)
    {
           $this->bijouRepository = $bijouRepository;
           $this->commandesRepository = $commandesRepository;
           $this->bookingRepository = $bookingRepository;
         
    }
    /**
     * @Route("/admin", name="admin")
     *  
     */
    public function admin()
    {    
         if (!$this->isGranted('ROLE_ADMIN')) { 
              $this->addFlash('danger' , 'Seul les administrateurs ont accés au back office du site');
              return $this->redirectToRoute('account_login');
         }
        return $this->render('admin/dashboard.html.twig', [
            'bijouCount' => $this->bijouRepository->getBijousCount(),
            'publishedBijouCount' => $this->bijouRepository->getPublishedBijouCount(),
            'randomBijou' => $this->bijouRepository->findRandomBijou(),
            'commandesCount' => $this->commandesRepository->getCommandesCount(),
            'bookingsCount' => $this->bookingRepository->getBookingsCount()
        ]);
    }
}
