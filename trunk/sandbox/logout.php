<?php
session_start();
// Set the session variables back to empty
$_SESSION['valid'] = '';
$_SESSION['user_id'] = '';
$_SESSION['access_level_id'] = '';
// Redirect	
header( 'Location: ./index.php' );
?>
