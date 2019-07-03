<?php

session_start();

require_once 'connect.php';

$error = array();
$success = array();

if (!empty($_POST)) {

    require_once 'functions.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $checkpwd = $_POST['pwd'];

    $req = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $req->execute([$_SESSION['auth']['username'], $_SESSION['auth']['email']]);
    $user = $req->fetch();

    if (empty($checkpwd)) {
        $error['nopwd'] = "No password !";
    } else if (empty($email) && empty($username)) {
            $error['nochange'] = "No change !";
    } else if (!password_verify($checkpwd, $user['password'])){
        $error['checkpwd'] = "Your password is incorrect";
    } else {
        if (!empty($username) && empty($email) && $username == $user['username']) {
            $error['username'] = "Your username is identical";
        } else if (empty($username) && !empty($email) && $email == $user['email']) {
            $error['email'] = "Your email is identical";
        } else if (!empty($username) && !empty($email) && $email == $user['email'] && $username == $user['username']) {
            $error['usermail'] = "Your email and username is identical";
        }
    }

    if (empty($error) && (!empty($username) || !empty($email))) {
        if (!empty($username) && empty($email)) {
            if (check_username($username)) {
                $error ['username'] = "Your username is not valid";
            } else {
                $pdo->prepare("UPDATE users SET username = ? WHERE id = ?")->execute([$username, $_SESSION['auth']['id']]);
                $sub = 'Confirmation of the change of your account';
                $text = "To login to your account please use your new username\n\nhttps://camagru.hash-os.com/login.php";
                mail_headers($_SESSION['auth']['email'],$sub, $text);
                unset($_SESSION['auth']);
            }
        } else if (empty($username) && !empty($email)) {
            if (check_email($email)) {
                $error['email'] = "Your email is not valid";
            } else {
                $pdo->prepare("UPDATE users SET email = ? WHERE id = ?")->execute([$email, $_SESSION['auth']['id']]);
                $sub = "Confirmation of the change of your account";
                $text = "To login to your account please use your new email\n\nhttps://camagru.hash-os.com/login.php";
                mail_headers($email, $sub, $text);
                unset($_SESSION['auth']);
            }
        } else if (!empty($username) && !empty($email)) {
            if (check_username($username) && check_email($email)) {
                $error['usermail'] = "Your email and username is not valid";
            } else {
                $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?")->execute([$username, $email, $_SESSION['auth']['id']]);
                $sub = "Confirmation of the change of your account";
                $text = "To login to your account please use your new username et email\n\nhttps://camagru.hash-os.com/login.php";
                mail_headers($email, $sub,$text);
                unset($_SESSION['auth']);
            }
        }
    }

    if (!empty($error)) {
        $_SESSION['errors'] = $error;
    }

    if (!empty($success)) {
        $_SESSION['success'] = $success;
    }

    header("Location: ../account.php");
    exit();

}

header("Location: ../account.php");
exit();