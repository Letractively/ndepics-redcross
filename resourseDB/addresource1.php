<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addresource1.php - file to insert a resource into the disaster database
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
echo "<title>St. Joseph Red Cross - Add Resource</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Add Resource</h1>";

//This variable would be set by addorganization2.php
$addresfromorg = $_POST["addresfromorg"];

//If the variable is set, then this page was called by addorganization2.php
if($addresfromorg){
	//So pick up POSTed variables from addorganization2.php
	$organization_name = $_POST["organization_name"];
	$street_address = $_POST["street_address"];
	$mailing_address = $_POST["mailing_address"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];
	$county = $_POST["county"];
	$business_phone = $_POST["business_phone"];
	$business_phone2 = $_POST["business_phone2"];
	$business_fax = $_POST["business_fax"];
	$email = $_POST["email"];
	$website = $_POST["website"];
	$addtl_info = $_POST["addtl_info"];
	$unit = $_POST["unit"];
	$updated_by = $_POST["updated_by"];
}

?>
<br /><br />
<!-- Set up form to forward inputs to add resource2.php and format with table -->      
<form name='addresource' method='post' action='addresource2.php' align ='left'>
	<input type=hidden name=addtype value=resource>
	<table>
		<tr>
			<td> Type of Resource</td>
			<td><input name='resource_type' type='text' maxlength='30' align= 'left'> </td>
		</tr>
		<tr>
			<td>Description (maximum of 1000 characters)</td>
			<td> <textarea name='resource_description' rows=6 cols=40 align= 'left' valign='top'> </textarea></td>
		</tr>
		<tr>
			<td>Keyword(s)</td>
			<td> <input name='resource_keyword' type='text' maxlength='50' align= 'left'> </td>
		</tr>
	</table>
<input type=hidden name='form_valid' value='0'>
<?
//forward the sequence marker as a hidden inputs
print "<input type=hidden name='addresfromorg' value=\"".$addresfromorg."\">";
if($addresfromorg = '2'){
	//We need to keep these variables alive, forward as hidden inputs
	print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
	print "<input type=hidden name='street_address' value=\"".$street_address."\">";
	print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
	print "<input type=hidden name='city' value=\"".$city."\">";
	print "<input type=hidden name='state' value=\"".$state."\">";
	print "<input type=hidden name='zip' value=".$zip.">";
	print "<input type=hidden name='county' value=\"".$county."\">";
	print "<input type=hidden name='business_phone' value='".$business_phone."'>";
	print "<input type=hidden name='business_phone2' value='".$business_phone2."'>";
	print "<input type=hidden name='business_fax' value='".$business_fax."'>";
	print "<input type=hidden name='email' value=\"".$email."\">";
	print "<input type=hidden name='website' value=\"".$website."\">";
	print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
	print "<input type=hidden name='unit' value=\"".$unit."\">";
	print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
}
?>
<br />
<input type=reset value="Clear Form">
<input type=submit value="Continue">
</form>
<br />
<div align='center'>
	<form>
	<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
	</form>
</div>
<?
include("./config/closedb.php"); //close the database connection
include("html_include_3.php"); //close HTML tags
?>
