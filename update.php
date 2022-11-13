<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$message = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $department = isset($_POST['department']) ? $_POST['department'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE teachers SET first_name = ?, last_name = ?, email = ?, department = ? WHERE id = ?');
        $stmt->execute([$first_name, $last_name, $email, $department, $_GET['id']]);
       // $stmt->execute([$id, $first_name, $last_name, $email, $department]);

        //var_dump($stmt);die;
        $message = 'Updated Successfully!';
        
    }
    // Get the teacher from the teachers table
    $stmt = $pdo->prepare('SELECT * FROM teachers WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$teacher) {
        die ('Teacher doesn\'t exist with that ID!');
    }
} else {
    die ('No ID specified!');
}
?>

<?=headerSection('Update teacher')?>

<div class="content update">
	<h2>Update Teacher #<?=$teacher['id']?></h2>
    <form action="update.php?id=<?=$teacher['id']?>" method="post">
        <label for="name">Name</label>
        <input type="text" name="id" style="display: none;" placeholder="1" value="<?=$teacher['id']?>" id="id">
        <input type="text" name="first_name" required placeholder="Zarifa" value="<?=$teacher['first_name']?>" id="name">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" required placeholder="zarifasherzoi@gmail.com" value="<?=$teacher['last_name']?>" id="last_name">

        <label for="email">Email</label>
        <input type="email" name="email" required placeholder="zarifasherzoi@gmail.com" value="<?=$teacher['email']?>" id="email">
        <label for="department">Department</label>
        <input type="text" name="department" required placeholder="Employee" value="<?=$teacher['department']?>" id="department">
        <label for=""></label>
        <input type="submit" value="Update">
        <a href="/" style="margin-top:15px; padding-top:10px;">Back</a>
    </form>
    <?php 
    if ($message){
        echo "<p>$message</p>";
    }
    ?>
</div>

<?=footerSection()?>