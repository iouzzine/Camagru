<?php

session_start();

$success = array();

unset($_SESSION['auth']);

$success ['logout'] = "You're now disconnected";

if (!empty($success)) {
    $_SESSION['success'] = $success;
}


header ("Location: login.php");