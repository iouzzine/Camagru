<?php

session_start();

include_once 'config/database.php';
include_once 'include/functions.php';

logged_only();

include_once 'include/header.inc.php';
?>

<main>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7">
                <div class="text-center">
                    <div id="webcam-filter">
                        <video id="video" class="w-100"></video>
                        <div class="strike mt-4 mb-4" id="strike">
                            <span>OR</span>
                        </div>
                        <div class="input-group" id="inputg">
                            <div class="custom-file" id="customfile">
                                <input type="file" class="custom-file-input" accept=".png, .jpg" id="imageloader" name="imageloader">
                                <label class="custom-file-label" for="" id="labelcfile">Choose file</label>
                            </div>
                        </div>
                        <img id="imageshow" class="w-100">
                        <img id="filterimg" hidden>
                    </div>
                    <form id="submitf" action="include/webcam.inc.php" method="post" class="form-group">
                        <label for=""><input type="hidden" id="picurl" name="picurl" />
                            <input type="hidden" id="emox" name="emox" />
                            <input type="hidden" id="emoy" name="emoy" />
                        </label>
                        <div class="form-group">
                            <label for="photo-filter">
                                <select name="selectf" id="photo-filter" class="form-control" onchange="enableButton()">
                                    <option value="none" selected>NONE</option>
                                    <option value="banana">BANANA</option>
                                    <option value="emo1">EMOTICONE 1</option>
                                    <option value="emo2">EMOTICONE 2</option>
                                    <option value="emo3">EMOTICONE 3</option>
                                    <option value="twitter">TWITTER</option>
                                    <option value="whatsapp">WHATSAPP</option>
                                </select>
                            </label>
                        </div>
                    </form>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="startbutton" disabled onclick="takepicture()">Take picture</button>
                    </div>
                </div>
            </div>
            <div class="col-md-5 overflow-y">
                <canvas id="canvas" class="w-75" style="display: none;"></canvas>
                <?php
                    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $req = $pdo->prepare("SELECT id,picurl FROM pictures WHERE id_user = ? ORDER BY take_at DESC ");
                    $req->execute([$_SESSION['auth']['id']]);
                    while ($urlpic = $req->fetch(PDO::FETCH_ASSOC)){
                        $picture = $urlpic['picurl'];
                        $id = $urlpic['id'];
                        echo '
                                <img class="w-100 mb-2" src="'.$picture.'" />
                                <form action="include/delete.inc.php" method="post">
                                    <input type="hidden" name="picid" value="'.$id.'">
                                    <button class="btn btn-primary btn-block mb-2">Delete this picture</button>
                                </form>
                              ';
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="js/webcam.js"></script>

</main>

<?php include_once "include/footer.inc.php"; ?>
