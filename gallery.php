<?php

session_start();

include_once 'config/database.php';
include_once 'include/functions.php';
include_once 'include/header.inc.php';

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$urlpic = countpicture ($pdo, pagination($pdo), $perPage = 5);
$nbPage = count_pagination($pdo);

if (empty($urlpic)) {
    echo "<div class='jumbotron'><h1 class='display-4'>Empty Gallery</h1></div>";
}

?>

<main>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <?php
                include_once "include/alert.inc.php";
                foreach ($urlpic as $pic) {
                    $repcom = allcom($pdo, $pic['id']);
                    $replike = alllikes($pdo, $pic['id']);
                    $checklike = check_like($pdo, $pic['id'], $_SESSION['auth']['id']); ?>
                    <div class="card mb-5 border-gray">
                        <div class="card-header">
                            <?php
                            $user = get_user($pdo, $pic['id']);
                            $username = give_username($user['id_user']);
                            echo "<i class='fas fa-user'></i> $username";
                            $take_at = date( 'd M H:i', strtotime($user['take_at']));
                            echo "<span style=\"float: right;\"><i class='fas fa-clock'></i> $take_at</span>"
                            ?>
                        </div>
                        <img class="w-100" src="<?= htmlspecialchars($pic['picurl']) ?>" />
                        <div class="card-body mb-4">
                            <form action="include/like.inc.php" class="form-group" method="post">
                                <?php if ($checklike == false) { ?>
                                    <button type="submit" class="mb-2 btn btn-success btn-sm" name="like" <?php if(!isset($_SESSION['auth'])) { ?> disabled <?php } ?>><i class="far fa-thumbs-up"></i> Like <span class="badge badge-light ml-2"><?= htmlspecialchars($replike) ?></span></button>
                                <?php } else { ?>
                                    <button type="submit" class="mb-2 btn btn-primary btn-sm" name="unlike"><i class="far fa-thumbs-up"></i> Unlike <span class="badge badge-light ml-2"><?= htmlspecialchars($replike) ?></span></button>
                                <?php } ?>
                                <input type="hidden" name="pictureid" value="<?= htmlspecialchars($pic['id']) ?>">
                            </form>
                            <form action="include/comment.inc.php" class="form-group" method="post">
                                <div class="media d-flex align-items-center">
                                    <div class="media-body ">
                                        <input type="text" id="inputcom" class="form-control form-control-sm card-text" name="commentext" autocomplete="off" <?php if(!isset($_SESSION['auth'])) { ?> disabled <?php } ?>>
                                        <input type="hidden" name="pictureid" value="<?= htmlspecialchars($pic['id']) ?>">
                                    </div>
                                    <div class="media-right">
                                        <button type="submit" class="btn btn-dark ml-4" <?php if(!isset($_SESSION['auth'])) { ?> disabled <?php } ?>>Envoyer</button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <ul class="list-group">
                                        <?php foreach ($repcom as $elem) { ;?>
                                            <li class="list-group-item d-flex align-items-center">
                                                <span class="badge badge-info badge-pill mr-3"><?= htmlspecialchars(give_username($elem['user_id'])); ?></span>
                                                <?= htmlspecialchars($elem['comments']); ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } if ($nbPage > 1) { ?>
                    <nav>
                        <ul class='pagination'>
                            <?php for ($i=1;$i<=$nbPage;$i++) { ?>
                                <li class="page-item"><a class="page-link" href="gallery.php?p=<?=htmlspecialchars($i);?>"><?= htmlspecialchars($i);?></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</main>

<?php include_once "include/footer.inc.php"; ?>