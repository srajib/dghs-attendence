<!DOCTYPE html>
<html>
<head>
<table bgcolor="#047C0C" width="1200px" align="center" >
<tr>
<td>
<img src="images/bangladesh-logo.png" alt=""  />
</td>
<td ><img src="images/bangladesh-mis.png" alt="" /><td>
<tr>
</table>
<table bgcolor="#DF4C17" width="1200px" align="center">
<tr>
<td ></td>
</tr>
</table>
<table  bgcolor="#EEF5FD" >
<tr>
<td ></td>
</tr>
</table>
    <script src="js/jscal2.js"></script>
    <script src="js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="css/steel/steel.css" />
	 
	
	
<!-- calculate date and time -->
<script type="text/javascript">

function showhos()
{
var cdate=document.form1.f_date1.value;

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("hosid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","inqueries_log.php?cdate="+cdate,true);
xmlhttp.send();
}

</script>
<!--ending of calculation-->

</head>
<body  bgcolor="#EEF5FD">
<?php
include('db.php');
?>

<form method="post" action="" name="form1" id="form1">

  <table width="1113" align="center" >
 <tr>
   <td><?php echo '<a href="../index.php">Home</a>'; ?> </td>
   <td width="801"></td>
 </tr>
 <tr>
   <td valign="top"><div>Date 
   <input size="15" id="f_date1" name="f_date1" value="<?php echo @$_POST['f_date1'];?>" />
   <button id="f_btn1">...</button>
   <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide()},
        dateFormat : "%Y-%m-%d"
      });
    //]]></script> <input name="submit" type="button" value="Show Report"  onClick="showhos();"/></form> 
	</div></td>
 </tr>
 <tr><td><div id="hosid" align="left" style="width:900px" ></div></td></tr>
</table>	



</body>
</html>