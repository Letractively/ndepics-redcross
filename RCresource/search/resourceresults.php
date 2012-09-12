<?php

//error_reporting(E_ALL);
//ini_set ('display_errors', '1');

session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./../index.php' );
}

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");
include("../html_include_1.php");echo "<title>St. Joseph Red Cross - Resource Search Results</title>";include("../html_include_2.php");
print "<center><h2>Resource Search Results</h2></center>";
print "<hr>";

print "<div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</div>";

//Search type
$search_type = $_SESSION['search_type'];
$search = scrub_search($_SESSION['search_text']);
$resource_id = $_SESSION['resource_id'];


//
// Get the paging values.  Defaults are set to starting record = 0 and results per page = 10
//
if(isset($_GET['num'])) {
	$results_per_page = $_GET['num'];
} else {
	$results_per_page = 10;
}


if(isset($_GET['start'])) {
	$search_result_start = $_GET['start'];
} else {
	$search_result_start = 0;
}


//
// Display the page

$query = '';
$and = 0;

$query =	  "SELECT	*
			  FROM		organization O 
			  JOIN		(resource_listing RL, detailed_resource DR)
			  ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)";

if($resource_id != "NULL") {

	$resource_query = "SELECT	resource_type, description, keyword
					   FROM		detailed_resource
					   WHERE	resource_id = ".$resource_id;
					   
	$resource_result = mysql_query($resource_query) or die ("Couldn't get resource name");
	$resource_row = mysql_fetch_assoc($resource_result);
	
	print "<h3><center>Searching for organizations with the resource: ".$resource_row['resource_type']."</center></h3>\n";
	print "<center><table border=\"\1\"><tr><th>Type of Resource</th><th>Description</th><th>Keyword(s)</th></tr>\n";
	print "<td>".$resource_row['resource_type']."</td><td>".$resource_row['description']."</td><td>".$resource_row['keyword']."</td></tr>";
	print "</table></center><br />\n";	
	$and = 1;
	$query .=	" AND (RL.resource_id = ".$resource_id;
}

if($search != '') {
	print "<h3><center>Searching for organizations with the resource: \"".$search."\"</center></h3>";
	$matchterms = "resource_type, description, keyword";
	
	if($and) {
		$query .= " OR	MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
	}
	else {
		$query .= " AND MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
	}
}

if($and) { $query .= ")"; }

$query .= "ORDER BY O.organization_name";
				
//
// Execute Query
$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");
$num_results = mysql_num_rows($result);

// Add paging values to the query and run it again
$query .= " LIMIT ".$search_result_start.",".$results_per_page;
$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");

//
// Print the links to different results pages
print "<center>";
if ($num_results > 10 && $num_results < $results_per_page ){
	print "<a href=\"".$PHP_SELF."?start=0&num=10\">10 per Page</a><br/></a>";
}
if ($num_results > $results_per_page) {

	// Find the number of pages to break the results into
	$pages = intval($num_results/$results_per_page);
	
	$curr_page = ($search_result_start/$results_per_page);
	
	//
	// Print the different numbered results pages
	//print "Results: ";
	print "<a href=\"".$PHP_SELF."?start=0&num=10000\">All</a><br/>\n";

	if ($curr_page != 0) {
		print "<a href=\"".$PHP_SELF."?start=".(($curr_page-1)*$results_per_page)."&num=".$results_per_page."\"> &lt;&lt; Previous </a>";
	}

	for ($i = 0; $i < $pages+1 ; $i++) {
	
		$temp_start = ($i*$results_per_page) + 1;
		$temp_end = ($temp_start-1) + $results_per_page;
		if ($temp_end > $num_results) { $temp_end = $num_results; }
		
		print "&nbsp;";
		if($i != $curr_page) {
			print "<a href=\"".$PHP_SELF."?start=".($temp_start - 1)."&num=".$results_per_page."\">";
		}
		else {
			$curr_start = $temp_start;
			$curr_end = $temp_end;
		}
		print $temp_start."-".$temp_end;
		if($i != $curr_page) { print "</a>"; }
		print "&nbsp;";
		
	}

	if ($curr_page != $pages) {
		print "<a href=\"".$PHP_SELF."?start=".(($curr_page+1)*$results_per_page)."&num=".$results_per_page."\"> Next &gt;&gt; </a>";
	}
	
	print "<br>";
}
print "</center>";


//
// Print the results of the search
//

if($num_results != 0) {

	if($num_results > $results_per_page) {
		print "<h4>Displaying results ".$curr_start." through ".$curr_end." out of ".$num_results." results.</h4>";
	}
	else {
		print "<h4>Displaying results 1 through ".$num_results." out of ".$num_results." results.</h4>";

	}
}


print "<table>";
print "<tr>";
	print "<td align=left valign=top width=\"50%\">";
	print "<td align=left valign=top width=\"50%\">";
print "</tr>";

while ( $row = mysql_fetch_assoc($result) ) {
 
	print "<tr>";
	print "<td>";
	print "<b><a href=\"../organizationinfo.php?id=".$row['organization_id']."\">".
		   $row['organization_name']."</a></b><br>".
		   $row['street_address']."<br>".
		   $row['city'].", ".$row['state']." ".$row['zip']."<br>".
		   $row['county']." County<br>
		   Ph:  ".print_phone($row['business_phone'])."<br>
		   Fax: ".print_phone($row['business_fax'])."<br>";
	print "</td>";
		   
		   
	//
	// Display resources associated with the organization
	$resource_query = "SELECT	*
					   FROM		detailed_resource DR
					   JOIN		(resource_listing RL, organization O) 
					   ON		(O.organization_id = RL.organization_id AND RL.resource_id = DR.resource_id)
					   AND		O.organization_id = ".$row['organization_id'];
						  
	$resource_result = mysql_query($resource_query) 
						or die ("Couldn't retrieve resources for ".$row['organization_name'].". Please try again.");

	$resources = mysql_num_rows($resource_result);
	print "<td>";
	print "<b>Available Resources:</b><br>";

	while( $resource_row = mysql_fetch_assoc($resource_result) ) {
		print $resource_row['resource_type']."<br>";
	}
	if ($resources == 0) {
		print "No available resources.<br>";
	}
	print "</td>";
print "</tr>";

}

print "</table>";

if ($num_results == 0) {
	print "<br>Sorry, your search did not return any matching organizations.<br>";
}

//
// Print the links to different results pages
print "<center>";
if ($num_results > 10 && $num_results < $results_per_page ){
	print "<a href=\"".$PHP_SELF."?start=0&num=10\">10 per Page</a><br/></a>";
}
if ($num_results > $results_per_page) {

	// Find the number of pages to break the results into
	$pages = intval($num_results/$results_per_page);
	
	$curr_page = ($search_result_start/$results_per_page);
	
	//
	// Print the different numbered results pages
	//print "Results: ";
	print "<a href=\"".$PHP_SELF."?start=0&num=10000\">All</a><br/>\n";

	if ($curr_page != 0) {
		print "<a href=\"".$PHP_SELF."?start=".(($curr_page-1)*$results_per_page)."&num=".$results_per_page."\"> &lt;&lt; Previous </a>";
	}

	for ($i = 0; $i < $pages+1 ; $i++) {
	
		$temp_start = ($i*$results_per_page) + 1;
		$temp_end = ($temp_start-1) + $results_per_page;
		if ($temp_end > $num_results) { $temp_end = $num_results; }
		
		print "&nbsp;";
		if($i != $curr_page) {
			print "<a href=\"".$PHP_SELF."?start=".($temp_start - 1)."&num=".$results_per_page."\">";
		}
		print $temp_start."-".$temp_end;
		if($i != $curr_page) { print "</a>"; }
		print "&nbsp;";
		
	}

	if ($curr_page != $pages) {
		print "<a href=\"".$PHP_SELF."?start=".(($curr_page+1)*$results_per_page)."&num=".$results_per_page."\"> Next &gt;&gt; </a>";
	}
	
	print "<br>";
}
print "</center>";
			
print "<br><div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "<br></div>";
			   	   

include ("./../config/closedb.php");
include("../html_include_3.php");
?>