<?php

namespace  App\Controller\Admin;

use App\Repository\BijouRepository;
use App\Repository\CommandesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{  
    private $bijouRepository;
    private $commandesRepository;
    public function __construct(BijouRepository $bijouRepository, CommandesRepository $commandesRepository)
    {
           $this->bijouRepository = $bijouRepository;
           $this->commandesRepository = $commandesRepository;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {    
       
        return $this->render('admin/dashboard.html.twig', [
            'bijouCount' => $this->bijouRepository->getBijousCount(),
            'publishedBijouCount' => $this->bijouRepository->getPublishedBijouCount(),
            'randomBijou' => $this->bijouRepository->findRandomBijou(),
            'commandesCount' => $this->commandesRepository->getCommandesCount()
        ]);
    }
}
