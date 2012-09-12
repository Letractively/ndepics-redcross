<?php

//************************************
// [SEASON] [YEAR]: [AUTHOR] [(CONTACT)]
// 
// [FILENAME] - PLACE DESCRIPTION HERE
//************************************

include("./config/check_login.php");
if($_SESSION["authority"] != "admin"){
	header( 'Location: ./home.php' );
}
include("./config/functions.php");
include("./config/open_database.php");
include("./config/open_html_tags.php");
include("./config/display_error_message.php");

include("./config/close_html_tags.php");
include("./config/close_database.php");

?>