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
include("../html_include_1.php");
echo "<title>St. Joseph Red Cross - Search All Resources</title>";
include("../html_include_2.php");

print "<center><h2>All Resources</h2></center>";
print "<hr>";

print "<div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</div>";


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

$query =	  "SELECT * FROM detailed_resource ORDER BY resource_type";
				
//
// Execute Query
$result = mysql_query($query) or die ("Query did not run correctly. Please try again.");
$num_results = mysql_num_rows($result);

// Add paging values to the query and run it again
$query .= " LIMIT ".$search_result_start.",".$results_per_page;
$result = mysql_query($query) or die ("Query did not run correctly. Please try again.");

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


print "\n\n<table style=\"border: 1px solid black\">\n";
print "<tr><th>Resource Type</th><th>Description</th><th>Keywords</th></tr>\n";


while ( $row = mysql_fetch_assoc($result) ) {
 
	print "<tr>";
	print "<td>";
	print "<b><a href=\"../resourceinfo.php?id=".$row['resource_id']."\">".
		   $row['resource_type']."</a></b>";
	print "</td>";
	print "<td>".$row['description']."</td>";
	print "<td>".$row['keyword']."</td>";
		   
	
print "</tr>\n";

}

print "</table>\n\n";

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
	print "<a href=\"".$PHP_SELF."?start_r=0&num_r=10000\">All</a><br/>\n";

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
