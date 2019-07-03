<?php

session_start();

require_once 'connect.php';
require_once 'functions.php';

$error = array();
$success = array();

$newpwd = $_POST['newpwd'];
$newpwdrepeat = $_POST['newpwdrepeat'];
$email = $_SESSION['user_email'];

if (check_pwd($newpwd)) {
    $error['pwd'] = "Your password is incorrect";
} else if ($newpwd !== $newpwdrepeat) {
    $error['pwd-repeat'] = "The two passwords are not identical";
} else {
    $newpwdhash = password_hash($newpwd, PASSWORD_BCRYPT);
    $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_at = NOW()")->execute([$newpwdhash]);
    $url = parse_url($_SERVER['HTTP_REFERER']);
    $link = $url['host'];
    $sub = 'Confirmation of the change for your password';
    $text = "Your can login with your new password, \n\n$link/login.php";
    mail_headers($email, $sub, $text);
    unset($email);
    $success['pwd'] = "Your password has been changed";
}

if (!empty($error)) {
    $_SESSION['errors'] = $error;
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

if (!empty($success)) {
    $_SESSION['success'] = $success;
    header("Location: ../login.php");
    exit();
}

header("Location: ../login.php");
exit();