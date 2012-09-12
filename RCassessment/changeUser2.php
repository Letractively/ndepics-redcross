<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// changeUser2.php - This uses PHP to change another user's permission.
//************************************

include("./config/check_login.php");
// This is an admin tool, thus check if the current user is an admin.
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");

// These variables were obtained from changeUser.php
$selUser = $_POST["selUser"];
$selAuthority = $_POST["selAuthority"];

// This changes another user's permission
$query = "UPDATE users SET authority='$selAuthority' WHERE username='$selUser'";
$result = mysql_query($query) or die(mysql_error()); 

include("./config/close_database.php");

// This re-directs the user to the home page.
header('Location: ./home.php');

?>