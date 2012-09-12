<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// logout.php - This sets all the session variables to empty strings and then destroys the session.
//************************************

session_start();

include("./config/functions.php");

$_SESSION["valid"] = "";
$_SESSION["username"] = "";
$_SESSION["authority"] = "";
$_SESSION["message"] = "";

session_destroy();

header("Location: ./index.php"); 
?>