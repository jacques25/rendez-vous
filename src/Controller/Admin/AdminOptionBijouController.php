<?php

namespace App\Controller\Admin;

use App\Entity\OptionBijou;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminOptionBijouController extends AbstractController
{
  /**
   * @Route("/{id}", name="admin_option_bijou_delete",  methods="DELETE")
   * 
   */

  public function delete(OptionBijou $option, Request $request)
  {
    $data = json_decode($request->getContent(), true);
    if ($this->isCsrfTokenValid('delete' . $option->getId(), $data['_token'])) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($option);
      $em->flush();

      return new JsonResponse(['success' => 1]);
    }

    return new JsonResponse(['error' => 'Token invalide'], 400);
  }
}