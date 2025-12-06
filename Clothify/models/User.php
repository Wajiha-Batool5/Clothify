<?php
class User {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Create a new user
    public function create($username, $email, $password){
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findByEmail($email){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Verify user login
    public function verify($email, $password){
        $user = $this->findByEmail($email);
        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }
}
