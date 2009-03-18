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
$queryid = "SELECT filename,filetype,filesize,uploaded_contract FROM statement_of_understanding WHERE organization_id = ".$organization_id;
$result = mysql_query($queryid) or die ("Query Failed...could not retrieve organization information1");
list($name, $type, $size, $uploaded_contract) =                                  mysql_fetch_array($result);

header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $uploaded_contract;

include 'library/closedb.php';
exit;
?>