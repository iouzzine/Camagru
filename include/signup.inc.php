<?php

session_start();

include 'connect.php';

if (!empty($_POST)) {

    require_once 'functions.php';

    $error = array();
    $success = array();

    $captcha = $_POST['captcha'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $pwdrepeat = $_POST['pwdrepeat'];

    if ($captcha == $_SESSION['captcha_code']) {

        if (empty($email) || check_email($email)) {
            $error ['email'] = "Your email is invalid";
        } else {
            $req = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $req->execute([$email]);
            $emailexist = $req->fetch();
            if ($emailexist){
                $error ['email'] = "This email is already taken!";
            }
        }

        if (empty($username) || check_username($username)) {
            $error ['username'] = "Your username is not valid (alphanumeric)";
        } else {
            $req = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $req->execute([$username]);
            $userexist = $req->fetch();
            if ($userexist) {
                $error ['username'] = "This username is already taken!";
            }
        }

        if (empty($pwd)|| check_pwd($pwd)) {
            $error ['pwd'] = "Your password is incorrect";
            $error['checkpwd'] = "Your password must contain at least one uppercase letter, one lowercase letter, one number, one special character and must be between 6 and 12";
        }

        if (empty($error ['pwd'])) {
            if (empty($pwdrepeat) || $pwd != $pwdrepeat) {
                $error ['pwd-repeat'] = "The two passwords are not identical";
            }
        }

        if (empty($error)) {
            $req = $pdo->prepare("INSERT INTO users SET email = ?, username = ?, password = ?, confirmation_token = ?");
            $pwdhash = password_hash($pwd, PASSWORD_BCRYPT);
            $token = str_random(60);
            $req->execute([$email, $username, $pwdhash, $token]);
            $user_id = $pdo->lastInsertId();
            $url = parse_url($_SERVER['HTTP_REFERER']);
            $link = $url['host'];
            $sub = 'Confirmation of your account';
            $text = "In order to validate your account, please click on this link\n\n$link/include/confirm.inc.php?id=$user_id&token=$token";
            mail_headers($email, $sub, $text);
            $success ['success'] = "A confirmation email has been sent to you to validate your account";
        }

    } else {
        $error['captcha'] = "Your captcha code is incorrect";
    }

    if (!empty($error)) {
        $_SESSION['errors'] = $error;
    }

    if (!empty($success)) {
        $_SESSION['success'] = $success;
    }

}

header("Location: ../signup.php");
exit();