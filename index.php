<?php

session_start();

include_once 'config/database.php';
include_once 'include/functions.php';

include_once "include/header.inc.php";

?>

<main>

    <?php

    if (isset($_SESSION['auth'])) {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $req = $pdo->prepare("SELECT picurl, id FROM pictures WHERE id_user = ? ORDER BY take_at DESC LIMIT 6");
        $req->execute([$_SESSION['auth']['id']]);
        $urlpic = $req->fetchAll(PDO::FETCH_ASSOC);
        if (empty($urlpic)) {
            echo '<div class="jumbotron">
                <a href="/webcam.php" class="btn btn-outline-dark">
                    <h3 class="display-5">Share your first picture</h3>
                </a>
              </div>';
        } else {
            echo '<div class="jumbotron">
                <h3 class="display-5">Your last 6 pictures shared</h3>
              </div>';
            echo '<div class="container mt-4"> <div class="row">';
            foreach ($urlpic as $pic){
                $picture = $pic['picurl'];
                echo '
                        <div class="col-md-4 mx-auto">
                            <div class="card mb-5 border-gray">
                                <img class="w-100" src="'.$picture.'" />
                                <div class="card-footer">
                                    <p class="card-text"><span style="color: Tomato;" class="mr-3"><i class="fas fa-heart mr-1"></i>'.alllikes($pdo, $pic['id']).'</span><span style="color: Dodgerblue;" class="mr-2"><i class="fas fa-comment mr-1"></i>     '.allcoms($pdo,$pic['id']).'</span></p>
                                </div>
                            </div>
                        </div>
                     ';
            }
            echo '</div></div>';
        }
    } else {
        echo '<div class="jumbotron">
                <h3 class="display-5">Join our community and share your lovely pictures !</h3>
                <a href="/signup.php" class="btn btn-outline-dark">
                    <h3 class="display-5">Register</h3>
                </a>
              </div>';
    }

    ?>

</main>

<?php include_once "include/footer.inc.php"; ?>
