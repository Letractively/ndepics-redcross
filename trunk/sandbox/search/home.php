<?php
session_start();
echo "<title>St. Joseph Red Cross - Redirect</title>";
$redirect_url = "../home.php";
print "<h3>Redirecting to search page...</h3>";
print "<meta http-equiv=\"Refresh\" content=\"0.1; url=".$redirect_url."\">";
?>