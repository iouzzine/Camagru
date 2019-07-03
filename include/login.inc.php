<?php

session_start();

include 'connect.php';

if (!empty($_POST)) {

    require_once 'functions.php';

    $error = array();
    $success = array();

    $usermail = $_POST['usermail'];
    $pwd = $_POST['pwd'];

    $req = $pdo->prepare("SELECT * FROM users WHERE (username = :usermail OR email = :usermail)");
    $req->execute(['usermail' => $usermail]);
    $user = $req->fetch();

    if (!$user) {
        $error['notfount'] = "No account found !";
    } else if ($user['confirmation_token'] != NULL && $user['confirmed_at'] == NULL) {
        $error ['confirmation'] = "Please activate your account before logging in";
    } else if (password_verify($pwd, $user['password'])) {
        $_SESSION['auth'] = $user;
        $success ['loged'] = "You're well connected";
    } else {
        $error ['notcorret'] = "Incorrect username or password";
    }

    if (!empty($error)) {
        $_SESSION['errors'] = $error;
    }

    if (!empty($success)) {
        $_SESSION['success'] = $success;
    }

   if (empty($error)) {
        header("Location: ../account.php");
        exit();
    } else {
        header("Location: ../login.php");
        exit();
    }
}
header("Location: ../login.php");
exit();