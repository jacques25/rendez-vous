<?php

namespace App\Service\Panier;

use App\Entity\OptionBijou;
use App\Repository\BijouRepository;
use App\Repository\OptionBijouRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{

  protected $bijouRepository;

  public function __construct(BijouRepository $bijouRepository, OptionBijouRepository $optionBijouRepository, SerializerInterface $serializer, SessionInterface $session)
  {

    $this->bijouRepository = $bijouRepository;
    $this->optionBijouRepository = $optionBijouRepository;
    $this->serializer = $serializer;
    $this->session = $session;
  }

  public function add(int $id)
  {

    $panier = $this->session->get('panier', []);
    $reference = $this->session->get('reference', []);




    if (!empty($panier[$id])) {
      $panier[$id]++;
      $reference[$id] = $this->session->get('reference');
      dd($reference);
    } else {
      $panier[$id] = 1;
      $reference[$id] = $this->session->get('reference');
    }

    $this->session->set('panier', $panier);
    $this->session->set('reference', $reference);
  }

  public function remove(int $id)
  {

    $panier = $this->session->get('panier', []);

    if (!empty($panier[$id])) {
      unset($panier[$id]);
    }

    $this->session->set('panier', $panier);
  }

  public function getFullPanier(): array
  {

    if (!$this->session->has('reference')) $this->session->get('reference', []);
    dd($this->session->get('reference'));


    $panier = $this->session->get('panier', []);
    $reference = $this->session->get('reference', []);
    $panierwidthData = [];

    foreach ($panier as $id => $qte) {
      $bijou = $this->bijouRepository->find($id);
      if ($bijou) {
        [
          'bijou' => $bijou,
          'qte' => $qte,
          'reference' => $reference
        ];
      }

      return $panierwidthData;
    }
  }

  public function getTotal(): float
  {

    $total = 0;


    foreach ($this->getFullPanier() as $item) {

      $total += $item['bijou']->getId() * $item['quantity'];
    }
    return $total;
  }
}