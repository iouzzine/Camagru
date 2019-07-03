<?php

require_once 'connect.php';

session_start();

if (!empty($_POST)) {
    $picurl = $_POST['picurl'];
    $selectf = $_POST['selectf'];
    $emox = $_POST['emox'];
    $emoy = $_POST['emoy'];

    $im = imagecreatefrompng($picurl);

    if (empty($emox) || empty($emoy)) {
        $emox = 0;
        $emoy = 0;
    }

    if ($selectf == "banana") {
        list($width, $height) = getimagesize("../filters/banana.png");
        $banana = imagecreatefrompng('../filters/banana.png');
        imagecopy($im, $banana, $emox, $emoy, 0, 0, $width, $height);
        imagepng($im, "test.png");
        $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents("test.png"));
        $pdo->prepare("INSERT INTO pictures SET picurl = ?, id_user = ?, take_at = NOW()")->execute([$base64, $_SESSION['auth']['id']]);
        unlink("test.png");
    } else if ($selectf == "emo1") {
        list($width, $height) = getimagesize("../filters/emo1.png");
        $emo = imagecreatefrompng('../filters/emo1.png');
        imagecopy($im, $emo, $emox, $emoy, 0, 0, $width, $height);
        imagepng($im, "test.png");
        $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents("test.png"));
        $pdo->prepare("INSERT INTO pictures SET picurl = ?, id_user = ?, take_at = NOW()")->execute([$base64, $_SESSION['auth']['id']]);
        unlink("test.png");
    } else if ($selectf == "emo2") {
        list($width, $height) = getimagesize("../filters/emo2.png");
        $emo = imagecreatefrompng('../filters/emo2.png');
        imagecopy($im, $emo, $emox, $emoy, 0, 0, $width, $height);
        imagepng($im, "test.png");
        $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents("test.png"));
        $pdo->prepare("INSERT INTO pictures SET picurl = ?, id_user = ?, take_at = NOW()")->execute([$base64, $_SESSION['auth']['id']]);
        unlink("test.png");
    } else if ($selectf == "emo3") {
        list($width, $height) = getimagesize("../filters/emo3.png");
        $emo = imagecreatefrompng('../filters/emo3.png');
        imagecopy($im, $emo, $emox, $emoy, 0, 0, $width, $height);
        imagepng($im, "test.png");
        $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents("test.png"));
        $pdo->prepare("INSERT INTO pictures SET picurl = ?, id_user = ?, take_at = NOW()")->execute([$base64, $_SESSION['auth']['id']]);
        unlink("test.png");
    } else if ($selectf == "twitter") {
        list($width, $height) = getimagesize("../filters/twitter.png");
        $twitter = imagecreatefrompng('../filters/twitter.png');
        imagecopy($im, $twitter, $emox, $emoy, 0, 0, $width, $height);
        imagepng($im, "test.png");
        $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents("test.png"));
        $pdo->prepare("INSERT INTO pictures SET picurl = ?, id_user = ?, take_at = NOW()")->execute([$base64, $_SESSION['auth']['id']]);
        unlink("test.png");
    } else if ($selectf == "whatsapp") {
        list($width, $height) = getimagesize("../filters/whatsapp.png");
        $whatsapp = imagecreatefrompng('../filters/whatsapp.png');
        imagecopy($im, $whatsapp, $emox, $emoy, 0, 0, $width, $height);
        imagepng($im, "test.png");
        $base64 = 'data:image/png;base64,' . base64_encode(file_get_contents("test.png"));
        $pdo->prepare("INSERT INTO pictures SET picurl = ?, id_user = ?, take_at = NOW()")->execute([$base64, $_SESSION['auth']['id']]);
        unlink("test.png");
    }

    header("Location: ../webcam.php");
    exit();
}

header("Location: ../webcam.php");
exit();