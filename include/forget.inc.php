<?php

session_start();

$email = $_POST['email'];

if (isset($_POST) && !empty($email)) {

    require_once 'connect.php';
    require_once 'functions.php';

    $error = array();
    $success = array();

    if (check_email($email)){
        $error['email'] = "Enter a valid email !";
    } else {

        $req = $pdo->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");
        $req->execute([$email]);
        $user = $req->fetch();

        if (!$user) {
            $error['notfount'] = "No account found !";
            header("Location: ../forget.php");
        } else {
            $reset_token = str_random(60);
            $pdo->prepare("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?")->execute([$reset_token, $user['id']]);
            $url = parse_url($_SERVER['HTTP_REFERER']);
            $link = $url['host'];
            $sub = 'Resetting your password';
            $text = "To reset your password please click on this link\n\n$link/reset.php?id={$user['id']}&token=$reset_token";
            mail_headers($email, $sub, $text);
            $success['emailsent'] = "The instructions for the reset password have been sent to you on your email";
            header("Location: ../login.php");
        }
    }

    if (!empty($error)) {
        $_SESSION['errors'] = $error;
    }

    if (!empty($success)) {
        $_SESSION['success'] = $success;
    }

}

header("Location: ../forget.php");
exit();