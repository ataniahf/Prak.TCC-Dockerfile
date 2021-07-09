<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_pgdb("host.docker.internal","phpcrudadmin","postgres","postgres");
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM admin');
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM admin')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Dashboard Admin</h2>
	
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Username</td>
                <td>Nama Lengkap</td>
                <td>No. Telp</td>
                <td>Email</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['id_admin']?></td>
                <td><?=$contact['username']?></td>
                <td><?=$contact['nama_lengkap']?></td>
                <td><?=$contact['no_hp']?></td>
                <td><?=$contact['email']?></td>
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>