<?php

include 'database.php';
include '../include/connect.php';

$usereq = ("CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  email VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  check_email BOOLEAN default 1 null,
  confirmation_token VARCHAR(60) NULL,
  confirmed_at DATETIME NULL,
  reset_token VARCHAR(60) NULL,
  reset_at DATETIME NULL
)");

$picturereq = (" CREATE TABLE pictures (
     id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
     picurl LONGTEXT NOT NULL,
     id_user INT(11) NOT NULL,
     take_at DATETIME NOT NULL
)");

$commentreq = (" CREATE TABLE comments (
     id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
     comments LONGTEXT NOT NULL,
     user_id INT(11) NOT NULL,
     picture_id INT(11) NOT NULL,
     commented_at DATETIME NOT NULL
)");

$likereq = (" CREATE TABLE likes (
     id INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
     user_id INT(11) NOT NULL,
     picture_id INT(11) NOT NULL,
     liked BOOLEAN NOT NULL DEFAULT 0,
     liked_at DATETIME NOT NULL
)");

try {
    $pdo->query($usereq) && $pdo->query($picturereq) && $pdo->query($commentreq) && $pdo->query($likereq);
    die("All table are created successfully");
} catch (PDOException $e) {
    if (!empty($e)) {
        die("All table already created");
    }
}

