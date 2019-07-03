<?php

include "connect.php";
include_once  'functions.php';

session_start();

$error = array();
$success = array();

$user_id = $_GET['id'];
$token = $_GET['token'];

$req = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$req->execute([$user_id]);
$user = $req->fetch();

if ($user && $user['confirmation_token'] === $token) {
    $pdo->prepare("UPDATE users SET confirmation_token = NULL , confirmed_at = NOW() WHERE id = ?")->execute([$user_id]);
    $url = parse_url($_SERVER['HTTP_REFERER']);
    $link = $url['host'];
    $sub = 'Confirmation of your account';
    $text = "Your account has been validated";
    mail_headers($user["email"], $sub, $text);
    $success ['loged'] = "Your account has been validated";
} else {
    $error ['notcorret'] = "This token is not valid";
}

if (!empty($error)) {
    $_SESSION['errors'] = $error;
    header('Location: ../login.php');
}

if (!empty($success)) {
    $_SESSION['success'] = $success;
    header('Location: ../login.php');
}