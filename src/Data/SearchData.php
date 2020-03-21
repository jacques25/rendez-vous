<?php

namespace App\Data;

class SearchData
{
  /**
   *
   * @var string
   */
  public $q = '';

  /**
   * @var Produit[]
   */

  public $produits = [];

  /** 
   *
   * @var null|string
   */
  public $max;

  /** 
   *
   * @var null|string
   */
  public $min = 0;


  /**
   * @var boolean
   */

  public $promo = false;
}