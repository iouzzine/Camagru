<?php

session_start();

include_once "include/functions.php";

already_logged();

include_once "include/header.inc.php";

?>

<main>
    <div class="container mt-4">

        <?php include_once "include/alert.inc.php" ?>

        <form action="include/signup.inc.php" method="post">
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="pwd" placeholder="Enter your Password" required>
                <small class="form-text text-muted">Your password must contain at least one uppercase letter, one lowercase letter, one number, one special character and must be between 6 and 12</small>
            </div>
            <div class="form-group">
                <label for="">Password agin</label>
                <input type="password" class="form-control" name="pwdrepeat" placeholder="Enter again your Password" required>
            </div>
            <div class="form-group">
                <label for="pwd">Captcha</label>
                <img src="include/captcha.php" />
                <input type="text" name="captcha" class="form-control" placeholder="Enter captcha code" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php include_once "include/footer.inc.php"; ?>