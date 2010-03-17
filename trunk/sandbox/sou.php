<?php

session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

include ("config/dbconfig.php");
include ("config/opendb.php");

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Resource-Person</title>";
include("html_include_2.php");


//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//          Alyssa Krauss and Chris Durr
//
//  Spring 2009
//
// updatesou.php - enter a title here for the page
//
// Revision History:  Created - 02/24/08
//
//****************************
?>

<div align="center">
  <h1>Update Statement of Understanding</h1>
</div>

<?php
$organization_id = $_POST["organization_id"];
$query = "SELECT        organization_name
                  FROM          organization
                   WHERE        organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Query Failed...could not retrieve organization information");

$array = mysql_fetch_assoc($result);
$result = $array['organization_name'];
print"Upload Statement of Understanding to " .$result;

print"<form enctype='multipart/form-data' action='./sou2.php' method='POST'>";
print"<input type='hidden' name='MAX_FILE_SIZE' value='16777000' >";
print"<input type=\"hidden\" name=\"id\" value=".$organization_id.">";

?>
Choose a file to upload: <br>
<input name="uploadedfile" type="file" id = "uploadedfile"/><br />
<br>
Choose a File Type: <br>
<select name="filetype">
       <option value="NULL"> </option>
       <option value="txt">.txt</option>
       <option value="doc">.doc</option>
       <option value="pdf">.pdf</option>
</select>
<div>
<input type="submit" value="Send">
</div>
</form>

<? include("html_include_3.php"); ?>