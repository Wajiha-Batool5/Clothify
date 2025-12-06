<?php
include __DIR__ . '/../models/User.php';

class AuthController {
    private $user;

    public function __construct($conn){
        $this->user = new User($conn);
    }

    public function register($username, $email, $password){
        // Check if user exists
        if($this->user->findByEmail($email)){
            return ['status'=>false, 'message'=>'Email already registered'];
        }

        if($this->user->create($username, $email, $password)){
            return ['status'=>true, 'message'=>'Registration successful'];
        } else {
            return ['status'=>false, 'message'=>'Registration failed'];
        }
    }

    public function login($email, $password){
        $user = $this->user->verify($email, $password);
        if($user){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return ['status'=>true, 'message'=>'Login successful'];
        } else {
            return ['status'=>false, 'message'=>'Invalid email or password'];
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
    }
}
