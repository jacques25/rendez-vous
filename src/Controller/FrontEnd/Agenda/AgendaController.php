<?php

namespace App\Controller\FrontEnd\Agenda;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgendaController  extends AbstractController
{     
      /**
       * @Route("/agenda", name="agenda")
       *
       * @return void
       */
       public function Agenda()
        {
         return $this->render('agenda/agenda.html.twig');
       }
}
