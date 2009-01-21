<?php
session_start();
 if(($_SESSION['valid']) == "valid") {
	header( 'Location: ./home.php' );
 }


//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// index.php - the entry/login page for the Disaster Database, if already logged in 
//				(session variable set) you will be redirected to home.php;
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Welcome to the Disaster Database for the St. Joseph County Red Cross</title>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<!-- <link rel="stylesheet" type="text/css" href="/custom.css"/> -->
 <STYLE type="text/css">
  SPAN { padding-left:3px; padding-right:3px }
  DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
  BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
 </STYLE>


<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<c>
<img src="masthead.jpg" style="width:740px; height:100px">
  			<p style="padding-bottom:1px; margin:0">
				American Red Cross, St. Joseph County Chapter
			</p>
			<p style="font-weight:normal; padding:0; margin: 0">
				<span>3220 East Jefferson Boulevard</span>
				<span>&nbsp;</span>
				<span>South Bend</span>
				<span>Indiana</span>
				<span>46615</span>
				<span>Phone (574) 234-0191</span>

			</p>
</c>

</div>
<div align="center">
  <h1 align="center">Welcome to the Disaster Database for the St. Joseph County Red Cross</h1>
</div>

<div align="center" valign="center">

<?php
	
	$validlogin = $_SESSION['valid'];
	//print "<br>";
	//print "Session Variables: valid= ".$_SESSION['valid'].", user_id= ".$_SESSION['user_id']
	//							.", access_level= ".$_SESSION['access_level_id']."<br><br>";
		
	if ($validlogin == "invalid")
	{
		print "Invalid login, please try again.";
	}


?>

<br>
<form action="login.php" method="post">   
    <table border='0' cellspacing='0' cellpadding='1' align=center>
		<tr> 
			<td><align='left'>Username </td> 
			<td align='left'><input type ='text' name='username' ></td>
		</tr>

		<tr> 
			<td align='left'>Password </td> 
			<td align='left'><input name='password' type ='password'>
			</td>
		</tr>

		<tr colspan='2'> 
			<td align='center'>
			<input type='submit' value='Log In'>
			<input type='reset' value='Reset'>
			</td> 
		</tr>
	</table>

</div>

</body>
</html>