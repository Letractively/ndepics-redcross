<?php
session_start();

include ("./config/dbconfig.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Redirect</title>";
include("html_include_2.php");
	$redirect_url = "../search.php";
	$message .= "Success";
    print "Redirecting...</h3>";
    print "<meta http-equiv=\"Refresh\" content=\"2.5; url=".$redirect_url."\">";
}
include("html_include_3.php"); ?>