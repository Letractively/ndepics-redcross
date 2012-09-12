<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// login.php - This validates a user and then sets all the session variables to relevant strings.
//************************************

// This starts or resumes the PHP session.
session_start();

// To delete the old session and regenerate id for the new session.
session_regenerate_id(true);

include("./config/functions.php");
include("./config/open_database_imp.php");

// These values are obtained from index.php
$username = $_POST['username'];

// This uses MySQLi to protect against SQL injections to obtain the salt.
if($stmt1 = mysqli_prepare($db_connection,"SELECT salt FROM users WHERE username = ?")){
	
	mysqli_stmt_bind_param($stmt1, "s", $username);
	
	mysqli_stmt_execute($stmt1);
	
	mysqli_stmt_bind_result($stmt1, $result_salt);
	
	mysqli_stmt_fetch($stmt1);
	
	mysqli_stmt_close($stmt1);
}

$password = $_POST['password'];

// The crypto hash function being used is found in functions.php
$password = hashPassword($password, $result_salt);

// This uses MySQLi to protect against SQL injections to obtain the user information.
if($stmt2 = mysqli_prepare($db_connection,"SELECT entry_id, username, authority FROM users WHERE username = ? AND password = ?")){
	
	mysqli_stmt_bind_param($stmt2, "ss", $username, $password);
	
	mysqli_stmt_execute($stmt2);
	
	mysqli_stmt_bind_result($stmt2, $result_entry_id, $result_username, $result_authority);
	
	mysqli_stmt_fetch($stmt2);
	
	mysqli_stmt_close($stmt2);
}

// If the user is found in the database.
if($result_entry_id != NULL){
	$_SESSION["valid"] = "valid";
	$_SESSION["username"] = $result_username;
	$_SESSION["authority"] = $result_authority;
	header("Location: ./home.php");
}
// The user is not found in the database. Deny them an username and authority.
else{
	$_SESSION["valid"] = "invalid";
	$_SESSION["username"] = "";
	$_SESSION["authority"] = "";
	header("Location: ./index.php");
}

include("./config/close_database_imp.php");

?>