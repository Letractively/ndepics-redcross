<?php

session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./../index.php' );
}

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Author: Rob Wettach
//  Fall 2009
//
// org_csv.php - outputs the organization table in CSV format.  
//
//****************************

// Get the table from the URL.

// Get all the data from the given table.
$query = "SELECT * FROM organization";
$result = mysql_query( $query );

if( !$result ){
	die( "ERROR: MySQL statement failed.<br />\n" );
}

// Open the file to write.
$outfile = fopen( "org_csv.csv", "w" );
$file = true;
if( ! $outfile ){
	$file = false;
}

if( $file ){
	print "Writing to org_csv.csv.<br />\n";
}

// Number of fields.
$num_fields = mysql_num_fields( $result);

// Print out the column names.
for( $i = 0; $i < $num_fields - 1; $i++ ){
	if( $file && !fwrite( $outfile, '"'.mysql_field_name( $result, $i ).'",' ) ){
		die( "ERROR: Could not write to org_csv.csv.<br />\n" );
	}
	else{
		print '"'.mysql_field_name( $result, $i ).'",';
	}
}

if( $file && !fwrite( $outfile, '"'.mysql_field_name( $result, $num_fields-1 ).'",' ) ){
	die( "ERROR: Could not write to org_csv.csv.<br />\n" );
}
else{
	print '"'.mysql_field_name( $result, $num_fields-1 ).'"';
}
	
if( $file && !fwrite( $outfile, "\n" ) ){
	die( "ERROR: Could not write to org_csv.csv.<br />\n" );
}
else{
	print "<br />\n";
}


// Loop through each row of the result.
while( $row = mysql_fetch_array( $result ) ){
	// Loop through each element of the result row, printing the value.
	for( $i = 0; $i < $num_fields - 1; $i++ ){
		if( $file && !fwrite( $outfile, '"'.$row[ $i ].'",' ) ){
			die( "ERROR: Could not write to org_csv.csv.<br />\n" );
		}
		else{
			print '"'.$row[ $i ].'",';
		}
	}
	
	if( $file && !fwrite( $outfile, '"'.$row[ $numfields-1 ].'"' ) ){
		die( "ERROR: Could not write to org_csv.csv.<br />\n" );
	}
	else{
		print '"'.$row[ $num_fields-1 ].'"';
	}
	
	if( $file && !fwrite( $outfile, "\n" ) ){
		die( "ERROR: Could not write to org_csv.csv.<br />\n" );
	}
	else{
		print "<br />\n";
	}
}

if( $file && !fclose( $outfile ) ){
	die( "ERROR: Could not close org_csv.csv.<br />\n" );	
}

if( $file ){
	print "Finished writing to org_csv.csv.<br />\n";
}
?>
