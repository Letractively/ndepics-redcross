<?php
session_start();

//****************************
//  Developed by ND Epics for St. Joe County RedCross // Authors: Mike Ellerhorst & Mark Pasquier//  Fall 2008// login.php - checks the login information and redirects based on success or not.//****************************
include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Log In</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");
$username = stripslashes($_POST['username']);
$password = stripslashes($_POST['password']);
$username = scrub_input($username);
$password = scrub_input($password);
$message = "Username: ".$username."  Password: ".$password."<br>";
$query = "SELECT	user_id, access_level_id
		  FROM		users
		  WHERE		username = \"".$username."\"
		  AND		passwd = \"".md5($password)."\"";		  
//print "Query: ".$query."<br>";	  
$result = mysql_query($query) or die ("Unable to access username/password query");
$row = mysql_fetch_assoc($result);
if($row > 1) {
	$message .= "Successful login...setting Session Variables<br>";
	print "<h3>Successful login, setting your session variables...<br>";
	$_SESSION['valid'] = "valid";
	$_SESSION['user_id'] = $row['user_id'];
	$_SESSION['access_level_id'] = $row['access_level_id'];
	$_SESSION['username'] = $username;
	$redirect_url = "./home.php";
	$message .= "Success";
    print "Redirecting...</h3>";
    print "<meta http-equiv=\"Refresh\" content=\"2.5; url=".$redirect_url."\">";
}
else {
	$_SESSION['valid'] = "invalid";
	$redirect_url = "./index.php";
	$message .= "Invalid Login<br>";
    print "<h3>Invalid credentials.<br>Redirecting...</h3>";
    print "<meta http-equiv=\"Refresh\" content=\"1.0; url=".$redirect_url."\">";
}
mysql_free_result($result);
include ("./config/closedb.php");
include("html_include_3.php"); ?>