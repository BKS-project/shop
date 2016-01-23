<?php

class CDatabase {
  private $m_host;
  private $m_name;
  private $m_user;
  private $m_pass;
  private $pdo;
  
  function __construct($host, $user, $pass, $name) {
    $this->m_host = $host;
    $this->m_name = $name;
    $this->m_user = $user;
    $this->m_pass = $pass;
  }

  function __destruct() {
    $this->pdo = null;
  }

  /**
   * @access public
   */
  public function connect() {
    $dsn = "mysql:host=" . $this->m_host . ";dbname=" . $this->m_name;

    $this->pdo = new \PDO($dsn, $this->m_user, $this->m_pass);
  }

  /**
   * @access public
   */
  public function query($query, $values = array()) {
    $res = $this->pdo->prepare($query);

    foreach ($values as $key => $val) {
      $res->bindValue($key, $val);
    }

    $res->execute();
    return $res;
  }
  
  /**
   * @access public
   */
  public function get($query, $values = array()) {
    $res = $this->query($query, $values);
    $i = $res->rowCount();

    if ($i > 0) {
      $rows = $res->fetchAll();
      return $rows;
    }

    return -1;
  }

  /**
   * @access public
   */
  public function post($query, $values) {
    $res = $this->query($query, $values);

    return $res->rowCount();
  }
}