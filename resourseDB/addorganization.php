<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// addorganization.php - file to insert an organization into the disaster database
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
echo "<title>St. Joseph Red Cross - Add Organization</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
?> 
<center><h1>Add Organization</h1></center>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</div>
<?php
//collect variables if page re-directs to self
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
//$updated_by = $_POST["updated_by"];
$nss_id = $_POST["nss_id"];

//take care of the unit association variable
//change from an array to a string for printing
if(!is_string($unit)) { //if not string (i.e. if is_array)
	//explode unit array
	for ($i=0; $i<count($unit); $i++) { 
		if(empty($unit[$i]))  //check for empty values
			{unset($unit[$i]);} //delete empty values
	}
	//convert array to string
	$unit = implode (",", $unit); //convert to string using comma as delimiter
}//end if is_string

// Scrub the inputs, see functions.php for more information
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
//$updated_by = scrub_input($updated_by);
$nss_id = scrub_input($nss_id);

if(!$form_filled) { //If first visit to page, we want to print an empty form
?>
<br /><br />
<!-- Note that this form re-directs to itself -->
<form name='addorganization' method='post' action='addorganization.php' align ='left'>
	<input type=hidden name=addtype value=organization>
	<table>
		<tr>
			<td>Organization Name*</td>
			<td><input name='organization_name' type='text' maxlength='100' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Street Address*</td>
			<td><input name='street_address' type='text' maxlength='50' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Mailing Address</td>
			<td><input name='mailing_address' type='text' maxlength='50' align= 'left'> </td>
		</tr>

		<tr>
			<td>City*</td>
			<td><input name='city' type='text' maxlength='30' align= 'left'> </td>
		</tr>

		<tr>
			<td>State*</td>
			<td><input name='state' type='text' size='2' maxlength='2' align= 'left'> </td>
		</tr>

		<tr>
			<td>Zip*</td>
			<td><input name='zip' type='text' size='5' maxlength='5' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>County</td>
			<td><input name='county' type='text' maxlength='20' align= 'left'> </td>
		</tr>
		
		<tr>
			<td>Business Phone*</td>
			<td>(<input name='bus_phone_1' type='text' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='bus_phone_2' type='text' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='bus_phone_3' type='text' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>

		<tr>
			<td>24Hour Phone or 2nd Phone</td>
			<td>(<input name='bus_phone2_1' type='text' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='bus_phone2_2' type='text' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='bus_phone2_3' type='text' size='4' maxlength='4' align= 'left'>
			</td>
		</tr>
		
		<tr>
			<td>Business Fax</td>
			<td>(<input name='bus_fax_1' type='text' size='3' maxlength='3' align= 'left'>)&nbsp
				<input name='bus_fax_2' type='text' size='3' maxlength='3' align= 'left'>&nbsp - &nbsp
				<input name='bus_fax_3' type='text' size='4' maxlength='4' align= 'left'>
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
        <?php
        	// Collect data from "chapters" table.
			$chapters_data = mysql_query("SELECT * FROM chapters") or die("Error: Getting Chapters");
			print "<tr>";
			print '<td valign="top"><b>Associate to a Red Cross Unit:<br /><i>Check all that apply</i></b></td>';
			print "<td>";
			
			print "Chapters:";
			// This fetches all the chapters and displays four chapters for each line.
			$countChapters = -5;
			while($chapters = mysql_fetch_array($chapters_data)){
				$countChapters = $countChapters + 1;
				if($countChapters % 4 == 0 and $countChapters >= 0){
        			print "<br />";
        			print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";					
				}
				print '<input type="checkbox" name="unit[]" value="'.$chapters[chapter_name].'" />'.$chapters[chapter_name];
			}
			print "<br />";
			
			$districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");
			print "Districts:";
			// This fetches all the districts and displays four districts for each line.
			$countDistricts = -5;
			while($districts = mysql_fetch_array($districts_data)){
				$countDistricts = $countDistricts + 1;
				if($countDistricts % 4 == 0 and $countDistricts >= 0){
					print "<br />";
					print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
				}
				print '<input type="checkbox" name="unit[]" value="'.$districts[district_name].'" />'.$districts[district_name];
			}
			print "<br />";
        ?>
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
        	<td>NSS ID/Code: </td>
        	<td> <input name="nss_id" type="text" maxlength="8" align="left" value=""> </td>
        </tr>
        <!--
        <tr>
        	<td>YOUR initials</td>
        	<td> <input name='updated_by' type='text' maxlength='11' align='left' value=""> </td>
        </tr>
        -->
	</table>
	<br />
    <input type=hidden name='form_filled' value='1'> <!-- The form has been filled out -->
    <input type=hidden name='form_valid' value='0'>  <!-- but has not been validated -->
    <input type=reset value="Clear Form">
    <input type=submit value="Continue">
</form>
<?
   }// end if form not filled out
else { //the form has been filled out, but neets to be validated
$errCount=0; //variable to count errors
//run each input through the validator.  See functions.php for use of this function
validator("Organization Name",$organization_name,"string","1","100","1");
validator("Street Address", $street_address, "string","1","100","1");
validator("Mailing Address", $mailing_address, "string","1","100","0");
validator("City",$city,"alpha_space");
validator("County",$county,"string","1","50","0");
validator("State",$state,"alpha","2","2");
validator("Zip",$zip,"number","5","5","1");
validator("Bus Phone",$bus_phone,"number","10","10","1");
validator("24H or 2nd Phone",$bus_phone2,"number","10","10","0");
validator("Business Fax",$fax,"number","10","10","0");
validator("Email",$email,"email","1","100","0");
validator("Website",$website,"string","4","30","0");
validator("Info",$addtl_info,"string","","","0");
validator("Unit",$unit,"string","","","0");
validator("NSS ID/Code", $nss_id, "string", "8", "8", "0");

if(!$messages[0]) { //if there are no messages in the error message array
	$form_valid = 1; //mark form as valid
}
$messages=array(); //reset the message array
if($form_valid == 1){ //if form is valid, allow user to verify info and proceed to addorganization2.php
     print "<form name='verifyorganization' method='post' action='./addorganization2.php' align='left'>";
     print "<p align='center'><b>Please verify this information and click Continue</b></p>";
} else { //form is not valid, need to redirect user back to this page for re-validation after corrections are made
     print "<form name='verifyorganization' method='post' action='./addorganization.php' align='left'>";
     print "<p align='center'><b>Please make necessary corrections and click Continue.</b></p>";
}

print "<table>";  //table to format printouts and adjustment fields
//Org Name
validator("Organization Name",$organization_name,"string"); //re-run the validator
if($messages[$errCount]) { //there is an error at this location, reprint a form cell
  print $messages[$errCount]."<br />"; //print out the error above the table.
  $errCount++; //increment the error counter
  print "<tr>\n";
  print "<td><b>Organization Name: </b></td>\n";
  print "<td><input name='organization_name' type='text' size='50' maxlength='50' align= 'left' value='".$organization_name."'></td>\n";
  print "</tr>\n";
} else { //no problem with this value, just print it
  print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
  print"<tr>\n";
  print"<td><b>Organization Name: </b></td>\n";
  print"<td>".$organization_name."</td>\n";
  print"</tr>\n";
}
//Run the same login on the rest of the inputs
//Street Addr
validator("Street Address", $street_address, "string","1","100","1");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Street Address: </b></td>\n";
  print "<td><input name='street_address' type='text' maxlength='50' align= 'left' value='".$street_address."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='street_address' value=\"".$street_address."\">";
  print"<tr>\n";
  print"<td><b>Street Address: </b></td>\n";
  print"<td>".$street_address."</td>\n";
  print"</tr>\n";
}

//Mailing Addr
validator("Mailing Address", $street_address, "string","1","100","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Mailing Address: </b></td>\n";
  print "<td><input name='mailing_address' type='text' maxlength='50' align= 'left' value='".$mailing_address."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
  print"<tr>\n";
  print"<td><b>Mailing Address: </b></td>\n";
  print"<td>".$mailing_address."</td>\n";
  print"</tr>\n";
}

//City
validator("City",$city,"alpha_space");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>City: </b></td>\n";
  print "<td><input name='city' type='text' size='30' maxlength='30' align= 'left' value='".$city."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='city' value=\"".$city."\">";
  print"<tr>\n";
  print"<td><b>City: </b></td>\n";
  print"<td>".$city."</td>\n";
  print"</tr>\n";
}

//County
validator("County",$county,"string","1","50","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>County: </b></td>\n";
  print "<td><input name='county' type='text' size='20' maxlength='20' align= 'left' value='".$county."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='county' value=\"".$county."\">";
  print"<tr>\n";
  print"<td><b>County: </b></td>\n";
  print"<td>".$county."</td>\n";
  print"</tr>\n";
}

//State
validator("State",$state,"alpha","2","2");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>State: </b></td>\n";
  print "<td><input name='state' type='text' size='2' maxlength='2' align= 'left' value='".$state."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='state' value=\"".$state."\">";
  print"<tr>\n";
  print"<td><b>State: </b></td>\n";
  print"<td>".$state."</td>\n";
  print"</tr>\n";
}

//Zip
validator("Zip",$zip,"number","5","5","1");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Zip:</b></td>\n";
  print "<td><input name='zip' type='text' size='10' maxlength='10' align= 'left' value='".$zip."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='zip' value=".$zip.">";
  print"<tr>\n";
  print"<td><b>Zip: </b></td>\n";
  print"<td>".$zip."</td>\n";
  print"</tr>\n";
}

//Phone Numbers
validator("Bus Phone",$bus_phone,"number","10","10","1");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Bus Phone: </b></td>\n";
  print "<td>(<input name='bus_phone_1' type='text' size='3' maxlength='3' align='left' value='".substr($bus_phone,0,3)."'>)&nbsp\n";
  print "	<input name='bus_phone_2' type='text' size='3' maxlength='3' align='left' value='".substr($bus_phone,3,3)."'>&nbsp - &nbsp\n";
  print "	<input name='bus_phone_3' type='text' size='4' maxlength='4' align='left' value='".substr($bus_phone,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='bus_phone_1' value='".substr($bus_phone,0,3)."'>";
  print "<input type=hidden name='bus_phone_2' value='".substr($bus_phone,3,3)."'>";
  print "<input type=hidden name='bus_phone_3' value='".substr($bus_phone,6,4)."'>";
  print "<tr>\n";
  print "<td><b>Bus Phone: </b></td>\n";
  print "<td>".substr($bus_phone,0,3)."-".substr($bus_phone,3,3)."-".substr($bus_phone,6,4)."</td>\n";
  print "</tr>\n";
}

validator("24H or 2nd Phone",$bus_phone2,"number","10","10","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>24H or 2nd Phone: </b></td>\n";
  print "<td>(<input name='bus_phone2_1' type='text' size='3' maxlength='3' align='left' value='".substr($bus_phone2,0,3)."'>)&nbsp\n";
  print "	<input name='bus_phone2_2' type='text' size='3' maxlength='3' align='left' value='".substr($bus_phone2,3,3)."'>&nbsp - &nbsp\n";
  print "	<input name='bus_phone2_3' type='text' size='4' maxlength='4' align='left' value='".substr($bus_phone2,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='bus_phone2_1' value='".substr($bus_phone2,0,3)."'>";
  print "<input type=hidden name='bus_phone2_2' value='".substr($bus_phone2,3,3)."'>";
  print "<input type=hidden name='bus_phone2_3' value='".substr($bus_phone2,6,4)."'>";
  print "<tr>\n";
  print "<td><b>24H or 2nd Phone: </b></td>\n";
  print "<td>".substr($bus_phone2,0,3)."-".substr($bus_phone2,3,3)."-".substr($bus_phone2,6,4)."</td>\n";
  print "</tr>\n";
}

validator("Business Fax",$fax,"number","10","10","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Business Fax: </b></td>\n";
  print "<td>(<input name='bus_fax_1' type='text' size='3' maxlength='3' align='left' value='".substr($fax,0,3)."'>)&nbsp\n";
  print "		<input name='bus_fax_2' type='text' size='3' maxlength='3' align='left' value='".substr($fax,3,3)."'>&nbsp - &nbsp\n";
  print "		<input name='bus_fax_3' type='text' size='4' maxlength='4' align='left' value='".substr($fax,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
} else {
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
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Email: </b></td>\n";
  print "<td><input name='email' type='text' maxlength='50' align= 'left' value='".$email."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='email' value=\"".$email."\">";
  print"<tr>\n";
  print"<td><b>Email: </b></td>\n";
  print"<td>".$email."</td>\n";
  print"</tr>\n";
}

//Website
validator("Website",$website,"string","4","30","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Website: </b></td>\n";
  print "<td><input name='website' type='text' size='30' maxlength='100' align= 'left' value='".$website."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='website' value=\"".$website."\">";
  print"<tr>\n";
  print"<td><b>Website: </b></td>\n";
  print"<td>".$website."</td>\n";
  print"</tr>\n";
}

//Info
validator("Additional Info",$addtl_info,"string","","","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Additional Info: </b></td>\n";
  print "<td><input name='addtl_info' type='textarea' rows='6' cols='40' align='left' valign='top' value=\'".$addtl_info."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
  print"<tr>\n";
  print"<td><b>Additional Info: </b></td>\n";
  print"<td>".$addtl_info."</td>\n";
  print"</tr>\n";
}

//Unit
validator("Unit",$unit,"string","","","0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  print "Not associated with a Red Cross Unit:<br />";
  $errCount++;
//print out the check boxes using raw HTML
?>
        <?php
        	// Collect data from "chapters" table.
			$chapters_data = mysql_query("SELECT * FROM chapters") or die("Error: Getting Chapters");
			print "<tr>";
			print '<td valign="top"><b>Associate to a Red Cross Unit:<br /><i>Check all that apply</i></b></td>';
			print "<td>";
			print "Chapters:";
			// This fetches all the chapters and displays four chapters for each line.
			$countChapters = -5;
			while($chapters = mysql_fetch_array($chapters_data)){
				$countChapters = $countChapters + 1;
				if($countChapters % 4 == 0 and $countChapters >= 0){
        			print "<br />";
        			print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";					
				}
				print '<input type="checkbox" name="unit[]" value="'.$chapters[chapter_name].'" />'.$chapters[chapter_name];
			}
			print "<br />";
			
			$districts_data = mysql_query("SELECT * FROM districts") or die("Error: Getting Districts");
			print "Districts:";
			// This fetches all the districts and displays four districts for each line.
			$countDistricts = -5;
			while($districts = mysql_fetch_array($districts_data)){
				$countDistricts = $countDistricts + 1;
				if($countDistricts % 4 == 0 and $countDistricts >= 0){
					print "<br />";
					print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
				}
				print '<input type="checkbox" name="unit[]" value="'.$districts[district_name].'" />'.$districts[district_name];
			}
			print "<br />";
        ?>
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
} else { //unit association exists
	print "<input type=hidden name='unit' value=\"".$unit."\">";
	print "<tr>\n";
	print "<td><b>Unit: </b></td>\n";
	print "<td>$unit</td>\n";
	print "</tr>\n";
}

// NSS ID/Code
validator("NSS ID/Code", $nss_id, "string", "8", "8", "0");
if($messages[$errCount]) {
  print $messages[$errCount]."<br />";
  $errCount++;
  print "<tr>\n";
  print "<td><b>NSS ID/Code: </b></td>\n";
  print "<td><input name='nss_id' type='text' size='10' maxlength='8' align= 'left' value='".$nss_id."'></td>\n";
  print "</tr>\n";
} else {
  print "<input type=hidden name='nss_id' value=\"".$nss_id."\">";
  print"<tr>\n";
  print"<td><b>NSS ID/Code: </b></td>\n";
  print"<td>".$nss_id."</td>\n";
  print"</tr>\n";
}

print "</table>\n"; //end the printout table
print "<br /><br />";

//Check to see if the form was valid
if($errCount > 0) {
  print "<input type=hidden name='form_valid' value='0'>";
  print "<input type=hidden name='form_filled' value='1'>";
  print "&nbsp&nbsp<input type=submit value='Continue'>";
  print "</form>";
} else {
  print "<input type=hidden name='form_valid' value='1'>";
  print "<input type=hidden name='form_filled' value='1'>";
  print "&nbsp&nbsp<input type=submit value='Continue'>";
  print "</form>";
}
} //end else form already filled
include("./config/closedb.php"); //close connection to database
include("./html_include_3.php"); //close all remaing HTML tags
?>