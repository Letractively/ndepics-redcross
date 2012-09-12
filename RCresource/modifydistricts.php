<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2012 - Henry Kim
// modifydistricts.php - file to insert an organization into the disaster database
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
echo "<title>St. Joseph Red Cross - Modifying A District</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Current Districts</h1><br />";

//Pick up POSTed variables from addperson.php if on re-direct
$district_name_add = $_POST["district_name_add"];
$district_name_remove = $_POST["district_name_remove"];

$districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");
$count = -5;
print "<table border='1'>";
print "<tr>";
while($districts = mysql_fetch_array($districts_data)){
	$count = $count + 1;
	if($count % 4 == 0 and $count >= 0){
		print "</tr><tr>";
	}
	print "<td>".$districts[district_name]."</td>";
}
print "</tr>";
print "</table>";
print "<br /><br />";

echo "<h1>Modify A District</h1>";
?>
<br />
<form name='modifyDistrict' method='post' action='./modifydistricts2.php' align ='left'>
	<table>
		<tr>
			<td>Add A District: </td>
			<td><input name='district_name_add' type='text' size='10' maxlength='255' align= 'left'></td>
		</tr>
		<tr>
			<td>Remove A District: </td>
			<td><input name='district_name_remove' type='text' size='10' maxlength='255' align='left'></td>
		</tr>
	</table>
	<br />
	
	<input type=reset value="Clear Form">
	<input type=submit value="Continue">
</form>
<form style="display: inline" action="home.php">
    <input type="submit" value="Back" />
</form>
<?php
include ("config/closedb.php");
include("html_include_3.php");
?>