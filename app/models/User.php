<?php
  class User {
    private $db;

    public function __construct() {
      $this->db = new Database();
    }

    // Find user by email
    public function findUserByEmail($email) {
      $this->db->query("SELECT * FROM users WHERE email = :email");

      // Bind value
      $this->db->bind(":email", $email);

      $row = $this->db->single();

      // Check row
      if ($this->db->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

    // Register user
    public function register($data) {
      $this->db->query("INSERT INTO users(email, name, password) VALUES(:email, :name, :password)");

      // Bind values
      $this->db->bind(":email", $data["email"]);
      $this->db->bind(":name", $data["name"]);
      $this->db->bind(":password", $data["password"]);

      // Execute
      if($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    // Login
    public function login($data) {
      $this->db->query("SELECT * FROM users WHERE email = :email");
      $this->db->bind(":email", $data["email"]);

      $row = $this->db->single();
      $hashed_password = $row->password;
      if (password_verify($data["password"], $hashed_password)) {
        return $row;
      } else {
        return false;
      }
    }

    // Get user by id
    public function getUserById($id) {
      $this->db->query("SELECT * FROM users WHERE id = :id");

      // Bind value
      $this->db->bind(":id", $id);

      $row = $this->db->single();

      return $row;
    }
  }
?>
