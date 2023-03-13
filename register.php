<?php
// Start session
session_start();

// Check if the form is submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Validate form inputs
	if(empty($name) || empty($email) || empty($password)) {
		echo "Please fill in all fields.";
		exit;
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "Invalid email format.";
		exit;
	}

	// Handle file upload
	$target_dir = "uploads/";
	$target_file = $target_dir . uniqid() . basename($_FILES["profile_picture"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	$check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
	if($check === false) {
		echo "File is not an image.";
		exit;
	}

	// Check file size
	if ($_FILES["profile_picture"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		exit;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    exit;
	}

	// Rename file with current date and time
	$current_time = date('YmdHis');
	$target_file = $target_dir . $current_time . "_" . uniqid() . "." . $imageFileType;

	// Save file to server
	if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
		echo "Sorry, there was an error uploading your file.";
		exit;
	}

	// Save user data to CSV file
	$data = array($name, $email, $target_file);
	$file = fopen('users.csv', 'a');
	if(fputcsv($file, $data) === false) {
		echo "Error writing to file.";
		exit;
	}
	fclose($file);

	// Set session and cookie
	$_SESSION['name'] = $name;
	setcookie('name', $name, time() + (86400 * 30), "/");

	// Redirect to success page
	header('Location: ./success.php');
	exit;
}
?>