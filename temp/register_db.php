<?php
include_once("config.php");

if(isset($_POST["submit"]) && $_POST["password"] == $_POST["retpassword"]){
	$query = "INSERT INTO login (username, email, password) VALUES ('$_POST[username]', '$_POST[email]', '$_POST[password]')";

	// value insert in cv_info table
	$queryinfo = "INSERT INTO cv_info (email, birthday, gender, username) VALUES ('$_POST[email]', '$_POST[dob]', '$_POST[gender]', '$_POST[username]')";

	if(mysqli_query($conn, $query)){
		mysqli_query($conn, $queryinfo);

		header("Location:Login.php");
	}
	else{
		die('Error: ' . mysqli_error($conn));
	}
}
else{
	header("Location:Registration.php");
}

mysqli_close($conn);
?>