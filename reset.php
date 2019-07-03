<?php

session_start();

include_once 'include/functions.php';
include_once 'config/database.php';

already_logged();

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);

$error = array();
$success = array();

$user_id = $_GET['id'];
$token = $_GET['token'];

if (empty($_GET['id']) || empty($_GET['token'])) {
    $error['forget'] = "You have nothing to do here!";
} else {
    $req = $pdo->prepare("SELECT * FROM users WHERE id = ? AND reset_token is NOT NULL and reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL  30 MINUTE )");
    $req->execute([$user_id, $token]);
    $user = $req->fetch();

    if($user) {
        $_SESSION['user_email'] = $user['email'];
    }else {
        $error ['notcorret'] = "This token is not valid";
    }
}

include_once "include/header.inc.php";

?>

<main>
    <div class="container mt-4">

        <?php include_once "include/alert.inc.php" ?>

        <form action="include/reset.inc.php" method="post">
            <div class="form-group">
                <label for="">New Password</label>
                <input type="password" class="form-control" name="newpwd" placeholder="Enter your new password" required>
            </div>
            <div class="form-group">
                <label for="">New Password agin</label>
                <input type="password" class="form-control" name="newpwdrepeat" placeholder="Enter again your new password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php

if (!empty($error)) {
    $_SESSION['errors'] = $error;
    header("Location: login.php");
    exit();
}

if (!empty($success)) {
    $_SESSION['success'] = $success;
    header("Location: login.php");
    exit();
}

?>