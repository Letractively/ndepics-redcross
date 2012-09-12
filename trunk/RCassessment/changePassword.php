<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// changePassword.php - This uses PHP to obtain the information necessary to change the user's password.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

print "<form action='changePassword2.php' method='post'>";
	print "<table>";
		print "<tr>";
			print "<td>Current Password </td>";
			print "<td><input type='password' name='currentPassword'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>New Password </td>";
			print "<td><input type='password' name='newPassword1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Confirm New Password </td>";
			print "<td><input type='password' name='newPassword2'></td>";
		print "</tr>";
		print "<tr>";
			print "<td></td>";
			print "<td>";
				print "<input type='submit' value='Change Password'>";
				print "<input type='reset' value='Clear Form'>";
			print "</td>";
		print "</tr>";
		print "<tr>";
			print "<td><input type='button' value='Go Back' onClick='history.go(-1)'";
		print "</tr>";
	print "</table>";	
print "</form>";

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>