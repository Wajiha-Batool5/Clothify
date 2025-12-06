<?php
session_start();
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/AuthController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $auth = new AuthController($conn);
    $result = $auth->login($email, $password);

    if($result['status']){
        header("Location: ../../index.php"); // Redirect to homepage
        exit;
    } else {
        die($result['message'] . " <a href='login.php'>Go Back</a>");
    }
} else {
    header("Location: login.php");
    exit;
}
