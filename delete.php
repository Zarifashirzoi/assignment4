<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the teacher ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM teachers WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$teacher) {
        die ('teacher doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM teachers WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the teacher!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    die ('No ID specified!');
}
?>

<?=headerSection('Delete teacher')?>

<div class="content delete">
	<h2>Delete teacher #<?=$teacher['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete teacher #<?=$teacher['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$teacher['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$teacher['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
    <a href="/" style="margin-top:15px; padding-top:10px;">Back</a>
</div>

<?=footerSection()?>