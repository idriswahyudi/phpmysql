<?php

# Mendeskripsikan data untuk login phpmyadmin
$user = 'root';
$password = '';
$database = 'employees';
$servername='localhost:3306';

$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// Mengecek koneksi apakah data sudah benar

if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

# Query data yang ada pada database

$sql = " SELECT * FROM daftar_karyawan";
$result = $mysqli->query($sql);


# truncate database
function truncated($data){
	global $mysqli;
	$sql ="TRUNCATE TABLE daftar_karyawan";

	mysqli_query($mysqli, $sql);
	return mysqli_affected_rows($mysqli);
	
}


# Tambah karyawan baru

function newuser($data){
	global $mysqli;

	$name = htmlspecialchars($data["name"]);
	$email = htmlspecialchars($data["email"]);
	$address = htmlspecialchars($data["address"]);
	$phone = htmlspecialchars($data["phone"]);

	$sql ="INSERT INTO daftar_karyawan
				VALUES 
				('$name','$email','$address','$phone','')
				";
mysqli_query($mysqli, $sql);
return mysqli_affected_rows($mysqli);
}


# Ubah data berdasarkan id
function updateuser($data){
	global $mysqli;
	
	$name = htmlspecialchars($data["name"]);
	$email = htmlspecialchars($data["email"]);
	$address = htmlspecialchars($data["address"]);
	$phone = htmlspecialchars($data["phone"]);
	$id = $data["id"];

	$sql ="UPDATE daftar_karyawan SET
				name = '$name',
				email = '$email',
				address = '$email',
				phone = '$phone' WHERE id = $id ";
mysqli_query($mysqli, $sql);	
return mysqli_affected_rows($mysqli);
}

# Hapus data by id
function fdeleteid($data){
	global $mysqli;

	$id = $data["id"];

	$sql  = "DELETE FROM daftar_karyawan WHERE id=$id";
	mysqli_query($mysqli, $sql);
	return mysqli_affected_rows($mysqli);
}

function registrasi($data){
	global $mysqli;
	
	$username =strtolower(stripslashes($data["username"]));
	$email =strtolower(stripslashes($data["email"]));
	$password = mysqli_real_escape_string($mysqli, $data["password"]);

	// cek email sudah ada atau belum
	$result = mysqli_query($mysqli, "SELECT email FROM userlogin WHERE email='$email'");

	if ( mysqli_fetch_assoc($result) ){
		echo"
		<script>
		alert('email sudah ada!');
		</script>
		";
		return false;
	}
	// enkripsi password 
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambah user ke database
	$sql =" INSERT INTO userlogin VALUES('','$username','$email', '$password')";
	mysqli_query($mysqli, $sql);

	return mysqli_affected_rows($mysqli);
}


?>