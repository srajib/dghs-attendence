function getDiv(strURL)
{         
 var req = getXMLHTTP(); // fuction to get xmlhttp object
 if (req)
 {
  req.onreadystatechange = function()
 {
  if (req.readyState == 4) { //data is retrieved from server
   if (req.status == 200) { // which reprents ok status                    
     document.getElementById('disid').innerHTML=req.responseText;
  }
  else
  { 
     alert("There was a problem while using XMLHTTP:\n");
  }
  }            
  }        
req.open("GET", strURL, true); //open url using get method
req.send(null);
 }
}