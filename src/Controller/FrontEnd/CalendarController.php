<?php

namespace App\Controller\FrontEnd;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
       public function loadAction(Request $request): Response
    {
        $startDate = new \DateTime($request->get('beginAt'));
        $endDate = new \DateTime($request->get('endAt'));
        $filters = $request->get('filters', []);

        try {
            $content = $this
                ->get('fullcalendar.service.calendar')
                ->getData($startDate, $endDate, $filters);
            $status = empty($content)
                ? Response::HTTP_NO_CONTENT
                : Response::HTTP_OK
            ;
        } catch (\Exception $exception) {
            $content = json_encode(['error' => $exception->getMessage()]);
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($content);
        $response->setStatusCode($status);

        return $response;
    }
}
