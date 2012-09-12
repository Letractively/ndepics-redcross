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
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// organizationsearch.php - the search results page;
//****************************

include("../html_include_1.php");
echo "<title>St. Joseph Red Cross - Search Results</title>";
include("../html_include_2.php");

// Search paging variables

$results_per_page = $_POST['results_per_page'];
if(!isset($results_per_page)) {
	$results_per_page = 5;
}

$search_result_start = $_GET['start'];
if(!isset($search_result_start)) {
	$search_result_start = 0;
}


print "<center><h1>Search Results</h1></center>";
print "<hr>";

//Search type
$search_type = $_POST['search_type'];

//print "Search type is: ".$search_type."<br>";

if($search_type == "general") {

	$search = scrub_search($_POST['general_search']);
	$query = '';
	
	print "<h3><center>General Search</center></h3>";
	
	print "Searching for matches to: \"".$search."\"<br>";
	
	$matchterms = "O.organization_name, O.street_address, O.city, O.state, O.zip, O.county, O.website, O.email";
	$matchterms .= ", DR.resource_type, DR.description, DR.keyword";
	$matchterms .= ", P.salutation, P.first_name, P.last_name, P.street_address, P.city, P.state, P.zip, P.email, P.im";

	
	$query = "SELECT	DISTINCT O.* 
			  FROM		organization O, detailed_resource DR, person P
			  WHERE		MATCH(".$matchterms.") AGAINST (\"".$search."\" IN BOOLEAN MODE )";
			  
	

}
elseif($search_type == "organization") {

	print "<h3><center>Searching based on Organization</center></h3>";

	//
	// Get and clean up the inputs

	$search	= scrub_search($_POST['general_org_search']);
	$query = '';

	//print "Search is: ".$search."<br>";


	print "Searching for organizations matching: \"".$search."\"<br>";
	$matchterms = "organization_name, street_address, city, state, zip, county, website, email";
	$table = "organization";

	$query = "SELECT *
			  FROM ".$table."
			  WHERE MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
				  

}
elseif($search_type == "detailed_organization") {

	print "<h3><center>Searching based on Organization</center></h3>";

	//
	// Get and clean up the inputs


	$org_name_search	= scrub_search($_POST['org_name_search']);
	$org_city_search	= scrub_search($_POST['org_city_search']);
	$org_state_search	= scrub_search($_POST['org_state_search']);
	$org_zip_search		= scrub_search($_POST['org_zip_search']);
	$org_county_search	= scrub_search($_POST['org_county_search']);

	
	print "Searching for organizations matching the following inputs:<br>";
	print			   "<br>Organization: ".$org_name_search;
	print			   "<br>City: ".$org_city_search;
	print			   "<br>State: ".$org_state_search;
	print			   "<br>Zip: ".$org_zip_search;
	print			   "<br>County: ".$org_county_search."<br><br>";

	
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

} // end building query based on organization search
elseif ($search_type == "resource") {
	print "<h3><center>Searching based on Resource</center></h3>";

	$search = scrub_search($_POST['keyword_resource_search']);
	$query = '';
	
	$resource_id = $_POST['resource_id'];
	
	$query =	  "SELECT	*
				  FROM		organization O 
				  JOIN		(resource_listing RL, detailed_resource DR)
				  ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)";
	
	if($resource_id != "NULL") {
	
		$resource_query = "SELECT	resource_type
						   FROM		detailed_resource
						   WHERE	resource_id = ".$resource_id;
						   
		$resource_result = mysql_query($resource_query) or die ("Couldn't get resource name");
		$resource_row = mysql_fetch_assoc($resource_result);
		
		print "Searching for organizations with the resource: ".$resource_row['resource_type']."<br>";
		$and = 1;
		$query .=	" AND (RL.resource_id = ".$resource_id;
	}
	
	if($search != '') {
		print "Searching resources matching: \"".$search."\"<br>";
		$matchterms = "resource_type, description, keyword";
		
		if($and) {
			$query .= " OR	MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
		}
		else {
			$query .= " AND MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
		}
	}
	
	if($and) { $query .= ")"; }
							

} // end bulding query based on resource search

/////////////////////////////////
/////////////////////////////////PERSON/////////////
/////////////////////////////////
/////////////////////////////////
elseif($search_type == "person") {
	print "<h3><center>Searching based on Person</center></h3>";

	//
	// Get and clean up the inputs

	$search	= scrub_search($_POST['general_pers_search']);
	$query = '';

	//print "Search is: ".$search."<br>";


	print "Searching for persons matching: \"".$search."\"<br>";
	$matchterms = "first_name, last_name, street_address, city, state, zip, home_phone, work_phone, mobile_phone, fax, email, im";
	$table = "person";

	$query = "SELECT *
			  FROM ".$table."
			  WHERE MATCH(".$matchterms.") AGAINST('".$search."' IN BOOLEAN MODE )";
			  
}


//print "<br><b>Query is: \" ".$query." \"</b><br><br>";
if($search_type == "person"){
	$query .= "LIMIT ".$search_result_start.",".$results_per_page;
	$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");
	$num_results = mysql_num_rows($result);
	
	print "<table>";
	print "<tr>";
		print "<td align=left valign=top width=\"50%\">";
		print "<td align=left valign=top width=\"50%\">";
	print "</tr>";
	
	while ( $row = mysql_fetch_assoc($result) ) {
	 
		print "<tr>";
		print "<td>";
		print "<b><a href=\"../personinfo.php?id=".$row['person_id']."\">".
			   //$row['salutation']." ".$row['first_name']." ".$row['last_name']."</a></b><br>".
			   check_name($row['salutation'], $row['first_name'], $row['last_name'])."</a></b><br>".
			   check_address($row['street_address'])."<br>".
			   //$row['city'].", ".$row['state']." ".$row['zip']."<br>
			   check_address2( $row['city'], $row['state'], $row['zip'])."<br>
			   Home:  ".print_phone($row['home_phone'])."<br>
			   e-mail:  ".$row['email']."<br>";
		print "</td>";
			   
			   
		//
		// Display resources associated with the organization
		$org_query = "SELECT	*
						   FROM		organization O
						   JOIN		(works_for WF, person P) 
						   ON		(P.person_id = WF.person_id AND WF.organization_id = O.organization_id)
						   AND		P.person_id = ".$row['person_id'];
							  
		$org_result = mysql_query($org_query) 
							or die ("Couldn't retrieve organizations for ".$row['Salutation']." ".$row['first_name']." ".$row['last_name'].". Please try again.");
	
		print "<td>";
		print "<b>Available Organizations:</b><br>";
		$org_count = 0;
		while( $org_row = mysql_fetch_assoc($org_result) ) {
			$org_count += 1;
			print $org_row['organization_name']."<br>";
		}
		if ($org_count == 0) {
			print "No available organizations.<br>";
		}
		
		print "</td>";
	print "</tr>";
	
	}
	
	if ($num_results == 0) {
		print "<br> Sorry, your search did not return any matching organizations.<br>";
	}
}


if($search_type != "person"){
	$query .= "LIMIT ".$search_result_start.",".$results_per_page;
	$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");
	$num_results = mysql_num_rows($result);
	
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
	
	if ($num_results == 0) {
		print "<br> Sorry, your search did not return any matching organizations.<br>";
	}
}

print "</table>";
			
print "<br>";

// Print the links to different results pages
if($num_results > $results_per_page) {
	$pages = intval($num_results/$results_per_page);
	if($num_results%$results_per_page) {
		$pages++;
	}
	$curr_page = ($search_result_start/$results_per_page);
	
	print "Results: ";
	if($curr_page != 0) {
		print "<a href=\"".$PHP_SELF."?start=".(($curr_page-1)*$results_per_page."\"> &lt;&lt; Previous </a>";
	}
	for ($i = 0 ; $i < $pages ; $i++) {
	
		$temp_start = ($i*$results_per_page) + 1;
		$temp_end = ($temp_start-1) + $results_per_page;
		if($i != $curr_page) {
			print "<a href=\"".$PHP_SELF."?start=".($temp_start - 1)."\">";
		}
		print "&nbsp;".$temp_start."-".$temp_end;
		if($i != $curr_page) { print "</a>"; }
	}
	if($curr_page != $pages) {
		print "<a href=\"".$PHP_SELF."?start=".(($curr_page+1)*$results_per_page)."\"> Next &gt;&gt; </a>";
	}
	print "<br>";
}

print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "<br></div>";
			   	   

include ("./../config/closedb.php");

include("../html_include_3.php");
?>