<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// changeUser.php - This uses PHP to obtain the information necessary to change another user's permission.
//************************************

include("./config/check_login.php");
// This is an admin tool, thus check if the current user is an admin.
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

print "<table>";
	print "<form action='changeUser2.php' method='post'>";
		print "<tr><td>";
			print "Choose a user to change";
		print "</td></tr>";
		
		// This obtains all the users in the database.
		$query = "SELECT * FROM users";
		$result = mysql_query($query) or die(mysql_error()); 
			
		print "<tr><td>";
			print "<select name='selUser'>";
				print "<option value=''></option>";
					// This prints all the users in the database.
					while($person = mysql_fetch_array($result)){ 
						print "<option value='".$person['username']."'>".$person['username']."</option>";
					}
				print "</select>";
			print "</td></tr>";
		
		print "<tr>";
			print "<td>Authority:</td>";
		print "</tr>";
		print "<tr>";
			print "<td>Admin</td>";
			print "<td><input type='radio' name='selAuthority' value='admin' /></td>";
		print "</tr>";
		print "<tr>";
			print "<td>User</td>";
			print "<td><input type='radio' name='selAuthority' value='user' /></td>";
		print "</tr>";
				
		print "<tr><td>";
			print "<input type='submit' value='Change User'>";
		print "</td></tr>";	
		print "<tr>";
			print "<td><input type='button' value='Go Back' onClick='history.go(-1)'";
		print "</tr>";
	print "</form>";	
print "</table>";


include("./config/close_html_tags.php");
include("./config/close_database.php");

?>