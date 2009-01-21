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

?>