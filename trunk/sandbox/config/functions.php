<?php

error_reporting(E_ERROR); //set site-wide level of error reporting.
//error_reporting(E_ALL);

function scrub_input($input_text) {
	$output_text = stripslashes($input_text);
	return $output_text;
}

function scrub_search($input_search) {

	if($input_search == "") {
		return "";
	}

	$cleaned_search = stripslashes($input_search);
	$cleaned_search = strtolower($cleaned_search);
	
	//
	// Remove the commas from separated lists
	$cleaned_search = str_replace(", ", " ", $cleaned_search);
	
	// Replace theses characters in the string with the _ character
	//	 This is so mysql can use a wildcard to search 
	$replace_chars = array("&", "'", ";");
	$cleaned_search = str_replace($replace_chars, "_", $cleaned_search);

	return $cleaned_search;
}

function print_phone($phone_number) {

	if($phone_number == "") {
		return "Nothing was entered";
	}

	$printed_form = "(" . substr($phone_number,0,3) . ") "
					   . substr($phone_number,3,3) . " - "
					   . substr($phone_number,6,4);
					   
	return $printed_form;
}

//Data validation function.  Only the first three fields are required.
function validator($field_descr, $field_data, $field_type, $min_length="", $max_length="", $field_required=1) 
{
  //array for storing error messages
  global $messages;
  
  //first, if no data and field is not required, return
  if(!$field_data && !$field_required)
    return;

  //initialize a flag variable - used to flag whether data is valid or not
  $field_ok = false;


  //a hash array of "types of data" pointing to regular expressions  used to validate the data
  $data_types=array(
		    "email"=>"^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$",
		    "digit"=>"^[0-9]$",
		    "number"=>"^[0-9]+$",
		    "alpha"=>"^[a-zA-Z]+$",
		    "alpha_space"=>"^[a-zA-Z ]+$",
		    "alphanumeric"=>"^[a-zA-Z0-9]+$",
		    "alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",
		    "string"=>""
		    //"alphadash"=>"^[a-zA-Z-]+$";
		    //"alphanumeric_symbol"=>"^[_!@#$%&*-+=a-zA-Z0-9]+$";
		    );
  
  //check for required fields
  if ($field_required && empty($field_data)) {
    $messages[] = "$field_descr is a required field.";
    return;
  }
  
  //if field type is a string, no need to check regular expression
  if ($field_type == "string") {
    $field_ok = true;
  } else {
    //Check the field data against the regexp pattern
    if ($field_type == "email")
      $field_ok = eregi($data_types[$field_type], $field_data);
    else
      $field_ok = ereg($data_types[$field_type], $field_data);
  }
  
  //if field data is bad, add message
  if (!$field_ok) {
    $messages[] = "Please enter a valid $field_descr.";
    return;
  }
  
  //field data max length checking
  if ($field_ok && ($min_length || $max_length)) {
    if (strlen($field_data) > $max_length)
      $messages[] = "$field_descr is invalid, it should be at most $max_length characters.";
    if (strlen($field_data) < $min_length)
      $messages[] = "$field_descr is invalid, it should be at least $min_length characters.";
  }
  return;
}


//
// The following function has been taken from http://www.totallyphp.co.uk/code/create_a_random_password.htm
//

function createRandomPassword() { 

	/** 
	 * The letter l (lowercase L) and the number 1 
	 * have been removed, as they can be mistaken 
	 * for each other. 
	 */ 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

} 

function check_address($input){

	if($input == "") {
		return "No Address Entered";
	}
	
	return $input;
}

function check_address2($city, $state, $zip){
	if( ($city == "") && ($state == "") && ($zip == "") ){
		return "No City, State, or Zip";
	}
	elseif( ($city == "") ){
		return $state." ".$zip;
	}
	
	return $city.", ".$state." ".$zip;
}


function check_name($salutation, $first, $last){

	if( ($salutation == "") && ($first == "") && ($last == "") ){
		return "No Name";
	}

	return $salutation." ".$first." ".$last;	
}

function display_generic_error($error_message) {

	$return_message =  "<center><h2>Error Processing Your Request</h2></center>";
	$return_message .= "<center><h3>".$error_message."</h3></center>";
	$return_message .= "<br><br>Please go back and try again or return home.  If the problem persists, please contact a system administrator.<br><br>";
	
	$return_message .=  "<br><div align = 'center'>\n";
	$return_message .=  "<form>\n";
	$return_message .=  "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">\n";
	$return_message .=  "</form>\n";
	$return_message .=  "<br></div>\n";
	
	return $return_message;

}

function html_loginbox() {
	$html = "<form action=\"login.php\" method=\"post\">   
    <table style=\"border: 1px solid black; margin: 10px; padding: 0px\" cellspacing='0' cellpadding='1'>
		<tr> 
			<td style=\"padding: 5px\" align='left'><b>Username:</b></td> 
			<td style=\"padding: 5px\" align='left'><input type ='text' name='username' size=\"20\"></td>
		</tr>

		<tr> 
			<td style=\"padding: 5px\" align='left'><b>Password:</b></td> 
			<td style=\"padding: 5px\" align='left'><input name='password' type ='password' size=\"21\">
			</td>
		</tr>

		<tr> 
			<td  style=\"padding: 5px\"align='center'>
			<input type='submit' value='Log In'>
			<input type='reset' value='Reset'>
			</td> 
		</tr>
	</table>
</form>";
	return $html;
}

function html_forgotuserpass() {
	$html = "<table border='0' cellspacing='0' cellpadding='1'>
	<tr>
		<td><form action=\"retrieveuserinfo.php\" method=\"post\">
			<input type=\"hidden\" name=\"forgot\" value=\"username\">
			<input type=\"submit\" value=\"Forget your username?\">
			</form>
		</td>
		<td><form action=\"retrieveuserinfo.php\" method=\"post\">
			<input type=\"hidden\" name=\"forgot\" value=\"password\">
			<input type=\"submit\" value=\"Forget your password?\">
			</form>
		</td>
	</tr>
</table>";
	return $html;
}

function html_navmenu() {
	$html = "<div class=\"menu\">
<center>
<ul>
<li><a href = \"./home.php\" target= \"_parent\">Home</a></li>
<li><a href = \"./search.php\" target= \"_parent\">Search the Database</a></li>
<li><a href = \"./sitemap.php\" target =\"_parent\">Site Map</a></li>
<li><a href = \"mailto:epics2@nd.edu\" target= \"_parent\">Report A Problem</a></li>
<li><a href = \"./logout.php\" target= \"_parent\">Log Out</a></li>
</ul>
</center>
</div>";
	return $html;
}
?>