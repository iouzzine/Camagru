<?php

session_start();

include_once 'include/functions.php';

already_logged();

include_once "include/header.inc.php";

?>

<main>
    <div class="container mt-4">

        <?php include_once "include/alert.inc.php" ?>

        <form action="include/forget.inc.php" method="post">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</main>

<?php include_once "include/footer.inc.php"; ?>