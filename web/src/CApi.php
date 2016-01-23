<?php

class CAPI{
  private $m_user;
  private $m_cart;
  private $m_product;

  public function __construct() {
    $this->m_user = new CUser();
    $this->m_basket = new CBasket();
    $this->m_product = new CProduct();
  }

  public function login() {
    $this->m_user->login();
  }

  public function register() {
    $this->m_user->register();
  }

  public function getBuyProducts() {
    $this->m_basket->getItems();
  }

  public function getProducts() {
    $this->m_product->getAll();
  }

  public function getProduct($id) {
    $this->m_product->get($id);
  }
}

// testy
$client = new CAPI();
$client->register();
$client->login();
$client->getProducts();
$client->getProduct(5);
$client->getBuyProducts();

?>
