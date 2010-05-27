<?php
session_start();
echo "<title>St. Joseph Red Cross - Redirect</title>";
$redirect_url = "../logout.php";
print "<h3>Redirecting to Site Map...</h3>";
print "<meta http-equiv=\"Refresh\" content=\"0.1; url=".$redirect_url."\">";
?>