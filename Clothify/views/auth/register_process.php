<?php
session_start();
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/AuthController.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password !== $confirm){
        die("Passwords do not match. <a href='register.php'>Go Back</a>");
    }

    $auth = new AuthController($conn);
    $result = $auth->register($username, $email, $password);

    if($result['status']){
        header("Location: login.php?success=" . urlencode($result['message']));
        exit;
    } else {
        die($result['message'] . " <a href='register.php'>Go Back</a>");
    }
} else {
    header("Location: register.php");
    exit;
}
