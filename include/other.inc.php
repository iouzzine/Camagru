<?php

session_start();

include_once '../config/database.php';
include_once 'functions.php';

include_once 'connect.php';

$success = array();

if (isset($_POST['deleteallpic'])) {
    $pdo->prepare("DELETE FROM pictures WHERE id_user = ? ")->execute([$_SESSION['auth']['id']]);
    $success ['dropall'] = "All your photos have been removed";
} else if (isset($_POST['deleteall'])) {
    $pdo->prepare("DELETE FROM users WHERE id = ? ")->execute([$_SESSION['auth']['id']]);
    $pdo->prepare("DELETE FROM pictures WHERE id_user = ? ")->execute([$_SESSION['auth']['id']]);
    $pdo->prepare("DELETE FROM comments WHERE user_id = ?")->execute([$_SESSION['auth']['id']]);
    unset($_SESSION['auth']);
    $success ['dropall'] = "Your account has been deleted";
    header("Location: ../login.php");
} else if (isset($_POST['check'])) {
    $pdo->prepare("UPDATE users SET check_email = ? WHERE id = ? ")->execute(["1", $_SESSION['auth']['id']]);
    $success ['dropall'] = "From now, you will receive notifications";
} else {
    $pdo->prepare("UPDATE users SET check_email = ? WHERE id = ? ")->execute(["0", $_SESSION['auth']['id']]);
    $success ['dropall'] = "You'll no longer receive notifications";
}

if (!empty($success)) {
    $_SESSION['success'] = $success;
}

header("Location: ../account.php");
exit();