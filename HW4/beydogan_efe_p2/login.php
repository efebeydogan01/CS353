<?php
include("config.php");

if (isset($_POST['submitButton'])) {
	// receive the name and the password
	$name = strtolower($_POST['customername']);
	$password = $_POST['password'];

	$loginQuery = "SELECT * FROM customer WHERE LOWER(name)='$name' and cid='$password'";

	$execute = $con->query($loginQuery) or die('Error in query: ' . $con->error);


	if ( $execute->num_rows == 1) {
		session_start();
		// set session variables
		$_SESSION['name'] = $name;
		$_SESSION['cid'] = $password;
		header("location: welcome.php");
	}
	else {
		echo "<script>
				alert('Invalid username or password!');
				window.location.href='index.php';
			</script>";
	}
}
