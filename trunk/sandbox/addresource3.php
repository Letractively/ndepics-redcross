<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addresource3.php - file to insert a resource into the disaster database
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
}  

include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Resource Added</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

?>
<div align="center">
  <h1>Add Resource</h1>
</div>

<?

$resource_type = $_POST["resource_type"];
$resource_description = $_POST["resource_description"];
$resource_keyword = $_POST["resource_keyword"];

$addresfromorg = $_POST["addresfromorg"];

if($addresfromorg){
  $organization_name = $_POST["organization_name"];
  $street_address = $_POST["street_address"];
  $mailing_address = $_POST["mailing_address"];
  $city = $_POST["city"];
  $state = $_POST["state"];
  $zip = $_POST["zip"];
  $county = $_POST["county"];
  $business_phone = $_POST["business_phone"];
  $business_phone2 = $_POST["business_phone2"];
  $business_fax = $_POST["business_fax"];
  $email = $_POST["email"];
  $website = $_POST["website"];
  $addtl_info = $_POST["addtl_info"];
  $updated_by = $_POST["updated_by"];
 }

//check to see is resource exists
$res_query = "SELECT * FROM detailed_resource WHERE resource_type = '".$resource_type." ' ";

$result3 = mysql_query($res_query) or die ("Error checking if resrouce exists query");

$num_rows = mysql_num_rows($result3);

if ($num_rows != 0){
	
  print "<div align='center'><br>";
  print "Cannot Add Resource Type: \"<b>".$resource_type."</b>\" already exists <br><br>";
  if($addresfromorg){
                print "<form action=\"./addorganization2.php\" method ='post'>\n";
                        print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
			print "<input type=hidden name='street_address' value=\"".$street_address."\">";
			print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
			print "<input type=hidden name='city' value=\"".$city."\">";
			print "<input type=hidden name='state' value=\"".$state."\">";
			print "<input type=hidden name='zip' value=".$zip.">";
			print "<input type=hidden name='county' value=\"".$county."\">";
			print "<input type=hidden name='business_phone' value='".$business_phone."'>";
			print "<input type=hidden name='business_phone2' value='".$business_phone2."'>";
			print "<input type=hidden name='business_fax' value='".$business_fax."'>";
			print "<input type=hidden name='email' value=\"".$email."\">";
			print "<input type=hidden name='website' value=\"".$website."\">";
			print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
			print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
			print "<input type=hidden name='from_res_seq' value='2'>";
			print "<button type=\"submit\">Return to Add Organization</button>";
       		print "</form>\n";
       		print "</div>";
		}
		else {

        print "<form action=\"./home.php\" >\n";
        print "<button type=\"submit\">Return Home</button>";
        print "</form>\n";
        print "</div>";
        
        }
        exit(-1);
}
else{
     // print "Organization " .$organization_name." does not exist";
}

$tempdate = date("m/d/Y H:i:s");
$query = "INSERT INTO detailed_resource (resource_type, description, keyword, log)
				 VALUES (\"".$resource_type."\",\"".$resource_description."\",\"".$resource_keyword."\",\"".$_SESSION['username'].": " .$tempdate. "\n"
		 .$row['log']."\")";

$result = mysql_query($query) or die ("Error sending query");

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo "Org_ID : {$row['organization_id']} <br>" .
	     "Org_Name: {$row['organization_name']} <br>" .
	     "Address: {$row['street_address']} <br>" .
	     "City: {$row['city']} <br>";
}

print "<h2>Adding values: </h2>";
print "<table>";
	print "<tr>";
	print "<td width=120><b> Resource Type: </b></td>";
	print "<td>".$resource_type."</td>";
	print "</tr>";

	print "<tr>";
	print "<td valign=\"top\"><b>Description: </b></td>";
	print "<td width=620>".$resource_description."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Keywords: </b></td>";
	print "<td>".$resource_keyword."</td>";
	print "</tr>";
print "</table><br>";

//print $resource_type." was added as a resource successfully.";

print "<div align='center'>";

 if($addresfromorg){
       	    print "<form action=\"./addorganization2.php\" method ='post'>\n";
			print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
			print "<input type=hidden name='street_address' value=\"".$street_address."\">";
			print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
			print "<input type=hidden name='city' value=\"".$city."\">";
			print "<input type=hidden name='state' value=\"".$state."\">";
			print "<input type=hidden name='zip' value=".$zip.">";
			print "<input type=hidden name='county' value=\"".$county."\">";
			print "<input type=hidden name='business_phone' value='".$business_phone."'>";
			print "<input type=hidden name='business_phone2' value='".$business_phone2."'>";
			print "<input type=hidden name='business_fax' value='".$business_fax."'>";
			print "<input type=hidden name='email' value=\"".$email."\">";
			print "<input type=hidden name='website' value=\"".$website."\">";
			print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
			print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
			print "<input type=hidden name='from_res_seq' value='2'>";
	        print "<button type=\"submit\">Return to Add Organization</button>";
       		print "</form>\n";
       		print "</div>";
		}
		else {

        print "<form action=\"./home.php\" >\n";
        print "<button type=\"submit\">Return Home</button>";
        print "</form>\n";
        print "</div>";
   
        }

include ("config/closedb.php");
include("html_include_3.php");
?>