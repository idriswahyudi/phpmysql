<?php
session_start();
if( !isset($_SESSION["login"] ) ){
	header("Location:login/login.php");
}

require 'functions.php';


# Mengecek data berhasil ditambah atau tidak 
if (isset($_POST["submit"])  ) {
	if (newuser($_POST) > 0){
		echo "
		<script>
		alert('Data berhasil ditambahkan!');
		document.location.href ='index.php';
		</script>
		";
	} else {
		echo "
		<script>
		alert('data gagal ditambahkan!');
		document.location.href ='index.php';
		</script>
		";
	}
}
# update data by id
if (isset($_POST["update"])  ) {
	if (updateuser($_POST) > 0){
		echo "
		<script>
		alert('Data berhasil diubah!');
		document.location.href ='index.php';
		</script>
		";
	} else {
		echo "
		<script>
		alert('data gagal diubah!');
		document.location.href ='index.php';
		</script>
		";
	}
}
# Truncate table daftar_karyawan
if (isset($_POST["truncate"])  ) {
	if (truncated($_POST) < 0){
		echo "
		<script>
		alert('Data gagal ditambahkan!');
		document.location.href ='index.php';
		</script>
		";
	} else {
		echo "
		<script>
		alert('data berhasil ditambahkan!');
		document.location.href ='index.php';
		</script>
		";
	}
}
# Hapus berdasarkan id
if (isset($_POST["deleteid"])  ) {
	if (fdeleteid($_POST) > 0){
		echo "
		<script>
		alert('Data berhasil dihapus!');
		document.location.href ='index.php';
		</script>
		";
	} else {
		echo "
		<script>
		alert('data gagal dihapus!');
		document.location.href ='index.php';
		</script>
		";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Manage Employees</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/js/main.js" rel="stylesheet" />
</head>
<body>
<div class="container">
<div class="table-responsive">
<div class="table-wrapper">
	<div class="table-title">
		<div class="row">
			<div class="col-xs-6">
				<h2 class="color-text">Manage <b>Employees</b></h2>
			</div>
			<div class="col-xs-6">
				<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
				<a href="#deleteEmployeeModalAll" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash"></i> <span> Delete</span></a>
				<a href="login/logout.php" class="btn btn-danger" data-toggle="modal"><i class="fa fa-sign-out"></i> <span>Sign-Out</span></a>						
			</div>
		</div>
	</div>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th> 
<?php #Column id ?>
				</th>
				<th>Name</th>
				<th>Email</th>
				<th>Address</th>
				<th>Phone</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php $i= 1; ?>
		<?php while($rows=$result->fetch_assoc())  { ?>
		<tr>
		<td>
<!-- Pengulangan id berdasarkan $i bukan id pada database -->
		<?php echo $i; ?>
		</td>	
		<td><?php echo $rows['name'];?></td>
		<td><?php echo $rows['email'];?></td>
		<td><?php echo $rows['address'];?></td>
		<td><?php echo $rows['phone'];?></td>
		<td>	
		<a href="" class="edit" data-target="#editEmployeeModal<?php echo $rows['id']; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
		<a href="" class="delete" data-target="#deleteEmployeeModal<?php echo $rows['id']; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
		</td>
<!-- START Delete Modal HTML -->
<div id="deleteEmployeeModal<?php echo $rows['id']; ?>" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" method="post">
				<input type="hidden" name="id" value="<?= $rows["id"]; ?>">
					<div class="modal-header">						
						<h4 class="modal-title" id="deleteEmployeeModal<?php echo $rows['id']; ?>">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete employee with name :<b> <?= $rows['name'] ?></b> ? </p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<button type="submit" class="btn btn-success" name="deleteid">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!-- END Delete Modal HTML -->
<!-- START Edit Modal HTML -->
<div class="modal fade" id="editEmployeeModal<?= $rows['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">						
		<h4 class="modal-title" id="editEmployeeModal">Edit Employee</h4>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	</div>

<div class="modal-body">	
		<form action="" method="post">				
		<div class="form-group">
		<input type="hidden" name="id" value="<?= $rows["id"]; ?>">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" id="name" required value="<?= $rows['name'];  ?>">
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" class="form-control" id="email" required value="<?= $rows['email'];  ?>">
		</div>
		<div class="form-group">
			<label for="address">Address</label>
			<textarea class="form-control" name="address" id="address" required><?= $rows['address'];  ?></textarea>
		</div>
		<div class="form-group">
			<label for="phone">Phone</label>
			<input type="text" name="phone" class="form-control" id="phone" required value="<?= $rows['phone'];  ?>">
		</div>				
	</div>

	<div class="modal-footer">
	<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
		<button type="update" class="btn btn-success" name="update">Update</button>
	</div>
	</form>	
	<!-- END Edit Modal HTML -->

			</td>
		</tr>
		<?php $i++; ?>
		<?php }?> 
	</tbody>
</table>

<!-- Pagination -->

<div class="clearfix">
	<div class="hint-text">Showing <b><?= $jumlahData; ?></b> out of <b><?= $jumlahKeseluruhan; ?></b> entries</div>
	<ul class="pagination">
		<li class="page-item disabled"><a href="">Pages</a></li>
		<?php for($i=1; $i <= $jumlahHalaman; $i++) : ?>
			<?php if( $i == $halamanAktif) : ?>
				<li class="page-item active"><a href="?halaman=<?= $i; ?>" class="page-link" ><?= $i; ?></a></li>
					<?php else : ?>
						<li class="page-item"><a href="?halaman=<?= $i; ?>" class="page-link" ><?= $i; ?></a></li>
			<?php endif; ?>
			<?php endfor; ?>
		<li class="page-item"><a href="#" class="page-link">Next</a></li>
	</ul>
</div>
</div>
</div>        
</div>
	
	<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
<div class="modal-dialog">
	<div class="modal-content">
		<form action='' method='post'>
		<div class="modal-header">						
				<h4 class="modal-title">Add Employee</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">					
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" name="name" class="form-control" id="name" required>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control" id="email" required>
				</div>
				<div class="form-group">
					<label for="address">Address</label>
					<textarea class="form-control" name="address" id="address" required></textarea>
				</div>
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" name="phone" class="form-control" id="phone" required>
				</div>					
			</div>
			<div class="modal-footer">
			<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
				<button type="submit" class="btn btn-success" name="submit">Add</button>
			</div>
		</form>
	</div>
</div>
</div>
<!-- Delete ALL Modal HTML -->
<div id="deleteEmployeeModalAll" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" method="post">
					<div class="modal-header">						
						<h4 class="modal-title">Delete Employee</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete all Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<button type="submit" class="btn btn-success" name="truncate">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>




</body>
</html>