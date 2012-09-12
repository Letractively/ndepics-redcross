//
// This code is a modified example from http://www.w3schools.com/Ajax/ajax_database.asp
//

var xmlHttp

function showResource(str)
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
  
var pathArray = window.location.pathname.split('/');
var urlpath = "";
for (i=0; i<(pathArray.length-1) ; i++) {
	urlpath += pathArray[i];
	urlpath += "/";
}
  
var url = window.location.protocol + "//" + window.location.host + urlpath; 
  
url=url+"ajax/getresource.php";
url=url+"?rsrc="+str;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);

}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
	}
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}