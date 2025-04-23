<?php
class User {
  private $db;

  public function __construct(){
      $this->db = new Database();
  }

  public function createUser($email, $password, $role = 'customer') {
      // Query to insert user
      $this->db->query('INSERT INTO users (email, password, user_role) VALUES (:email, :password, :role)');
      
      // Bind values
      $this->db->bind(':email', $email);
      $this->db->bind(':password', $password);
      $this->db->bind(':role', $role);

      // Execute the query and check if it's successful
      if ($this->db->execute()) {
          // Access lastInsertId() from $this->db, not $this
          return $this->db->lastInsertId();  // Corrected to use $this->db->lastInsertId()
      }
      return false;  // Return false if insert fails
  }

  
  public function findUserByEmail($email) {
      // Add debug log
      error_log("Looking up user with email: " . $email);
      
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);
      
      // Return the actual user row
      $row = $this->db->single();
      
      if ($this->db->rowCount() > 0) {
          error_log("User found with ID: " . $row->user_id . ", Role: " . $row->user_role);
          return $row;
      } else {
          error_log("No user found with email: " . $email);
          return false;
      }
  }
  
  public function addUser($data) {
      $this->db->query("INSERT INTO users (email, password, user_role) VALUES (:email, :password, :role)");
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
      $this->db->bind(':role', $data['role']);

      if ($this->db->execute()) {
          return $this->db->getDbh()->lastInsertId(); // Return the id of the newly created user
      } else {
          return false;
      }
  }
}
?>
