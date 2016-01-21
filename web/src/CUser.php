<?php

class CUser {
  private $m_id;
  private $m_login;
  private $m_privileges;
  private $m_pass;
  private $db;

  function __construct($db, $login) {
    $this->m_login = $login;
    $this->db = $db;
    $this->get();
  }

  /**
   * @access public
   */
  public function getPwHash() {
    return $this->m_pass;
  }

  /**
   * @access public
   */
  public function getLogin() {
    return $this->m_login;
  }

  /**
   * @access public
   */
  public function getPrivileges() {
    return $this->m_privileges;
  }

  /**
   * @access private
   */
  private function fetch() {
    $result = $this->db->get("SELECT id, login, pass, privileges FROM users WHERE login = :login;",
		      array(":login" => $this->login));

    $row = $result[0];
    $this->m_id = $row["id"];
    $this->m_login = $row["login"];
    $this->m_isAdmin = $row["isadmin"];
    $this->m_pass = $row["pass"];
    
    return $row;
  }

  /**
   * @access public
   */
  public function login($pass) {
    $result = $this->db->get("SELECT pass FROM users WHERE login = :login",
		       array(":login" => $this->login));

    if (password_verify($pass, $result[0]["pass"])) {
      $this->get();
    } else {
      throw new \Exception("Nieprawidłowy użytkownik lub hasło");
    }
  }

  /**
   * @access public
   */
  public function changePassword($password) {
    $pass = password_hash($password, PASSWORD_BCRYPT);

    $num = $this->db->post("UPDATE users SET pass = :pass WHERE login = :login;",
      array(":pass" => $pass, ":login" => $this->login));
  }
}
