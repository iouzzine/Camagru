<?php

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru</title>
    <link rel="icon" href="css/favicon.ico">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css">
    <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="js/main.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Camagru</a>
        <button class="navbar-toggler" type="button" id="showmenu" onclick="dropDownNav()">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/gallery.php" class="nav-link">Gallery</a>
                </li>
                <?php if(isset($_SESSION['auth'])) { ?>
                    <li class="nav-item">
                        <a href="/webcam.php" class="nav-link">Take Picture</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (!isset($_SESSION['auth'])) { ?>
                <li class="nav-item">
                    <a href="/login.php" class="nav-link">Login</i></i></a>
                </li>
                <li class="nav-item">
                    <a href="/signup.php" class="nav-link">Signup</i></i></a>
                </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a href="/account.php" class="nav-link">
                            <?=htmlspecialchars($_SESSION['auth']['username']) ?>
                            <i class="fas fa-user-circle" style="font-size: 1.3rem;"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/logout.php" class="nav-link">Logout</i></i></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
