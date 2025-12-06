<?php
include __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;
    public function __construct($conn){
        $this->userModel = new User($conn);
    }

    public function register($username, $email, $password){
        return $this->userModel->register($username, $email, $password);
    }

    public function login($email, $password){
        $user = $this->userModel->login($email, $password);
        if($user){
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();
    }
}
?>
