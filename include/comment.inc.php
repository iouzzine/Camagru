<?php

session_start();

include_once '../config/database.php';
include_once 'functions.php';

include_once 'connect.php';

$error = array();

$comment = trim($_POST['commentext']);

if (empty($comment))
{
    $error ['empty'] = "Your comment is empty";
} else if (!isset($_SESSION['auth'])) {
    $error['loggedonly'] = "You must be logged to comment this photo";
}else {
    $pictureid = $_POST['pictureid'];
    $pdo->prepare("INSERT INTO comments SET comments = ? , user_id = ? , picture_id = ?, commented_at = NOW()")->execute([$comment, $_SESSION['auth']['id'], $pictureid]);
    $req = $pdo->prepare("SELECT id_user FROM pictures WHERE id = ?");
    $req->execute([$pictureid]);
    $res = $req->fetch();
    $req2 = $pdo->prepare("SELECT email, check_email FROM users WHERE id = ?");
    $req2->execute([$res['id_user']]);
    $res2 = $req2->fetch();
    if ($res2['check_email'] == "1") {
        $sub = 'Your photo has been commented';
        $text = "You have received a new comment on one of your photos";
        mail_headers($res2['email'], $sub, $text);
    }
}

if (!empty($error)) {
    $_SESSION['errors'] = $error;
}

header("Location: ../gallery.php");
exit();