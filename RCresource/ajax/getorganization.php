<?php

//
// File to be used to show organization information when adding a person
//

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");

$organization_id = $_GET['q'];

$table_name = "organization";
$matched_attribute = "organization_id";

$sql="SELECT * FROM ".$table_name." WHERE ".$matched_attribute." = '".$organization_id."'";

$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

print "Organization Information<br><br>";

print "<table border='1'>";

print "<tr>";
print	"<td><b>Organization Name</b></td>";
print	"<td>".$row['organization_name']."</td>";
print "</tr>";

print "<tr>";
print	"<td><b>Street Address</b></td>";
print	"<td>".$row['street_address']."</td>";
print "</tr>";

print "<tr>";
print	"<td><b>City</b></td>";
print	"<td>".$row['city']."</td>";
print "</tr>";

print "<tr>";
print	"<td><b>State</b></td>";
print	"<td>".$row['state']."</td>";
print "</tr>";


print "<tr>";
print	"<td><b>ZIP</b></td>";
print	"<td>".$row['zip']."</td>";
print "</tr>";


print "<tr>";
print	"<td><b>County</b></td>";
print	"<td>".$row['county']."</td>";
print "</tr>";

print "</table>";


include ("./../config/closedb.php");

?>