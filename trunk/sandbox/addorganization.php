<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addorganization.php - file to insert an organization into the disaster database
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
}  
include("./config/dbconfig.php");
include("./config/opendb.php");
include("./config/functions.php");
include("./html_include_1.php");
echo "<title>St. Joseph Red Cross - Add Organization</title>";
include("./html_include_2.php");
?> 
<center><h1>Add Organization</h1></center>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>
<?php

$form_filled = $_POST["form_filled"];
$form_valid = $_POST["form_valid"];
$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$mailing_address = $_POST["mailing_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$bus_phone = $_POST["bus_phone_1"].$_POST["bus_phone_2"].$_POST["bus_phone_3"];
$bus_phone2 = $_POST["bus_phone2_1"].$_POST["bus_phone2_2"].$_POST["bus_phone2_3"];
$fax = $_POST["bus_fax_1"].$_POST["bus_fax_2"].$_POST["bus_fax_3"];
$email = $_POST["email"];
$website = $_POST["website"];
$addtl_info = $_POST["addtl_info"];
if(isset($_POST["unit"])) {$unit = $_POST["unit"];} else {$unit=array();}
$updated_by = $_POST["updated_by"];


if(!is_string($unit))
{
	//explode unit array
	print "UNIT: $unit .";
	for ($i=0; $i<count($unit); $i++) { 
		if(empty($unit[$i])) 
			{unset($unit[$i]);}
	}
	//convert array to string
	$unit = implode (",", $unit); 
}//end if is_string

// Scrub the inputs
$organization_name = scrub_input($organization_name);
$street_address = scrub_input($street_address);
$mailing_address = scrub_input($mailing_address);
$city = scrub_input($city);
$state = scrub_input($state);
$zip = scrub_input($zip);
$county = scrub_input($county);
$bus_phone = scrub_input($bus_phone);
$bus_phone2 = scrub_input($bus_phone2);
$fax = scrub_input($fax);
$email = scrub_input($email);
$website = scrub_input($website);
$addtl_info = scrub_input($addtl_info);
$unit = scrub_input($unit);
$updated_by = scrub_input($updated_by);

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
			<td><input name='organization_name' type='text' maxlength='100' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Street Address</td>
			<td><input name='street_address' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Mailing Address</td>
			<td><input name='mailing_address' type='text' maxlength='50' align= 'left'> </td>
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
			<td><input name='zip' type='text' size='5' maxlength='5' align= 'left'> </td>
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
			<td>24Hour Phone or 2nd Phone</td>
			<td>(<input name='bus_phone2_1' type='number' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='bus_phone2_2' type='number' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='bus_phone2_3' type='number' size='4' maxlength='4' align= 'left'>
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

                <tr>
                      	<td>Additional Information</td>
		        <td><textarea name='addtl_info' rows=6 cols=40 align= 'left' valign='top'></textarea></td> 

                </tr>
                
                <tr>
                	<td valign="top">Associate to a Red Cross Unit:<br /><i>Check all that apply</i></td>
                    <td>Chapters:
                    <input type="checkbox" name="unit[]" value="StJoseph" />St Joseph
                    <input type="checkbox" name="unit[]" value="Cass" />Cass
                    <input type="checkbox" name="unit[]" value="LaPorte" />LaPorte
                    <input type="checkbox" name="unit[]" value="Marshall" />Marshall
                    <br />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="unit[]" value="Elkhart" />Elkhart
                    <input type="checkbox" name="unit[]" value="Kosciusko" />Kosciusko
                    <input type="checkbox" name="unit[]" value="Porter" />Porter
                    <br />Divisions:
                    <input type="checkbox" name="unit[]" value="District1" />District 1
                    <input type="checkbox" name="unit[]" value="District2" />District 2
                    <input type="checkbox" name="unit[]" value="District3" />District 3
                    <input type="checkbox" name="unit[]" value="District4" />District 4
                    <br />
                    <input type="checkbox" name="unit[]" value="Region" />Region
                    <br />
                    <input type="checkbox" name="unit[]" value="State" />State
                    <br />
                    <input type="checkbox" name="unit[]" value="National" />National
                    <br />
                    <input type="checkbox" name="unit[]" value="Other" />Other
                    </td>
                </tr>

               <tr>
                       <td>YOUR initials</td>
                       <td> <input name='updated_by' type='text' maxlength='11' align='left'> </td>
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
 validator("Organization Name",$organization_name,"string","1","100","1");
 validator("Street Address", $street_address, "string","1","100","0");
 validator("Mailing Address", $mailing_address, "string","1","100","0");
 validator("City",$city,"alpha_space");
 validator("County",$county,"string","1","50","0");
 validator("State",$state,"alpha","2","2");
 validator("Zip",$zip,"number","5","5","0");
 validator("Bus Phone",$bus_phone,"number","10","10","0");
 validator("24H or 2nd Phone",$bus_phone2,"number","10","10","0");
 validator("Business Fax",$fax,"number","10","10","0");
 validator("Email",$email,"email","1","100","0");
 validator("Website",$website,"alphanumeric","4","30","0");
 validator("Info",$addtl_info,"string","","","0");
 validator("Unit",$unit,"string","","","0");
 validator("Your Initials",$updated_by,"alpha","2","11","1");
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
 
 //Org Name
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

//Street Addr
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

//Mailing Addr
validator("Mailing Address", $street_address, "string","1","100","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Mailing Address: </b></td>\n";
  print "<td><input name='mailing_address' type='text' maxlength='50' align= 'left' value='".$mailing_address."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
  print"<tr>\n";
  print"<td><b>Mailing Address: </b></td>\n";
  print"<td>".$mailing_address."</td>\n";
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
validator("Bus Phone",$bus_phone,"number","10","10","0");
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

validator("24H or 2nd Phone",$bus_phone2,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>24H or 2nd Phone: </b></td>\n";
  print "<td>(<input name='bus_phone2_1' type='number' size='3' maxlength='3' align='left' value='".substr($bus_phone2,0,3)."'>)&nbsp\n";
  print "	<input name='bus_phone2_2' type='number' size='3' maxlength='3' align='left' value='".substr($bus_phone2,3,3)."'>&nbsp - &nbsp\n";
  print "	<input name='bus_phone2_3' type='number' size='4' maxlength='4' align='left' value='".substr($bus_phone2,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='bus_phone2_1' value='".substr($bus_phone2,0,3)."'>";
  print "<input type=hidden name='bus_phone2_2' value='".substr($bus_phone2,3,3)."'>";
  print "<input type=hidden name='bus_phone2_3' value='".substr($bus_phone2,6,4)."'>";
  print "<tr>\n";
  print "<td><b>24H or 2nd Phone: </b></td>\n";
  print "<td>".substr($bus_phone2,0,3)."-".substr($bus_phone2,3,3)."-".substr($bus_phone2,6,4)."</td>\n";
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

//Info
validator("Additional Info",$addtl_info,"string","","","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Additional Info: </b></td>\n";
  print "<td><input name='addtl_info' type='textarea' rows='6' cols='40' align='left' valign='top' value=\'".$addtl_info."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
  print"<tr>\n";
  print"<td><b>Additional Info: </b></td>\n";
  print"<td>".$addtl_info."</td>\n";
  print"</tr>\n";
}

//Unit
if($unit == "")
{
  print "Not associated with a Red Cross Unit:<br>Unit: $unit.";
  $errCount++;
?>
                <tr>
                	<td valign="top"><b>Associate to a Red Cross Unit:<br /><i>Check all that apply</i></b></td>
                    <td>Chapters:
                    <input type="checkbox" name="unit[]" value="StJoseph" />St Joseph  
                    <input type="checkbox" name="unit[]" value="Cass" />Cass 
                    <input type="checkbox" name="unit[]" value="LaPorte" />LaPorte 
                    <input type="checkbox" name="unit[]" value="Marshall" />Marshall
                    <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="unit[]" value="Elkhart" />Elkhart 
                    <input type="checkbox" name="unit[]" value="Kosciusko" />Kosciusko 
                    <input type="checkbox" name="unit[]" value="Porter" />Porter 
                    <br />Divisions:
                    <input type="checkbox" name="unit[]" value="District1" />District 1
                    <input type="checkbox" name="unit[]" value="District2" />District 2
                    <input type="checkbox" name="unit[]" value="District3" />District 3
                    <input type="checkbox" name="unit[]" value="District4" />District 4
                    <br />
                    <input type="checkbox" name="unit[]" value="Region" />Region
                    <br />
                    <input type="checkbox" name="unit[]" value="State" />State
                    <br />
                    <input type="checkbox" name="unit[]" value="National" />National
                    <br />
                    <input type="checkbox" name="unit[]" value="Other" />Other
                    </td>
                </tr>
<?
}
else
{
	print "<input type=hidden name='unit' value=\"".$unit."\">";
	print "<tr>\n";
	print "<td><b>Unit: </b></td>\n";
	print "<td>$unit</td>\n";
	print "</tr>\n";
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

include("./config/closedb.php");
include("./html_include_3.php");
?>