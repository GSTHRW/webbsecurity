<?php
session_start();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("CSRF token validation failed.");
    header('Location: store.php');
}

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}

session_destroy(); //deletes all session variables! might need to be changed

header("Location: index.php");
?>