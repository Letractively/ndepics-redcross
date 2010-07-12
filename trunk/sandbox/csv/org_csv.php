<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2009 - Rob Wettach
// Summer 2010 - Matt Mooney
// org_csv.php - script that prints full organization dump and writes to CSV
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./../index.php' ); //redirect to index if not loggin in
}
if( $_SESSION['access_level_id'] != 9) { //check for admin rights
	header( 'Location: ./../home.php' ); //redirect if not authorized
}

include("./../config/dbconfig.php"); //database name and password
include("./../config/opendb.php"); //opens connection to database
include("./../config/functions.php"); //imports external functions

// Query database for all organizations
$query = "SELECT * FROM organization";
$result = mysql_query($query) or die( "ERROR: MySQL statement failed.<br />\n" );

// Open the file to write.
$outfile = fopen( "organization.csv", "w" );
$file = true;
if(!$outfile) {
	$file = false;
}

//Check to see if file opened properly
if($file){
	print "Writing to organization.csv.<br />\n";
} else {
	print "ERROR: Could not write to organization.csv.<br />Please use the printout below:<br /><br />\n";
}

// Number of fields returned by the query
$num_fields = mysql_num_fields($result);

//Print out column names, looping through each field, skipping the last
for($i=0;$i<$num_fields-1;$i++) {
	fwrite($outfile,'"'.mysql_field_name($result,$i ).'",' );
	print '"'.mysql_field_name($result,$i).'",';
}
//Now print the last field without a comma
fwrite($outfile,'"'.mysql_field_name($result, $num_fields-1 ).'",' );
print '"'.mysql_field_name($result,$num_fields-1 ).'"';
//end the line with a newline/breaking element
fwrite($outfile,"\n" );
print "<br />\n";

//Print the data by looping through each row of the result
while($row = mysql_fetch_array($result)) {
	//Loop through each field in the row, skipping the last one
	for( $i = 0; $i < $num_fields - 1; $i++ ){
		fwrite( $outfile,'"'.$row[ $i ].'",');
		print '"'.$row[ $i ].'",';
	}
	//Now print the last field without a comma
	fwrite( $outfile,'"'.$row[$numfields-1].'"');
	print '"'.$row[ $num_fields-1 ].'"';
	//Print a newline/breaking element at the end of the row
	fwrite( $outfile,"\n");
	print "<br />\n";
}

//Close the file for reading and downloading
if(!fclose($outfile)) {
	print "ERROR: Could not close organization.csv.<br />\n";	
} else {
	print "Finished writing to organization.csv.<br />\n";
}

include("./../config/closedb.php"); //close database connection
//redirect to download
print "<meta http-equiv=\"Refresh\" content=\"0;url=./organization.csv\" />";
?>
