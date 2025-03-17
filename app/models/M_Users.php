<?php
 class M_Users{
  
     private $db;

     public function __construct(){
         $this->db = new Database();
     }
     //register the user
     public function register($data){
       $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
       $this->db->bind(':name', $data['name']);
       $this->db->bind(':email', $data['email']);
       $this->db->bind(':password', $data['password']);

       if($this->db->execute()){
        return true;
       }
       else{
        return false;
       }
     }
     public function getUsers() {
      $this->db->query("SELECT * FROM users");
      return $this->db->resultSet(); // Assuming `resultSet` fetches all rows
  }
  
     //find the user
     public function findUserByEmail($email){
       $this->db->query("SELECT * FROM Users WHERE email = :email");
       $this->db->bind(':email', $email);

       $row = $this->db->single();

       if($this->db->rowCount() > 0){
        return true;
       }
       else{
        return false;
       }
     }

     
      //login the user
     public function loginn($email,$password){
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
 
        $row = $this->db->single();
        
        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
         return $row;
        }else{
         return false;
        }
 
      }
      public function storePasswordResetToken($email, $token) {
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $this->db->query("UPDATE users SET reset_token = :token, reset_expires = :expires WHERE email = :email");
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':email', $email);
    
        return $this->db->execute();
    }
      public function findUserByToken($token) {
    $this->db->query("SELECT * FROM users WHERE reset_token = :token");
    $this->db->bind(':token', $token);

    return $this->db->single();
}

public function updatePassword($email, $hashedPassword) {
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $this->db->query("UPDATE users SET password = :password WHERE email = :email");
    $this->db->bind(':password', $hashedPassword);
    $this->db->bind(':email', $email);

    return $this->db->execute();
}

public function clearResetToken($email) {
    $this->db->query("UPDATE users SET reset_token = NULL, reset_expires = NULL WHERE email = :email");
    $this->db->bind(':email', $email);

    return $this->db->execute();
}

  
}
?>
     