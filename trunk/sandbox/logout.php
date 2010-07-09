<?php
session_start(); //resume active session
// Set the session variables back to empty
$_SESSION['valid'] = ''; //invalidate authentication
$_SESSION['user_id'] = ''; //clear user_id
$_SESSION['access_level_id'] = ''; //clear access level
// Redirect	to index/login page
header( 'Location: ./index.php' );
?>
