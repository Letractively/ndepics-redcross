<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");

$organization_id = $_POST["organization_id"];
$queryid = "SELECT filename,filetype,filesize,uploaded_report FROM facility_survey WHERE organization_id = ".$organization_id;
$result = mysql_query($queryid);
list($name, $type, $size, $uploaded_contract) =                                  mysql_fetch_array($result);

if($name != NULL)
{
  header("Content-length: $size");
  header("Content-type: $type");
  header("Content-Disposition: attachment; filename=$name");
 echo $uploaded_contract;
}
else
{
  print "No facility survey uploaded.\n";

  print "<input type=\"BUTTON\" VALUE=\"Home\" ONCLICK=\"window.location.href='./home.php'\">";
}

include 'library/closedb.php';
exit;
?>