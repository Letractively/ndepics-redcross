<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2010 - Matt Mooney
// shelter.php - This page is used to view/update additional shelter information
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");
include("./html_include_1.php");
echo "<title>St. Joseph Red Cross - Shelter Information</title>";
include("./html_include_2.php");

$organization_id = $_POST["organization_id"];

$query = "SELECT	organization_name
          FROM		organization
          WHERE		organization_id = ".$organization_id;
$org = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
$row = mysql_fetch_assoc($org);
$org = $row['organization_name'];

$querysi = "SELECT * FROM shelter_info WHERE organization_id = ".$organization_id;
$resultsi = mysql_query($querysi) or die ("Wuery Failed...could not retreive shelter_info information");
$rowsi = mysql_fetch_assoc($resultsi);

?>
<div align="center">
	<h2>Update Shelter Information</h2>
    <i>Note that this page should only be used for shelters.</i><hr>
</div>
<?
if($rowsi['organization_id'] != ""){
	print "Shelter Information for $org";
	$month = substr($rowsi['nat_entry_date'],5,2);
	$day = substr($rowsi['nat_entry_date'],8,2);
	$year = substr($rowsi['nat_entry_date'],0,4);
	?>
    <form action="./shelter2.php" method="post">
   	<table>
    	<tr>
        	<td>Size (Sq. Ft.)</td>
            <td><input name="size" type="text" maxlength="10" size="10" align="left" value="<? echo $rowsi['size']; ?>" /></td>
        </tr>
            	<tr>
        	<td>Capacity</td>
            <td><input name="capacity" type="text" maxlength="10" size="10" align="left" value="<? echo $rowsi['capacity']; ?>" /></td>
        </tr>
        <tr>
        	<td>Entered into National DB on: (mm-dd-yyyy) </td>
            <td><input name="month" type="text" maxlength="2" size="4" align="left" value="<? echo $month; ?>" />&nbsp;&ndash;&nbsp; 
            <input name="day" type="text" maxlength="2" size="4" align="left" value="<? echo $day; ?>" />&nbsp;&ndash;&nbsp; 
            <input name="year" type="text" maxlength="4" size="8" align="left" value="<? echo $year; ?>" />
            </td>
        </tr>
        <tr>
        	<input type="hidden" name="org_id" value="<? echo $organization_id; ?>" />
            <input type="hidden" name="type" value="update" />
        	<td></td>
            <td><input type="submit" value="Add Info"/><td>
        </tr>
    </table>
    </form>
	<?	
} //end if row exists
else {
	print "No Shelter Information.<br>Fill out form to create new record.<br>";
	?>
    <form action="./shelter2.php" method="post">
   	<table>
    	<tr>
        	<td>Size (Sq. Ft.)</td>
            <td><input name="size" type="text" maxlength="10" size="10" align="left" /></td>
        </tr>
            	<tr>
        	<td>Capacity</td>
            <td><input name="capacity" type="text" maxlength="10" size="10" align="left" /></td>
        </tr>
        <tr>
        	<td>Entered into National DB on: (mm-dd-yyyy) </td>
            <td><input name="month" type="text" maxlength="2" size="2" align="left" />&nbsp;&ndash;&nbsp; 
            <input name="day" type="text" maxlength="2" size="2" align="left" />&nbsp;&ndash;&nbsp; 
            <input name="year" type="text" maxlength="4" size="4" align="left" />
            </td>
        </tr>
        <tr>
        	<input type="hidden" name="org_id" value="<? echo $organization_id; ?>" />
            <input type="hidden" name="type" value="new" />
        	<td></td>
            <td><input type="submit" value="Add Info"/><td>
        </tr>
    </table>
    </form>
    <?	
} //end else NULL row exists
		

include("./config/closedb.php");
include("./html_include_3.php");
?>

