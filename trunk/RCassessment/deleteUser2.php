<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// deleteUser2.php - This uses PHP to delete a user.
//************************************

include("./config/check_login.php");
// This is an admin tool, thus check if the current user is an admin.
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");

// This deletes the user from the database.
$delUser = $_POST["delUser"];
$query = "DELETE from users WHERE username='$delUser'";
$result = mysql_query($query) or die(mysql_error());

// Re-directs to the home page.
header( 'Location: ./home.php' );

include("./config/close_database.php");

?>