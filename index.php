<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

// Prepare the SQL statement and get records from our teachers table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM teachers ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of teachers, this is so we can determine whether there should be a next and previous button
$num_teachers = $pdo->query('SELECT COUNT(*) FROM teachers')->fetchColumn();
?>

<?=headerSection('Teacher list')?>

<div class="content read">
	<h2>Teachers List</h2>
	<a href="create.php" class="create-teacher">Create teacher</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Department</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teachers as $teacher): ?>
            <tr>
                <td><?=$teacher['id']?></td>
                <td><?=$teacher['first_name']?></td>
                <td><?=$teacher['last_name']?></td>
                <td><?=$teacher['email']?></td>
                <td><?=$teacher['department']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$teacher['id']?>" class="edit">Edit</a>
                    <a href="delete.php?id=<?=$teacher['id']?>" class="trash">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>">Previous Page</a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_teachers): ?>
		<a href="read.php?page=<?=$page+1?>">Next Page</a>
		<?php endif; ?>
	</div>
</div>

<?=footerSection()?>