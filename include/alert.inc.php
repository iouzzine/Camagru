<?php if (!empty($_SESSION['errors'])) { ?>
    <div class="alert alert-danger" id="alert">
        <div class="close" onclick="closealert()"></div>
        <?php foreach($_SESSION['errors'] as $message) { ?>
            <span><?= htmlspecialchars($message) ?></span><br>
        <?php } ?>
    </div>
<?php } unset($_SESSION['errors']); ?>

<?php if (!empty($_SESSION['success'])) { ?>
    <div class="alert alert-success" id="alert">
        <div class="close" onclick="closealert()"></div>
        <?php foreach($_SESSION['success'] as $message) { ?>
            <span><?= htmlspecialchars($message) ?></span>
        <?php } ?>
    </div>
<?php } unset($_SESSION['success']); ?>
