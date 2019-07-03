<?php

session_start();

require_once 'connect.php';

$error = array();
$success = array();

if (!empty($_POST)) {

    require_once 'functions.php';

    $pwd = $_POST['pwd'];
    $newpwd = $_POST['newpwd'];
    $newpwdrepeat = $_POST['newpwdrepeat'];

    $req = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $req->execute([$_SESSION['auth']['username'], $_SESSION['auth']['email']]);
    $user = $req->fetch();

    if (empty($pwd)) {
        $error['nopwd'] = "No password !";
    } else if (!password_verify($pwd, $user['password'])) {
        $error['checkpwd'] = "Your password is incorrect";
    } else if (empty($newpwd) && empty($newpwdrepeat)) {
        $error['nochange'] = "No change !";
    } else {
        if (check_pwd($newpwd)) {
            $error['newpwd'] = "Your new password is incorrect";
        } else if ($newpwd != $newpwdrepeat) {
            $error ['pwd-repeat'] = "The two passwords are not identical";
        } else if (password_verify($newpwd, $user['password'])) {
            $error['samepwd'] = "Your new password is identical to the old one";
        }
    }

    if (empty($error)) {
        $newpwdhash = password_hash($newpwd, PASSWORD_BCRYPT);
        $pdo->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$newpwdhash, $_SESSION['auth']['id']]);
        $sub = 'Confirmation of the change of your account';
        $text = "In order to login to your account please use your new password\n\nhttps://camagru.hash-os.com/login.php";
        mail_headers($_SESSION['auth']['email'],$sub, $text);
        unset($_SESSION['auth']);
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