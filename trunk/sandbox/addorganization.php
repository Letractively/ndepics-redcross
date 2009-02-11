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
  <h1>Add Organization</h1>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>

<br>		 
<form name='addorganization' method='post' action='addorganization2.php' align ='left'>
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
	<input type=submit value="Continue">
	<input type=reset value="Clear Form">

</form>

<br>
<div align='center'>
<form>
	<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
<br>
</div>

</div>
</body>


</html>

