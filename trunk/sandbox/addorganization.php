<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
}  

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addorganization.php - file to insert an organization into the disaster database;
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Add Organization</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<STYLE type="text/css">
 SPAN { padding-left:3px; padding-right:3px }
 DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
 BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
</STYLE>

</head>

<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph\'s County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>


<div align="center">
  <h1>Add Organization</h1>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>


<?php

//print"<center><b>WARNING: PHP ERROR REPORTING IS ACTIVE FOR DEVELOPMENT!</b></center>";
//error_reporting(E_ALL);
//ini_set ('display_errors', '1');

$form_filled = $_POST["form_filled"];
$form_valid = $_POST["form_valid"];
$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$bus_phone = $_POST["bus_phone_1"].$_POST["bus_phone_2"].$_POST["bus_phone_3"];
$fax = $_POST["bus_fax_1"].$_POST["bus_fax_2"].$_POST["bus_fax_3"];
$email = $_POST["email"];
$website = $_POST["website"];


// Scrub the inputs
$organization_name = scrub_input($organization_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$zip = scrub_input($zip);
$county = scrub_input($county);
$bus_phone = scrub_input($bus_phone);
$fax = scrub_input($fax);
$email = scrub_input($email);
$website = scrub_input($website);

// Display them for the user to verify
//Change to pre-populated tables... notify user of errors. Re-direct back to this page if errors exist?


if(!$form_filled)
{
  ?>

<br><br>	 
<form name='addorganization' method='post' action='addorganization.php' align ='left'>
	<input type=hidden name=addtype value=organization>
	<table>
		<tr>
			<td>Organization Name</td>
			<td><input name='organization_name' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Street Address</td>
			<td><input name='street_address' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>City</td>
			<td><input name='city' type='text' maxlength='30' align= 'left'> </td>
		</tr>

		<tr>
			<td>State</td>
			<td><input name='state' type='text' size='2' maxlength='2' align= 'left'> </td>
		</tr>

		<tr>
			<td>Zip</td>
			<td><input name='zip' type='text' size='10' maxlength='10' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>County</td>
			<td><input name='county' type='text' maxlength='20' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Business Phone</td>
			<td>(<input name='bus_phone_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='bus_phone_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='bus_phone_3' type='number' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Business Fax</td>
			<td>(<input name='bus_fax_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='bus_fax_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='bus_fax_3' type='number' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Email</td>
			<td> <input name='email' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Website</td>
			<td> <input name='website' type='text' maxlength='100' align= 'left'> </td>
		</tr>
		
	</table>

	<br>
        <input type=hidden name='form_valid' value='0'>
        <input type=hidden name='form_filled' value='1'>
	<input type=submit value="Continue">
	<input type=reset value="Clear Form">

</form>

<br>
<div align='center'>
<form>
	<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
<br>
<?
   }
else
{
$errCount=0;
 validator("Organization Name",$organization_name,"string");
 validator("Street Address", $street_address, "string","1","100","0");
 validator("City",$city,"alpha_space");
 validator("County",$county,"string","1","50","0");
 validator("State",$state,"alpha","2","2");
 validator("Zip",$zip,"number","5","5");
 validator("Bus Phone",$bus_phone,"number","10","10","1");
 validator("Business Fax",$fax,"number","10","10","0");
 validator("Email",$email,"email","1","100","0");
 validator("Website",$website,"alphanumeric","4","30","0");
 if(!$messages[0])
   {
     $form_valid = 1;
   }
 $messages=array();
 if($form_valid == 1)
   { 
     print "<form name='verifyperson' method='post' action='./addorganization2.php' align='left'>";
     print "<p align='center'><b>Please verify this information.</b></p>";
   }
 else 
   {
     print "<form name='verifyorganization' method='post' action='./addorganization.php' align='left'>";
     print "<p align='center'><b>Please make necessary corrections</b></p>";
   }

 print "<table>";
 //Salutation
 validator("Organization Name",$organization_name,"string");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Organization Name: </b></td>\n";
  print "<td><input name='salutation' type='text' size='50' maxlength='50' align= 'left' value='".$organization_name."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
  print"<tr>\n";
  print"<td><b>Organization Name: </b></td>\n";
  print"<td>".$organization_name."</td>\n";
  print"</tr>\n";
}

//Fisrt Name
validator("Street Address", $street_address, "string","1","100","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Street Address: </b></td>\n";
  print "<td><input name='street_address' type='text' maxlength='50' align= 'left' value='".$street_address."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='street_address' value=\"".$street_address."\">";
  print"<tr>\n";
  print"<td><b>Street Address: </b></td>\n";
  print"<td>".$street_address."</td>\n";
  print"</tr>\n";
}


//City
validator("City",$city,"alpha_space");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>City: </b></td>\n";
  print "<td><input name='city' type='text' size='30' maxlength='30' align= 'left' value='".$city."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='city' value=\"".$city."\">";
  print"<tr>\n";
  print"<td><b>City: </b></td>\n";
  print"<td>".$city."</td>\n";
  print"</tr>\n";
}

//County
validator("County",$county,"string","1","50","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>County: </b></td>\n";
  print "<td><input name='county' type='text' size='20' maxlength='20' align= 'left' value='".$county."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='county' value=\"".$county."\">";
  print"<tr>\n";
  print"<td><b>County: </b></td>\n";
  print"<td>".$county."</td>\n";
  print"</tr>\n";
}

//State
validator("State",$state,"alpha","2","2");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>State: </b></td>\n";
  print "<td><input name='state' type='text' size='2' maxlength='2' align= 'left' value='".$state."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='state' value=\"".$state."\">";
  print"<tr>\n";
  print"<td><b>State: </b></td>\n";
  print"<td>".$state."</td>\n";
  print"</tr>\n";
}

//Zip
validator("Zip",$zip,"number","5","5");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Zip:</b></td>\n";
  print "<td><input name='zip' type='text' size='10' maxlength='10' align= 'left' value='".$zip."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='zip' value=".$zip.">";
  print"<tr>\n";
  print"<td><b>Zip: </b></td>\n";
  print"<td>".$zip."</td>\n";
  print"</tr>\n";
}

//Phone Numbers
validator("Bus Phone",$bus_phone,"number","10","10","1");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Bus Phone: </b></td>\n";
  print "<td>(<input name='bus_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($bus_phone,0,3)."'>)&nbsp\n";
  print "	<input name='bus_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($bus_phone,3,3)."'>&nbsp - &nbsp\n";
  print "	<input name='bus_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($bus_phone,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='bus_phone_1' value='".substr($bus_phone,0,3)."'>";
  print "<input type=hidden name='bus_phone_2' value='".substr($bus_phone,3,3)."'>";
  print "<input type=hidden name='bus_phone_3' value='".substr($bus_phone,6,4)."'>";
  print "<tr>\n";
  print "<td><b>Bus Phone: </b></td>\n";
  print "<td>".substr($bus_phone,0,3)."-".substr($bus_phone,3,3)."-".substr($bus_phone,6,4)."</td>\n";
  print "</tr>\n";
}

validator("Business Fax",$fax,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Business Fax: </b></td>\n";
  print "<td>(<input name='bus_fax_1' type='number' size='3' maxlength='3' align='left' value='".substr($fax,0,3)."'>)&nbsp\n";
  print "		<input name='bus_fax_2' type='number' size='3' maxlength='3' align='left' value='".substr($fax,3,3)."'>&nbsp - &nbsp\n";
  print "		<input name='bus_fax_3' type='number' size='4' maxlength='4' align='left' value='".substr($fax,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='bus_fax_1' value='".substr($fax,0,3)."'>";
  print "<input type=hidden name='bus_fax_2' value='".substr($fax,3,3)."'>";
  print "<input type=hidden name='bus_fax_3' value='".substr($fax,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Business Fax: </b></td>\n";
  print"<td>".substr($fax,0,3)."-".substr($fax,3,3)."-".substr($fax,6,4)."</td>\n";
  print"</tr>\n";
}

//Email
validator("Email",$email,"email","1","100","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Email: </b></td>\n";
  print "<td><input name='email' type='text' maxlength='50' align= 'left' value='".$email."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='email' value=\"".$email."\">";
  print"<tr>\n";
  print"<td><b>Email: </b></td>\n";
  print"<td>".$email."</td>\n";
  print"</tr>\n";
}

//Website
validator("Website",$website,"string","4","30","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Website: </b></td>\n";
  print "<td><input name='website' type='text' size='30' maxlength='100' align= 'left' value='".$website."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='website' value=\"".$website."\">";
  print"<tr>\n";
  print"<td><b>Website: </b></td>\n";
  print"<td>".$website."</td>\n";
  print"</tr>\n";
}

print "</table>\n";

print "<br><br>";

//CHECK
if($errCount > 0)
{
  print "<input type=hidden name='form_valid' value='0'>";
  print "<input type=hidden name='form_filled' value='1'>";
  print "&nbsp&nbsp<input type=submit value='Continue'>";
  print "</form>";
}
else
{
  print "<input type=hidden name='form_valid' value='1'>";
  print "<input type=hidden name='form_filled' value='1'>";
  print "&nbsp&nbsp<input type=submit value='Continue'>";
  print "</form>";
}
print "<br><div align = 'center'>";
}

include("./config/closedb.php");
?>

</div>
</body>


</html>

