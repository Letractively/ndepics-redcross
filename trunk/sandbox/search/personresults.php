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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Search Results</title>

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
error_reporting(E_ALL);

ini_set ('display_errors', '1');


print "<center><h2>Search Results</h2></center>";
print "<hr>";

print "<div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</div>";

//Search type
$search_type = $_POST['search_type'];

//print "Search type is: ".$search_type."<br>";

/*
 *
 * PERSON
 *
 */
 
if($search_type == "person") {
	print "<h3><center>Searching based on Person</center></h3>";

	//
	// Get and clean up the inputs

	$search	= scrub_search($_POST['general_pers_search']);
	$query = '';

	//print "Search is: ".$search."<br>";


	print "Searching for persons matching: \"".$search."\"<br>";
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
			$q .= " first_name like '%".$val.
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
				  "%' OR im like '%".$val."%' OR";
		}
	}// end of while
	//remove last OR
	$q=substr($q,0,(strLen($q)-3));
	
	$query = "SELECT * 
			  FROM ".$table." where".$q;
			  
	//print "QUERY: ".$query."\n";
			  
	$result = mysql_query($query) or die ("Search query did not run correctly. Please try again.");
	$num_results = 0;
	
	print "<table>";
	print "<tr>";
		print "<td align=left valign=top width=\"50%\">";
		print "<td align=left valign=top width=\"50%\">";
	print "</tr>";
	
	while ( $row = mysql_fetch_assoc($result) ) {
		$num_results += 1;
	 
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
							or die ("Couldn't retrieve Organizations for ".$row['Salutation']." ".$row['first_name']." ".$row['last_name'].". Please try again.");
	
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



print "</table>";
			
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