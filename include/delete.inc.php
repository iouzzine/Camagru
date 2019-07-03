<?php

include_once 'functions.php';
include_once 'connect.php';

$pdo->prepare("DELETE FROM pictures WHERE id = ? ")->execute([$_POST['picid']]);

header("Location: ../webcam.php");
exit();