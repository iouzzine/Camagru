<?php

session_start();

include_once 'include/functions.php';

already_logged();

include_once "include/header.inc.php";

?>

<main>
    <div class="container mt-4">

        <?php include_once "include/alert.inc.php" ?>

        <form action="include/login.inc.php" method="post">
            <div class="form-group">
                <label for="">Username | Email</label>
                <input type="text" class="form-control" name="usermail" placeholder="Enter your username or email" required>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="pwd" placeholder="Enter your Password" required>
            </div>
            <p><a class="text-info text-decoration-none font-weight-bolder" href="forget.php">Forgot your password ?</a></p>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php include_once "include/footer.inc.php"; ?>