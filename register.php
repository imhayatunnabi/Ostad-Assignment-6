<?php
// Start session
session_start();

// Check if the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	if(empty($name) || empty($email) || empty($password)) {
		echo "Please fill in all fields.";
		exit;
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email format.";
		exit;
	}
	$target_dir = "uploads/";
	$target_file = $target_dir . uniqid() . basename($_FILES["profile_picture"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
	if($check === false) {
		echo "File is not an image.";
		exit;
	}
	if ($_FILES["profile_picture"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		exit;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    exit;
	}
	$current_time = date('YmdHis');
	$target_file = $target_dir . $current_time . "_" . uniqid() . "." . $imageFileType;
	if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
		echo "Sorry, there was an error uploading your file.";
		exit;
	}
	$data = array($name, $email, $target_file);
	$file = fopen('./uploads/users.csv', 'a');
	if(fputcsv($file, $data) === false) {
		echo "Error writing to file.";
		exit;
	}
	fclose($file);
	$_SESSION['name'] = $name;
	setcookie('name', $name, time() + (86400 * 30), "/");
	header('Location: ./success.php');
	exit;
}
?>