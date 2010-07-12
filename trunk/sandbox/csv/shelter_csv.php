<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2010 - Matt Mooney
// shelter_csv.php - script that prints full shelter organization dump and writes to CSV
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header('Location: ./../index.php'); //redirect to index if not loggin in
}
if( $_SESSION['access_level_id'] != 9) { //check for admin rights
	header('Location: ./../home.php'); //redirect if not authorized
}
 
include("./../config/dbconfig.php"); //database name and password
include("./../config/opendb.php"); //opens connection to database
include("./../config/functions.php"); //imports external functions

//Query database for all shelters
$org_query = "	SELECT * FROM organization o
				WHERE o.organization_id = ANY 
					(SELECT organization_id FROM resource_listing rl
				 	 WHERE rl.resource_id = 
			 			(SELECT resource_id FROM detailed_resource dr
				 		 WHERE dr.resource_type = 'Shelter'))";

//Query database for shelter information
$shr_query = "SELECT * FROM shelter_info";

//Run queries
$shr_result = mysql_query($shr_query) or die("MySQL Query failed: ".$shr_query);
$org_result = mysql_query($org_query) or die("MySQL Query failed: ".$org_query);

//Open the file to write.
$outfile = fopen("shelter.csv","w");
$file = true;
if(!$outfile){
	$file = false;
}

//Check to see if file opened properly
if($file){
	print "Writing to shelter.csv<br />\n";
} else {
	print "ERROR: Could not write to shelter.csv<br />Please use the printout below:<br /><br />\n";
}

//Get Number of fields in organization query
$shr_num_fields = mysql_num_fields($shr_result);
$org_num_fields = mysql_num_fields($org_result);

//Print out the column names
//First do organization table
//Loop though every field, skip the last field because we don't want the log
for($i=0;$i<$org_num_fields-1 ; $i++){
	fwrite($outfile, '"'.mysql_field_name($org_result, $i).'",');
	print '"'.mysql_field_name($org_result, $i).'",';
}
//Now do shelter_info fields, skip the last field becasue we print that one with a \n instead of comma
for($i=1;$i<$shr_num_fields-1;$i++){ //skip frist field because it is id, not needed
	fwrite($outfile, '"'.mysql_field_name($shr_result, $i).'",');
	print '"'.mysql_field_name($shr_result, $i).'",';
}
//Print final column header with no comma
fwrite($outfile, '"'.mysql_field_name($shr_result, $shr_num_fields-1).'"');
print '"'.mysql_field_name($shr_result, $shr_num_fields-1).'"';

//End the top row with a newline/breaking element
fwrite($outfile, "\n");
print "<br />\n";

//Print out the rows to fill out csv/table
while($org_row = mysql_fetch_array($org_result)){
	//Loop through each element of the organization row, printing the value.
	for($i=0;$i<$org_num_fields-1;$i++){
		fwrite($outfile,'"'.$org_row[$i].'",');
		print '"'.$org_row[$i].'",';
	}
	
	//Now determine if we have shelter_info to print for this organization
	//Set up the process
	$si = false; //reset shelter info variable
	//Reset to scan from the top of the array of tables
	mysql_data_seek($shr_result,0);

	//Loop through each shelter info record (theoretically no larger than the organization list, especially early on
	while($shr_row = mysql_fetch_array($shr_result)) {
		//Determine if there is a match between organization ids
		//if the two organization ids match, print info and break
		if($org_row['organization_id'] == $shr_row['organization_id']) {
			$si = true; //shelter info exists for this record
			//print nessessary information in CSV
			for($i =1;$i<$shr_num_fields-1;$i++){ //skip first field b/c it is id, not needed
				fwrite($outfile,'"'.$shr_row[$i].'",');
				print '"'.$shr_row[ $i ].'",';
			}
			//print last element without comma
			fwrite($outfile, '"'.$shr_row[$shr_num_fields-1].'"' );
			print '"'.$shr_row[$shr_num_fields-1].'"';
			//There won't be more matches, break out of the loop for efficiency
			break;
		}
	}
	
	if(!$si) { //if there was no shelter info for this result
		//printout blank fillers for shelter info
		for($i =1;$i<$shr_num_fields-1;$i++){
			fwrite($outfile,'" ",');
			print '" ",';
		}
		//print last element without comma
		fwrite($outfile, '" "');
		print '" "';
	}
	//Print newline/breaking element at end of each row
	fwrite($outfile, "\n");
	print "<br />\n";
} //End while

//Close the file for reading and downloading
if(!fclose($outfile)) {
	print "ERROR: Could not close shelter.csv<br />\n";	
} else {
	print "Finished writing to shelter.csv<br />\n";
}

include("./../config/closedb.php"); //close database connection
//redirect to download
print "<meta http-equiv=\"Refresh\" content=\"0;url=./shelter.csv\" />";
?>
