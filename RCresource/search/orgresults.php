<?php

session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./../index.php' );
}

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");
include("../html_include_1.php");echo "<title>St. Joseph Red Cross - Organization Search Results</title>";include("../html_include_2.php");

print "<center><h2>Organization Search Results</h2></center>";
print "<hr>";

print "<div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</div>";

//
// Get the SESSION variables for searching
//
$search_type = $_SESSION['search_type'];

if($search_type == "organization") {
	$search	= scrub_search($_SESSION['search_text']);
}

elseif ($search_type == "detailed_organization") {
	$org_name_search	= scrub_search($_SESSION['detailed_search_name']);
	$org_city_search	= scrub_search($_SESSION['detailed_search_city']);
	$org_state_search	= scrub_search($_SESSION['detailed_search_state']);
	$org_zip_search		= scrub_search($_SESSION['detailed_search_zip']);
	$org_county_search	= scrub_search($_SESSION['detailed_search_county']);
}

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


//print "Search type is: ".$search_type."<br>";

if($search_type == "organization") {

	print "<h3><center>Searching for organizations matching: \"".$search."\"</center></h3>";
	
	$table = "organization";

	//KEYWORD SEARCH
	$q = "";
	if( ($search{0} == "\"") && ($search{strlen($search)-1} == "\"") ){
		$keywords[0] = substr($search, 1, (strlen($search)-2));
		$keywords[1] = " ";
	}
	else{
		$keywords = split(" ",$search);//Breaking the string to array of words
	}
	// Now let us generate the sql
	while(list($key,$val)= each($keywords)){
		if($val != " " and strlen($val) > 0){
			$q .= " (organization_name like '%".$val.
				  "%' OR street_address like '%".$val.
				  "%' OR city like '%".$val.
				  "%' OR state like '%".$val.
				  "%' OR zip like '%".$val.
				  "%' OR county like '%".$val.
				  "%' OR website like '%".$val.
				  "%' OR email like '%".$val."%') AND";
		}
	}// end of while
	//remove last OR
	$q=substr($q,0,(strLen($q)-3));
	
	$query = '';
	$query = "SELECT * 
			  FROM ".$table." where".$q;
	$query .= "ORDER BY organization_name";
	  
	//print $query."\n";
				  
}

elseif($search_type == "detailed_organization") {

	print "<h3><center>Searching based on Organization</center></h3>";
	
	$and = 0;

	
	print "Searching for organizations matching the following inputs:<br>";
	print			   "<br>Organization: ".$org_name_search;
	print			   "<br>City: ".$org_city_search;
	print			   "<br>State: ".$org_state_search;
	print			   "<br>Zip: ".$org_zip_search;
	print			   "<br>County: ".$org_county_search."<br><br>";

	$query = '';	
	$query = "SELECT * 
			  FROM organization
			  WHERE ( ";
			  		  
	if($org_name_search != "") { 
		$query .= "organization_name LIKE \"%".$org_name_search."%\""; 
		$and = 1;
	}
	
	if($org_city_search != "") {
		if($and == 1) { $query .= " AND "; }
		$and = 1;
		$query .= "city LIKE \"%".$org_city_search."%\"";
	}
	
	if($org_state_search != "") {
		if($and == 1) { $query .= " AND "; }
		$and = 1;
		$query .= "state LIKE \"%".$org_state_search."%\"";
	}
	
	// Add the ZIP code
	if($org_zip_search != "") {
		if($and == 1) { $query .= " AND "; }
		$and = 1;
		$query .= "zip LIKE ".$org_zip_search;
	}
	
	// Add the County
	if($org_county_search != "") {
		if($and == 1) { $query .= " AND "; }
		$and = 1;
		$query .= "county LIKE \"%".$org_county_search."%\"";
	}
	
	$query .= " )";

	$query .= "ORDER BY organization_name";

} // end building query based on organization search

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
if ($num_results > 10 && $num_results < $r_results_per_page ){
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

	print "<td>";
	print "<b>Available Resources:</b><br>";
	$resources = 0;
	while( $resource_row = mysql_fetch_assoc($resource_result) ) {
		$resources += 1;
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
	print "<br> Sorry, your search did not return any matching organizations.<br>";
}

//
// Print the links to different results pages
print "<center>";
if ($num_results > 10 && $num_results < $r_results_per_page ){
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
