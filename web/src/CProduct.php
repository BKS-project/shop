<?php
/**
 * @access public
 * @author Łuki
 */
class CProduct {
  private $m_id;
  private $m_name;
  private $m_price;
  private $m_availability;
  private $db;

  function __construct($db, $id) {
    $this->m_id = $id;
    $this->db = $db;

    $result = $this->db->get("SELECT name, price, availability FROM product WHERE id = :id;",
			     array(":id" => $this->m_id));

    $row = $result[0];
    $this->m_name = $row["name"];
    $this->m_price = $row["prive"];
    $this->m_availability = $row["availability"];
  }

  /**
   * @access public
   */
  public function getName() {
    return $this->m_name;
  }

  /**
   * @access public
   */
  public function getPrice() {
    return $this->m_price;
  }

  /**
   * @access public
   */
  public function getAvailability() {
    return $this->m_availability;
  }

  /**
   * @access public
   */
  public function removeProduct() {
    // not yet implemented
  }
}
