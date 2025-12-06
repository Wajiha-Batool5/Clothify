<?php
session_start();
include __DIR__ . '/../../config/db.php';
include __DIR__ . '/../../controllers/AuthController.php';

$auth = new AuthController($conn);
$auth->logout();
header("Location: login.php");
exit;
