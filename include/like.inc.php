<?php

session_start();

include_once 'functions.php';
include_once 'connect.php';

$error = array();

if (isset($_SESSION['auth'])) {
    $pictureid = $_POST['pictureid'];
    if (isset($_POST['like'])) {
        $pdo->prepare("INSERT INTO likes SET user_id = ?, picture_id = ?, liked = ?, liked_at = NOW()")->execute([$_SESSION['auth']['id'], $pictureid, "1"]);
        $req = $pdo->prepare("SELECT id_user FROM pictures WHERE id = ?");
        $req->execute([$pictureid]);
        $res = $req->fetch();
        $req2 = $pdo->prepare("SELECT email, check_email FROM users WHERE id = ?");
        $req2->execute([$res['id_user']]);
        $res2 = $req2->fetch();
        if ($res2['check_email'] == "1") {
            $sub = 'Your photo has been liked';
            $text = "You have received a new like on one of your photos";
            mail_headers($res2['email'], $sub, $text);
        }
    } else {
        $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND picture_id = ? ")->execute([$_SESSION['auth']['id'], $pictureid]);
    }
} else {
    $error['loggedonly'] = "You must be logged to like this photo";
}

if (!empty($error)) {
    $_SESSION['errors'] = $error;
}

header("Location: ../gallery.php");
exit();
