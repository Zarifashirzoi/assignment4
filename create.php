<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {

    $id = NULL;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';

    // Add new record into the teachers table
    $stmt = $pdo->prepare('INSERT INTO teachers VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $last_name, $email, $department]);

    // message
    $message = 'Data Successfully created';
}
?>

<?=headerSection('Create')?>

<div class="content update">
	<h2>Create Teacher</h2>
    <form action="create.php" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" required placeholder="Zarifa" id="name">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" required placeholder="Sherzoi" id="last_name">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="zarifasherzoi@gmail.com" id="email">
        <label for="department">Department</label>
        <input type="text" name="department" required placeholder="Department" id="department">
        
        <label for=""></label>
        <input type="submit" value="Save">
        <a href="/" style="margin-top:15px; padding-top:10px;">Back</a>
    </form>

    <?php 
    if ($message){
        echo "<p>$message</p>";
    }
    ?>
</div>

<?=footerSection()?>