<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// reportProblem.php - This is used to report a problem to the Google Code wiki.
//************************************

include("./config/check_login.php");

header("Refresh: 5; URL = http://code.google.com/p/ndepics-redcross/issues/entry");
print "We apologize for the inconvenience.<br /> Please report the problem to the Google Code Issue Tracker.<br /> This page will re-direct in five seconds.<br />";
print "If the page does not re-direct, please click the following link.<br />";
print "<a href='http://code.google.com/p/ndepics-redcross/issues/entry'>Go to Google Code Issue Tracker</a>"
?>