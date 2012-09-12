<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2012 - Henry Kim
// modifychapters.php - file to insert an organization into the disaster database
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
echo "<title>St. Joseph Red Cross - Modify A Chapter</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Current Chapters</h1><br />";

//Pick up POSTed variables from addperson.php if on re-direct
$chapter_name_add = $_POST["chapter_name_add"];
$chapter_name_remove = $_POST["chapter_name_remove"];

$chapters_data = mysql_query("SELECT * FROM chapters") or die("Error: Getting Chapters");
$count = -5;
print "<table border='1'>";
print "<tr>";
while($chapters = mysql_fetch_array($chapters_data)){
	$count = $count + 1;
	if($count % 4 == 0 and $count >= 0){
		print "</tr><tr>";
	}
	print "<td>".$chapters[chapter_name]."</td>";
}
print "</tr>";
print "</table>";
print "<br /><br />";

echo "<h1>Modify A Chapter</h1>";		
?>
<br />
<form name='modifyChapter' method='post' action='./modifychapters2.php' align ='left'>
	<table>
		<tr>
			<td>Add A Chapter: </td>
			<td><input name='chapter_name_add' type='text' size='10' maxlength='255' align= 'left'></td>
		</tr>
		<tr>
			<td>Remove A Chapter: </td>
			<td><input name='chapter_name_remove' type='text' size='10' maxlength='255' align='left'></td>
		</tr>
	</table>
	<br />
	
	<input type=reset value="Clear Form">
	<input type=submit value="Continue">
</form>
<br />
<form style="display: inline" action="home.php">
    <input type="submit" value="Back" />
</form>

<?php
include ("config/closedb.php");
include("html_include_3.php");
?>