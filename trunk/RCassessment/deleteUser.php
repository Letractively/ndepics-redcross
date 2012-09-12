<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// deleteUser.php - This uses PHP to obtain relevant variables from an admin to delete a user.
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

print "<div id='centerText'>";
	print "<form action='deleteUser2.php' method='post'>";
		print "<table>";
			print "<tr><td>";
				print "Choose a user to delete";
			print "</td></tr>";
			
			// This obtains all the users in the database.
			$query = "SELECT * FROM users";
			$result = mysql_query($query) or die(mysql_error()); 
			
			print "<tr><td>";
				print "<select name='delUser'>";
					print "<option value=''></option>";
					// This prints all the users in the database.
					while($person = mysql_fetch_array($result)){ 
						print "<option value='".$person['username']."'>".$person['username']."</option>";
					}
				print "</select>";
			print "</td></tr>";
			
			print "<tr><td>";
				print "<input type='submit' value='Delete User'>";
			print "</td></tr>";
			print "<tr>";
				print "<td><input type='button' value='Go Back' onClick='history.go(-1)'";
			print "</tr>";
		print "</table>";
	print "</form>";
print "</div>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>