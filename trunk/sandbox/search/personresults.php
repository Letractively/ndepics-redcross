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
// personresults.php - the search results page for person-based searches.
//
// Revision History		3/23/09 - Mark Pasquier - Created page from previous "huge results page"
//						3/24/09 - Mike Ellerhorst - Changed to SESSION variables & added paging
//
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Person Search Results</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<STYLE type="text/css">
 SPAN { padding-left:3px; padding-right:3px }
 DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
 BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
</STYLE>

</head>

<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="../homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>


<?php
//'
//

//
// Error reporting...only for DEBUGGING
//error_reporting(E_ALL);
//ini_set ('display_errors', '1');


print "<center><h2>Search Results</h2></center>";
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
$search = scrub_search($_SESSION['search_text']);

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
 
print "<h3><center>Searching for persons matching: \"".$search."\"</center></h3>";

$table = "person";

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
		$q .= " (first_name like '%".$val.
			  "%' OR last_name like '%".$val.
			  "%' OR street_address like '%".$val.
			  "%' OR city like '%".$val.
			  "%' OR state like '%".$val.
			  "%' OR zip like '%".$val.
			  "%' OR home_phone like '%".$val.
			  "%' OR work_phone like '%".$val.
			  "%' OR mobile_phone like '%".$val.
			  "%' OR fax like '%".$val.
			  "%' OR email like '%".$val.
			  "%' OR im like '%".$val."%') AND";
	}
}// end of while
//remove last OR
$q=substr($q,0,(strLen($q)-3));

$query = '';
$query = "SELECT * 
		  FROM ".$table." where".$q;

$query .= "ORDER BY last_name";
		  
//print "QUERY: ".$query."\n";

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
	print "<b><a href=\"../personinfo.php?id=".$row['person_id']."\">".
		   //$row['salutation']." ".$row['first_name']." ".$row['last_name']."</a></b><br>".
		   check_name($row['salutation'], $row['first_name'], $row['last_name'])."</a></b><br>".
		   check_address($row['street_address'])."<br>".
		   //$row['city'].", ".$row['state']." ".$row['zip']."<br>
		   check_address2( $row['city'], $row['state'], $row['zip'])."<br>
		   Home:  ".print_phone($row['home_phone'])."<br>
		   e-mail:  <a href=\"mailto:".$row['email']."\">".$row['email']."</a><br>";
	print "</td>";
			  
	//
	// Display resources associated with the organization
	$org_query = "SELECT	*
					   FROM		organization O
					   JOIN		(works_for WF, person P) 
					   ON		(P.person_id = WF.person_id AND WF.organization_id = O.organization_id)
					   AND		P.person_id = ".$row['person_id'];
						  
	$org_result = mysql_query($org_query) 
						or die ("Couldn't retrieve Organizations for ".$row['Salutation']." ".$row['first_name']." ".$row['last_name'].". Please try again.");
	$org_count = mysql_num_rows($org_result);

	print "<td>";
	print "<b>Available Organizations:</b><br>";

	while( $org_row = mysql_fetch_assoc($org_result) ) {
		print $org_row['organization_name']."<br>";
	}
	if ($org_count == 0) {
		print "No available organizations.<br>";
	}
	
	print "</td>";
print "</tr>";

}

print "</table>";
if ($num_results == 0) {
	print "<br> Sorry, your search did not return any matching people.<br>";
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

?>

</div>
</body>
</html>
