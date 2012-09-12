<?php
session_start();

//
// File to be used to show user information when modifying or deleting a user
//

include ("./../config/dbconfig.php");
include ("./../config/opendb.php");
include ("./../config/functions.php");

$user_id = $_GET['user'];

$sql= "	SELECT u.username, u.email, al.* 
		FROM users u, access_level al 
		WHERE u.user_id = '".$user_id."'
		AND   u.access_level_id = al.access_level_id";

$result = mysql_query($sql);

print "<table border='1' align=\"center\">
<tr>
<th>Username</th>
<th>Email</th>
<th>Admin</th>
<th>Search</th>
<th>Insert</th>
<th>Delete</th>
<th>Update</th>
</tr>";

while($row = mysql_fetch_assoc($result))
 {
 print "<tr>";
 print "<td>" . $row['username'] . "</td>";
 print "<td>" . $row['email'] . "</td>";
 print "<td>" . ($row['Admin']?'x':'-') . "</td>";
 print "<td>" . ($row['Search']?'x':'-') . "</td>";
 print "<td>" . ($row['Insert']?'x':'-') . "</td>";
 print "<td>" . ($row['Delete']?'x':'-') . "</td>";
 print "<td>" . ($row['Update']?'x':'-') . "</td>";
 print "</tr>";
 }
echo "</table>";

include ("./../config/closedb.php");

?>
