<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// changeProfile.php - This uses PHP to obtain the information necessary to change the user's profile.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

print "<form action='changeProfile2.php' method='post'>";
	print "<table>";
		print "<tr>";
			print "<td>Password </td>";
			print "<td><input type='password' name='password'></td>";
		print "</tr>";

		print "<tr>";
			print "<td>New E-mail </td>";
			print "<td><input type='text' name='newEmail1'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Confirm New E-mail </td>";
			print "<td><input type='text' name='newEmail2'></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>New Cell Phone Number</td>";
			print "<td><input type='number' name='newCellPhone1' maxlength='10' onKeyPress='return numbersOnly(event)'></td>";
		print "</tr>";
		print "<tr>";
			print "<td>Confirm New Cell Phone Number</td>";
			print "<td><input type='number' name='newCellPhone2' maxlength='10' onKeyPress='return numbersOnly(event)''></td>";
		print "</tr>";
		
		print "<tr>";
			print "<td>New Cell Phone Carrier</td>";
			print "<td>";
				print "<select name='newCellCarrier1'>";
					print "<option></option>";
					print "<option>Alltel</option>";
					print "<option>AT&T</option>";
					print "<option>Cingular</option>";
					print "<option>Nextel</option>";
					print "<option>Sprint</option>";
					print "<option>T-Mobile</option>";
					print "<option>Virgin Mobile</option>";
					print "<option>Verizon</option>";
					print "<option>Other</option>";
				print "</select>";
			print "</td>";
		print "</tr>";
		
		print "<tr>";
			print "<td></td>";
			print "<td>";
				print "<input type='submit' value='Change Profile'>";
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