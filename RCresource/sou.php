<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// sou.php - HTML and PHP to accept a file for upload
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - SoU Upload</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Upload Statement of Understanding</h1><hr />";

//Pick up POSTed variable from updateorganization.php
$organization_id = $_POST["organization_id"];

//Get the organization name
$query = "SELECT	organization_name
          FROM		organization
          WHERE		organization_id = ".$organization_id;
$org = mysql_query($query) or die ("Query Failed...could not retrieve organization information");
$array = mysql_fetch_assoc($org);
$org = $array['organization_name'];

//print upload information and directions
print "Upload Statement of Understanding for " .$org.". Any existing file for this organization will be overwritten.";
print"<form name='souForm' enctype='multipart/form-data' action='./sou2.php' method='POST'>";
print"<input type='hidden' name='MAX_FILE_SIZE' value='2097152' >";
print"<input type=\"hidden\" name=\"id\" value=".$organization_id.">";
print"The maximum file size is 2 MB.<br />Most .pdf, .doc, and .docx files will be well under the limit. ";
?>

Choose a file to upload:<br />
<input name="uploadedfile" type="file" id = "uploadedfile"/> <!-- Includes a browse button -->
<br />
Choose a File Type: <br />
<select name="extension">
       <option value="NULL"> </option>
       <option value="pdf">.pdf</option>
       <option value="doc">.doc</option>
       <option value="docx">.docx</option>
</select>
<br />

<script type="text/javascript">
	<!--
		function determineDays(){
			var month = document.getElementById("expirationMonth").value;
			var limit;
		
			if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12){
				limit = 31;
			}
			else if (month == 4 || month == 6 || month == 9 || month == 11){
				limit = 30;
			}
			else if (month == 2){
				var year = document.getElementById("expirationYear").value;
				if( (year %4 == 0 && year % 100 != 0) || (year %400 == 0) ){
					limit = 29;
				}
				else{
					limit = 28;
				}
			}
			else{
				limit = 31;
			}

			document.souForm.expirationDay.options.length = 0;
			document.souForm.expirationDay.options[0] = new Option("", "0", true, false);
			
			for(i=1; i <= limit; i++){
				document.souForm.expirationDay.options[i] = new Option(i.toString(), i.toString(), false, false);
			}
		}
		function determineLeapYear(){
			var month = document.getElementById("expirationMonth").value;
			
			if(month == 2){
				var year = document.getElementById("expirationYear").value;
				var day = document.getElementById("expirationDay").value;
				
				if( !((year %4 == 0 && year % 100 != 0) || (year %400 == 0)) && day == 29){
					determineDays();
				}
			}
		}
	// -->
</script>
<noscript>
	Your browser does not support Javascript.
</noscript>

Select the expiration date: <br />
<select name="expirationMonth" id="expirationMonth" onChange="determineDays()">
	<option value="0"></option>
	<option value="1">January</option>
	<option value="2">February</option>
	<option value="3">March</option>
	<option value="4">April</option>
	<option value="5">May</option>
	<option value="6">June</option>
	<option value="7">July</option>
	<option value="8">August</option>
	<option value="9">September</option>
	<option value="10">October</option>
	<option value="11">November</option>
	<option value="12">December</option>
</select>

<select name="expirationDay" id="expirationDay" onFocus="determineDays()">
</select>

<select name="expirationYear" id="expirationYear" onChange="determineLeapYear()">
	<?php
		print "<option value='0'></option>";
		for($i=2012; $i <= 2050; $i++){
			print "<option value='".$i."'>".$i."</option>";
		}
	?>
</select>
<br />
<br />
<div>
<input type="submit" value="Update Statement of Understanding">
</div>
</form>

<?
include("./config/closedb.php"); //close database connection
include("./html_include_3.php"); //close HTML tags
?>