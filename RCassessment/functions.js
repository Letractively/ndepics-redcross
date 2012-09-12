//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// functions.js - This is an external Javascript file with functions used throughout the website.
//************************************/

// If the user has Javascript disabled, then the contents of this file are commented out in HTML.
<!--
// Pre-conditions: Input an object (typically a string).
// Purpose: This function is used for debugging purposes.
// Post-conditions: Output an alert box with the object (typically a string). Waits for the user to press OK.
function display(temp){
	alert(temp);
	return false;
}

// Pre-conditions: Input the event triggered by keyPress.
// Courtesy of: http://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onkeydown
// Purpose: This is because HTML5 is still under development and not all browsers support the input type='number'.
// Post-conditions: Outputs true if the backspace key or a number is selected. Outputs false otherwise.
function numbersOnly(e){
	var keynum;
	var keychar;
	var numcheck;

	// IE8 and earlier (For goodness sake, update your web browser).
	if(window.event){ 
		keynum = e.keyCode;
	}
	// IE9/Firefox/Chrome/Opera/Safari (or ditch IE for another browser).
	else if(e.which){ 
		keynum = e.which;
	}	

	// This allows the usage of the backspace key, period character, subtraction character.
	if(keynum == 8 || keynum == 46 || keynum == 45){
		return true;
	}
	
	// This converts a unicode number into a character.
	keychar = String.fromCharCode(keynum);
	
	// This checks whether the character is a digit.
	numcheck = /\d/;
	return numcheck.test(keychar);
}

// Pre-conditions: Input two strings defining the term being searched and order to be sorted in which is triggered by onClick.
// Purpose: This sort the search results that are displayed using PHP's GET method.
// Post-conditions: Changes the current address with new sort parameters (term and order).
function search(term, order){
	
	// If the current order is ascending then it should be changed to descending.
	if(order == "ASC"){
		order = "DESC";
	}
	// If the current order is descending then it should be changed to ascending.
	else{
		order = "ASC";
	}
	
	// This obtains the current web address.
	currentURL = document.URL;
	
	// This gets the address up to but not including sortTerm (and sortOrder which follows afterward). 
	cutoff = currentURL.indexOf("&sortTerm=");
	
	// This changes the address to include the new sortTerm and new sortOrder.
	newURL = currentURL.slice(0, cutoff) + "&sortTerm=" + term + "&sortOrder=" + order;
	
	// This changes the current web address to the newly defined address.
	window.location.href = newURL;
	
	return true;
}
// -->