<?php
function scrub_input($input_text) {
	$output_text = stripslashes($input_text);
       // $replace_chars = array("'", """);

	//$output_text = str_replace($replace_chars, "", $output_text);

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

?>
