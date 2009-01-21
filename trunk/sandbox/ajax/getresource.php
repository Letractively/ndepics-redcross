<?php

//
// File to be used to show resource information when adding an organization
//

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");

$resource_id = $_GET['rsrc'];

$table_name = "detailed_resource";
$matched_attribute = "resource_id";

$sql="SELECT * FROM ".$table_name." WHERE ".$matched_attribute." = '".$resource_id."'";

$result = mysql_query($sql);

print "<table border='1'>
<tr>
<th>Resource</th>
<th>Description</th>
<th>Keyword(s)</th>
</tr>";

while($row = mysql_fetch_assoc($result))
 {
 print "<tr>";
 print "<td>" . $row['resource_type'] . "</td>";
 print "<td>" . $row['description'] . "</td>";
 print "<td>" . $row['keyword'] . "</td>";
 print "</tr>";
 }
echo "</table>";

include ("./../config/closedb.php");

?>