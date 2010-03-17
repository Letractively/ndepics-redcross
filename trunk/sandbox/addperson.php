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
include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Add Person</title>";echo "<script src=\"./javascript/selectorganization.js\"></script>";include("html_include_2.php");
//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addperson.php - file to insert a person into the disaster database;
//****************************

echo "<h1>Add Person</h1>";
$form_filled = $_POST["form_filled"];
$form_valid = $_POST["form_valid"];
$salutation = $_POST["salutation"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$home_phone = $_POST["home_phone_1"].$_POST["home_phone_2"].$_POST["home_phone_3"];
$work_phone = $_POST["work_phone_1"].$_POST["work_phone_2"].$_POST["work_phone_3"];
$mobile_phone = $_POST["mobile_phone_1"].$_POST["mobile_phone_2"].$_POST["mobile_phone_3"];
$fax = $_POST["fax_1"].$_POST["fax_2"].$_POST["fax_3"];
$email = $_POST["email"];
$im = $_POST["im"];
$updated_by = $_POST["updated_by"];
$info = $_POST["info"];


// Scrub the inputs
$salutation = scrub_input($salutation);
$first_name = scrub_input($first_name);
$last_name = scrub_input($last_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$email = scrub_input($email);
$im = scrub_input($im);
$updated_by = scrub_input($updated_by);
$info = scrub_input($info);

// Display them for the user to verify
//Change to pre-populated tables... notify user of errors. Re-direct back to this page if errors exist?

if(!$form_filled)
{
  ?>
 <br><br>			 
<form name='addperson' method='post' action='addperson.php' align ='left'>
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
			<td><input name='zip' type='text' size='5' maxlength='5' align= 'left'> </td>
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

                <tr>
                      	<td>Additional Information (e.g. Red Cross ID, HAM License No., etc.)</td>
		        <td><textarea name='info' rows=6 cols=40 align= 'left' valign='top'></textarea></td> 

                </tr>

               <tr>
                       <td>YOUR initials</td>
                       <td> <input name='updated_by' type='text' maxlength='11' align='left'> </td>
               </tr>
		
	</table>

    <br>
    <input type=hidden name='form_filled' value='1'>
    <input type=hidden name='form_valid' value='0'>
    <input type=submit value="Continue">
    <input type=reset value="Clear Form">

    </form>
    
    <br>
    <div align='center'>
    <form>
    <INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
    
    </form>
    
    </div>
<?
}
else
{
  $errCount=0;
  validator("Salutation",$salutation,"string","2","10","0");
  validator("First Name", $first_name, "alpha","","","0");
  validator("Last Name",$last_name,"alpha","","","0");
  validator("Street Address",$street_address,"string","","","0");
  validator("City",$city,"alpha_space","","","0");
  validator("State",$state,"alpha","2","2","0");
  validator("Zip",$zip,"number","5","5","","","0");
  validator("Home Phone",$home_phone,"number","10","10","0");
  validator("Work Phone",$work_phone,"number","10","10","0");
  validator("Mobile Phone",$mobile_phone,"number","10","10","0");
  validator("Fax",$fax,"number","10","10","0");
  validator("Email",$email,"email","","","0");
  validator("IM",$im,"alphanumeric","4","30","0");
  validator("Additional Info",$info,"string","","","0");
  validator("Your Initials",$updated_by,"alpha","2","11","1");
  if(!$messages[0])
    {
      $form_valid = 1;
    }
  $messages=array();
  if($form_valid == 1)
    { 
      print "<form name='verifyperson' method='post' action='./addperson2.php' align='left'>";
      print "<p align='center'><b>Please verify this information and click Continue</b></p>";
    }
  else 
    {
      print "<form name='verifyperson' method='post' action='./addperson.php' align='left'>";
      print "<p align='center'><b>Please make all requested corrections and click Continue</b></p>";
    }

  print "<table>";
//Salutation
  validator("Salutation",$salutation,"string","2","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Salutation (Mr., Mrs., etc.): </b></td>\n";
  print "<td><input name='salutation' type='text' size='10' maxlength='10' align= 'left' value='".$salutation."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='salutation' value=\"".$salutation."\">";
  print"<tr>\n";
  print"<td><b>Salutation: </b></td>\n";
  print"<td>".$salutation."</td>\n";
  print"</tr>\n";
}

//Fisrt Name
  validator("First Name", $first_name, "alpha");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>First Name: </b></td>\n";
  print "<td><input name='first_name' type='text' maxlength='30' align= 'left' value='".$first_name."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='first_name' value=\"".$first_name."\">";
  print"<tr>\n";
  print"<td><b>First Name: </b></td>\n";
  print"<td>".$first_name."</td>\n";
  print"</tr>\n";
}

//Last Name
  validator("Last Name",$last_name,"alpha");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Last Name: </b></td>\n";
  print "<td><input name='last_name' type='text' maxlength='30' align= 'left' value='".$last_name."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='last_name' value=\"".$last_name."\">";
  print"<tr>\n";
  print"<td><b>Last Name: </b></td>\n";
  print"<td>".$last_name."</td>\n";
  print"</tr>\n";
}

//Street Address
validator("Street Address",$street_address,"string","","","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Street Address: </b></td>\n";
  print "<td><input name='street_address' type='text' size='30' maxlength='50' align= 'left' value='".$street_address."'></td>\n";
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
  validator("City",$city,"alpha_space","","","0");
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

//State
  validator("State",$state,"alpha","2","2","0");
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
  validator("Zip",$zip,"number","5","5","0");
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
  validator("Home Phone",$home_phone,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Home Phone: </b></td>\n";
  print "<td>(<input name='home_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($home_phone,0,3)."'>)&nbsp\n";
  print "	<input name='home_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($home_phone,3,3)."'>&nbsp - &nbsp\n";
  print "	<input name='home_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($home_phone,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='home_phone_1' value='".substr($home_phone,0,3)."'>";
  print "<input type=hidden name='home_phone_2' value='".substr($home_phone,3,3)."'>";
  print "<input type=hidden name='home_phone_3' value='".substr($home_phone,6,4)."'>";
  print "<tr>\n";
  print "<td><b>Home Phone: </b></td>\n";
  print "<td>".substr($home_phone,0,3)."-".substr($home_phone,3,3)."-".substr($home_phone,6,4)."</td>\n";
  print "</tr>\n";
}

  validator("Work Phone",$work_phone,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Work Phone: </b></td>\n";
  print "<td>(<input name='work_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($work_phone,0,3)."'>)&nbsp\n";
  print "     <input name='work_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($work_phone,3,3)."'>&nbsp - &nbsp\n";
  print "     <input name='work_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($work_phone,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='work_phone_1' value='".substr($work_phone,0,3)."'>";
  print "<input type=hidden name='work_phone_2' value='".substr($work_phone,3,3)."'>";
  print "<input type=hidden name='work_phone_3' value='".substr($work_phone,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Work Phone: </b></td>\n";
  print"<td>".substr($work_phone,0,3)."-".substr($work_phone,3,3)."-".substr($work_phone,6,4)."</td>\n";
  print"</tr>\n";
}

  validator("Mobile Phone",$mobile_phone,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Mobile Phone: </b></td>\n";
  print "<td>(<input name='mobile_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($mobile_phone,0,3)."'>)&nbsp\n";
  print "     <input name='mobile_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($mobile_phone,3,3)."'>&nbsp - &nbsp\n";
  print "     <input name='mobile_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($mobile_phone,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='mobile_phone_1' value='".substr($mobile_phone,0,3)."'>";
  print "<input type=hidden name='mobile_phone_2' value='".substr($mobile_phone,3,3)."'>";
  print "<input type=hidden name='mobile_phone_3' value='".substr($mobile_phone,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Mobile Phone: </b></td>\n";
  print"<td>".substr($mobile_phone,0,3)."-".substr($mobile_phone,3,3)."-".substr($mobile_phone,6,4)."</td>\n";
  print"</tr>\n";
}

  validator("Fax",$fax,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Fax: </b></td>\n";
  print "<td>(<input name='fax_1' type='number' size='3' maxlength='3' align='left' value='".substr($fax,0,3)."'>)&nbsp\n";
  print "     <input name='fax_2' type='number' size='3' maxlength='3' align='left' value='".substr($fax,3,3)."'>&nbsp - &nbsp\n";
  print "     <input name='fax_3' type='number' size='4' maxlength='4' align='left' value='".substr($fax,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='fax_1' value='".substr($fax,0,3)."'>";
  print "<input type=hidden name='fax_2' value='".substr($fax,3,3)."'>";
  print "<input type=hidden name='fax_3' value='".substr($fax,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Fax: </b></td>\n";
  print"<td>".substr($fax,0,3)."-".substr($fax,3,3)."-".substr($fax,6,4)."</td>\n";
  print"</tr>\n";
}

//Email
  validator("Email",$email,"email","","","0");
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

//IM
  validator("IM",$im,"alphanumeric","4","30","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>IM: </b></td>\n";
  print "<td><input name='im' type='text' size='30' maxlength='30' align= 'left' value='".$im."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='im' value=\"".$im."\">";
  print"<tr>\n";
  print"<td><b>IM: </b></td>\n";
  print"<td>".$im."</td>\n";
  print"</tr>\n";
}

//INFO
validator("Info",$info,"string","","","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Additional Info: </b></td>\n";
  print "<td><input name='info' type='text' size='100' maxlength='100' align= 'left' value='".$info."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='info' value=\"".$info."\">";
  print"<tr>\n";
  print"<td><b>Additional Info: </b></td>\n";
  print"<td>".$info."</td>\n";
  print"</tr>\n";
}

//Initials/Updator
validator("Your Initials",$updated_by,"string","2","11","1");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Your Initials: </b></td>\n";
  print "<td><input name='updated_by' type='text' size='12' maxlength='11' align= 'left' value='".$updated_by."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
  print"<tr>\n";
  print"<td><b>Your Initials: </b></td>\n";
  print"<td>".$updated_by."</td>\n";
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
print "<br></div>";
print "</body>";
print "</html>";

include ("config/closedb.php");include("html_include_3.php");
?>