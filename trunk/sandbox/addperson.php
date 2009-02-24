<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
} 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addperson.php - file to insert a person into the disaster database;
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Add Person</title>

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
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
  <h1>Add Person</h1>
  <form>
  <INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
  </form>
</div>

<br><br>			 
<form name='addperson' method='post' action='addperson2.php' align ='left'>
	<input type=hidden name=addtype value=person>
	<table>
		<tr>
			<td>Salutation (Mr., Mrs., etc.)</td>
			<td><input name='salutation' type='text' size='10' maxlength='10' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>First Name</td>
			<td><input name='first_name' type='text' maxlength='30' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Last Name</td>
			<td><input name='last_name' type='text' maxlength='30' align= 'left'> </td>
		</tr>

		<tr>
			<td>Street Address</td>
			<td><input name='street_address' type='text' size='30' maxlength='50' align= 'left'> </td>
		</tr>

		<tr>
			<td>City</td>
			<td><input name='city' type='text' size='30' maxlength='30' align= 'left'> </td>
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
			<td>Home Phone</td>
			<td>(<input name='home_phone_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
			<input name='home_phone_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
			<input name='home_phone_3' type='number' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Work Phone</td>
			<td>(<input name='work_phone_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='work_phone_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='work_phone_3' type='number' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Mobile Phone</td>
			<td>(<input name='mobile_phone_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='mobile_phone_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='mobile_phone_3' type='number' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Fax</td>
			<td>(<input name='fax_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='fax_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='fax_3' type='number' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Email</td>
			<td> <input name='email' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>IM</td>
			<td> <input name='im' type='text' size='30' maxlength='30' align= 'left'> </td>
		</tr>
		
	</table>

	<br>
        <input type=hidden name='form_valid' value='0'>
	<input type=submit value="Add Person">
	<input type=reset value="Clear">

</form>

<br>
<div align='center'>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">

</form>

</div>
</div>
</body>
</html>

