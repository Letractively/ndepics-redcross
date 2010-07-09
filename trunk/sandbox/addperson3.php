<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addperson3.php - file to insert a pserson into the disaster database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){ //ensure user has "add" rights
	header( 'Location: ./index.php' ); //redirect if not authorized
}  
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Person Added</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Add Person</h1>";

//Pick up POSTed variables from addperson2.php
$salutation = $_POST["salutation"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$home_phone = $_POST["home_phone"];
$work_phone = $_POST["work_phone"];
$mobile_phone = $_POST["mobile_phone"];
$fax = $_POST["fax"];
$email = $_POST["email"];
$im = $_POST["im"];
$updated_by = $_POST["updated_by"];
$info = $_POST["info"];
//organization related variables for link
$organization_id = $_POST["organization_id"];
$title_in_organization = $_POST["title_in_organization"];
$role_in_organization = $_POST["role_in_organization"];

// Scrub the inputs, see functions.php for more information
$salutation = scrub_input($salutation);
$first_name = scrub_input($first_name);
$last_name = scrub_input($last_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$email = scrub_input($email);
$im = scrub_input($im);
$info = scrub_input($info);
$title_in_organization = scrub_input($title_in_organization);
$role_in_organization = scrub_input($role_in_organization);

//Query to check if person already exists (based on first name, last name combination)
$pers_query = "SELECT * FROM person WHERE first_name = '".$first_name." ' AND last_name= '".$last_name."'";
$result3 = mysql_query($pers_query) or die ("Error checking if person exists query");
$num_rows = mysql_num_rows($result3);
if ($num_rows != 0) { //if person already exists in the database 
       print "<div align='center'><br />";
       print "Cannot Add Person: \"<b>".$first_name." ".$last_name."</b>\" already exists <br /><br />";
       print "<form action=\"./home.php\" >\n";
       print "<button type=\"submit\">Return Home</button>";
       print "</form>\n";
       print "</div>";
       exit(-1);
}

// Get the next auto_increment value (person id)
// This is just a peek, not an insertion that will increment the value
// We do this so we can redirect to the person information page by setting the GET variable in the URL
$query = "SHOW TABLE STATUS LIKE 'person'";
$result = mysql_query($query) or die ("Error sending table status query");
$row = mysql_fetch_assoc($result);
$person_id = $row['Auto_increment'];

//Query to insert person into database
$tempdate = date("m/d/Y H:i");
$query = "INSERT INTO  person (salutation ,
			       first_name ,
			       last_name ,
			       street_address ,
			       city ,
			       state ,
			       zip ,
			       home_phone ,
			       work_phone ,
                   mobile_phone ,
			       fax ,
			       email ,
			       im, 
                   additional_info,
                   updated_by ,
				   updated_time ,
                   log )
		 VALUES (\"".$salutation."\",
                         \"".$first_name."\",
                         \"".$last_name."\",
                         \"".$street_address."\",
                         \"".$city."\",
                         \"".$state."\",
                         \"".$zip."\",
                         \"".$home_phone."\",
                         \"".$work_phone."\",
                         \"".$mobile_phone."\",
                         \"".$fax."\",
                         \"".$email."\",
                         \"".$im."\",
                         \"".$info."\",
                         \"".$updated_by."\",
						 NOW(),
                         \"".$tempdate.": ".$updated_by." authenticated as ".$_SESSION['username']."\n".$row['log']."\")";
$result = mysql_query($query) or die ("Error adding Person");

$redirect_url = "./personinfo.php?id=".$person_id; //set redirect_url by inserting person_id into GET field
$message .= "Successful Add...redirecting<br />";
print "<br />Successfull Add...redirecting to information page"; //Print friendly message to user

// Query to associate newly added person to selected organization
if($organization_id != "NULL") {
	$query = "INSERT INTO works_for (person_id, organization_id, title, role) 
			  VALUES (".$person_id.",".$organization_id.",\"".$title_in_organization."\",\"".$role_in_organization."\")";	  
	$result = mysql_query($query) or die ("Error adding works_for");
}

//Redirect to the person information page
print "<meta http-equiv=\"Refresh\" content=\"1.5; url=".$redirect_url."\">";

include ("config/closedb.php"); //close connection to the databse
include("./html_include_3.php"); //close existing HTML tags
?>

