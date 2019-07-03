<?php

/**
 * @param $length
 * @return string
 */
function str_random($length) {
    $alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

/**
 * @param $email
 * @param $sub
 * @param $text
 */
function mail_headers($email, $sub, $text) {
    $to      = $email;
    $subject = $sub;
    $message = $text;
    $headers = 'From: camagru@hash-os.com' . "\r\n" .
        'Reply-To: camagru@hash-os.com' . "\r\n" .
        'X-MSMail-Priority: High' . "\r\n" .
        'X-Priority: 1' . "\r\n" .
        'Importance: High' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}

/**
 * @return bool
 */
function already_logged() {

    if (!empty($_SESSION['auth'])) {
        header("Location: account.php");
        return true;
    }
    return false;
}

/**
 * @return bool
 */
function logged_only() {

    if (empty($_SESSION['auth'])) {
        header("Location: login.php");
        return true;
    }
    return false;
}

/**
 * @param $username
 * @return bool
 */
function check_username($username) {

    if (!preg_match("/^[a-zA-z0-9-_]+$/", $username)){
        return true;
    }
    return false;
}

/**
 * @param $email
 * @return bool
 */
function check_email($email) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

/**
 * @param $pwd
 * @return bool
 */
function check_pwd($pwd) {
    if (!preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{6,12}$/", $pwd)) {
        return true;
    }
    return false;
}

/**
 * @param $params
 * @return string
 */
function give_username($params) {
    if (!isset($pdo)) {
        global $pdo;
    }
    $req = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $req->execute([$params]);
    $res = $req->fetch();
    return $res['username'];
}

/**
 * @param $pdo
 * @param $params
 * @return bool
 */
function checkbox_email($pdo, $params) {
    $req = $pdo->prepare("SELECT check_email FROM users WHERE id = ?");
    $req->execute([$params]);
    $res = $req->fetch();

    if ($res['check_email'] == 1){
            return true;
    } else {
        return false;
    }
}

/**
 * @param $pdo
 * @return int
 */
function pagination($pdo) {
    $req = $pdo->prepare("SELECT COUNT(id) as nbPic FROM pictures");
    $req->execute();
    $data = $req->fetch(PDO::FETCH_ASSOC);
    $nbPic = $data['nbPic'];
    $perPage = 5;
    $nbPage = ceil($nbPic / $perPage);
    if (isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage) {
        return $cPage = $_GET['p'];
    } else {
        return $cPage = 1;
    }
}

/**
 * @param $pdo
 * @return float
 */
function count_pagination($pdo) {
    $req = $pdo->prepare("SELECT COUNT(id) as nbPic FROM pictures");
    $req->execute();
    $data = $req->fetch(PDO::FETCH_ASSOC);
    $nbPic = $data['nbPic'];
    $perPage = 5;
    $nbPage = ceil($nbPic / $perPage);
    return $nbPage;
}

/**
 * @param $pdo
 * @param $cPage
 * @param $perPage
 * @return mixed
 */
function countpicture ($pdo, $cPage, $perPage) {
    $req = $pdo->prepare("SELECT * FROM pictures ORDER BY take_at DESC LIMIT ".(($cPage-1) * $perPage).", $perPage");
    $req->execute();
    $urlpic = $req->fetchAll(PDO::FETCH_ASSOC);
    return $urlpic;
}

/**
 * @param $pdo
 * @param $params
 * @return mixed
 */
function allcom($pdo, $params) {
    $reqcom = $pdo->prepare("SELECT * FROM comments WHERE picture_id = ? ORDER BY commented_at DESC");
    $reqcom->execute([$params]);
    $res =  $reqcom->fetchall(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * @param $pdo
 * @param $params
 * @return mixed
 */
function alllikes($pdo, $params) {
    $likereq = $pdo->prepare("SELECT COUNT(id) as nblikes FROM likes WHERE picture_id = ?");
    $likereq->execute([$params]);
    $data = $likereq->fetch(PDO::FETCH_ASSOC);
    $nbLikes = $data['nblikes'];
    return $nbLikes;
}

function allcoms($pdo, $params) {
    $reqcom = $pdo->prepare("SELECT COUNT(id) as nblikes FROM comments WHERE picture_id = ?");
    $reqcom->execute([$params]);
    $data = $reqcom->fetch(PDO::FETCH_ASSOC);
    $nbcoms = $data['nblikes'];
    return $nbcoms;
}

/**
 * @param $pdo
 * @param $param1
 * @param $param2
 * @return mixed
 */
function check_like($pdo, $param1, $param2) {
    $likereq = $pdo->prepare("SELECT * FROM likes WHERE picture_id = ? AND user_id = ?");
    $likereq->execute([$param1, $param2]);
    $res = $likereq->fetch(PDO::FETCH_ASSOC);
    return $res;
}

/**
 * @param $pdo
 * @param $param
 * @return mixed
 */
function get_user($pdo, $param) {
    $req = $pdo->prepare("SELECT id_user, take_at FROM pictures WHERE id = ?");
    $req->execute([$param]);
    $res = $req->fetch(PDO::FETCH_ASSOC);
    return $res;
}