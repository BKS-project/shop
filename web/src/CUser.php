<?php

class CUser {
  private $m_id;
  private $m_login;
  private $m_privileges;
  private $db;

  function __construct($db, $login, $password) {
    $this->m_login = $login;
    $this->db = $db;

    if ($this->login($password)) {
      $this->get();
    } else {
      return false;
    }
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
			     array(":login" => $this->m_login));

    $row = $result[0];
    $this->m_id = $row["id"];
    $this->m_login = $row["login"];
    $this->m_privileges = $row["privileges"];

    return $row;
  }

  /**
   * @access private
   */
  private function login($pass) {
    $result = $this->db->get("SELECT pass FROM users WHERE login = :login",
			     array(":login" => $this->m_login));

    if (password_verify($pass, $result[0]["pass"])) {
      return true;
    }
    return false;
  }

  /**
   * @access public
   */
  public function changePassword($password) {
    $pass = password_hash($password, PASSWORD_BCRYPT);

    $num = $this->db->post("UPDATE users SET pass = :pass WHERE login = :login;",
			   array(":pass" => $pass, ":login" => $this->m_login));
  }
}
