<?php

session_start();

include_once "include/functions.php";
include_once 'config/database.php';

logged_only();

include_once "include/header.inc.php";

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
if (checkbox_email($pdo, $_SESSION['auth']['id'])) {
    $_SESSION['checkemail'] = "true";
} else {
    $_SESSION['checkemail'] = "false";
}

?>
    <main>

        <div class="container-fluid mt-4">

            <?php include_once "include/alert.inc.php" ?>

            <div class="jumbotron text-center">

                <h1>Hello <?= htmlspecialchars($_SESSION['auth']['username']) ?></h1>

                <hr class="my-4">

                <p>Welcome to your profile you can change your informations also your password and delete your pictures or account</p>

                <hr class="my-4">

                <button class="collapsible bg-primary nooutline">Change information</button>

                <div class="content bg-light border-primary">

                    <div class="container mt-4">

                        <form action="include/information.inc.php" method="post">

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="<?= htmlspecialchars($_SESSION['auth']['email']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" placeholder="<?= htmlspecialchars($_SESSION['auth']['username']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="pwd" placeholder="Your Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

                <hr class="my-4">

                <button class="collapsible bg-primary nooutline">Change password</button>

                <div class="content bg-light border-primary">

                    <div class="container mt-4">

                        <form action="include/password.inc.php" method="post">
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="newpwd" placeholder="Your new password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Again Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="newpwdrepeat" placeholder="Again your new password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Old Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="pwd" placeholder="Your old Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>

                </div>
                <hr class="my-4">

                <button class="collapsible bg-primary nooutline">Other options</button>

                <div class="content bg-light border-primary">

                    <div class="container mt-4">

                        <form action="include/other.inc.php" method="post">

                            <div class="form-group row">
                                <div class="form-group form-check col-sm-10">
                                    <p class="text-primary"><i class="fas fa-envelope"></i> Receive notifications on your email</p>
                                    <div class="custom-control custom-switch">
                                        <?php
                                            if (checkbox_email($pdo, $_SESSION['auth']['id'])) { ?>
                                                <input type="checkbox" class="custom-control-input" name="check" id="customSwitch1" checked>
                                            <?php } else { ?>
                                                    <input type="checkbox" class="custom-control-input" name="check" id="customSwitch1" >
                                                <?php } ?>
                                        <label class="custom-control-label" for="customSwitch1"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button class="btn btn-dark" name="deleteallpic">Delete all my pictures</button>
                                    <p class="text-danger mt-3"><i class="fas fa-exclamation-triangle"></i>This option is irreversible</p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button class="btn btn-dark" name="deleteall">Delete all my data</button>
                                    <p class="text-danger mt-3"><i class="fas fa-exclamation-triangle"></i>This option is irreversible</p>
                                </div>
                            </div>

                            <hr class="my-4">

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <script src="js/coll.js"></script>

    </main>

<?php include_once "include/footer.inc.php"; ?>