<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// login.php - Authenticate users and set session variables
//****************************
session_start(); //resume active session
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Login</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//SITE SECURITY RESTS ON THESE LINES
//Get the username and password from index.php
$username = $_POST['username'];
$password = $_POST['password'];
$username = scrub_input($username);
$password = scrub_input($password);

//submit info to database
$message = "Username: ".$username."  Password: ".$password."<br>";
$query = "SELECT	user_id, access_level_id
		  FROM		users
		  WHERE		username = \"".$username."\" 
		  AND		passwd = \"".md5($password)."\""; //MD5 the password to check against encrypted value in table
$result = mysql_query($query) or die ("Unable to access username/password query");
$row = mysql_fetch_assoc($result);

if($row > 1) { //Username and Password match
	$message .= "Successful login...setting Session Variables<br>";
	$_SESSION['valid'] = "valid"; //validate session
	$_SESSION['user_id'] = $row['user_id']; //save user id
	$_SESSION['access_level_id'] = $row['access_level_id']; //set access level
	$_SESSION['username'] = $username; //save username
	$redirect_url = "./home.php"; //direct to the homepage
	$message .= "Success";
	
	$query2 = "SELECT * FROM SoU_Last_Checked WHERE entry_id = '1'";
	$result2 = mysql_query($query2) or die ("Unable to determine SoU last checked date");
	$lastChecked = mysql_fetch_array($result2);
	$lastCheckedUnixTime = strtotime($lastChecked["dateChecked"]);
	$sevenDaysInSeconds = 604800;
	
	$todayDate = date("Y-m-d");
	$todayUnixTime = strtotime($todayDate);

	if( ($lastCheckedUnixTime + $sevenDaysInSeconds) < $todayUnixTime){
		$query3 = "UPDATE SoU_Last_Checked SET dateChecked='$todayDate' WHERE entry_id = '1'";
		$result3 = mysql_query($query3) or die("Unable to update SoU last checked date");
		include("./emailSOUExpiration.php");
	}
	
    print "<meta http-equiv=\"Refresh\" content=\"0; url=".$redirect_url."\">"; //redirect
}
else { //Username and Password do NOT match
	$_SESSION['valid'] = "invalid"; //invalidate session
	$redirect_url = "./index.php"; //direct to index for re-try
	$message .= "Invalid Login<br>";
    print "<h3>Invalid credentials.<br>Redirecting...</h3>";
    print "<meta http-equiv=\"Refresh\" content=\"1.0; url=".$redirect_url."\">"; //redirect
}
mysql_free_result($result);

include("./config/closedb.php"); //close database connection
include("./html_include_3.php"); //close HTML tags
?>