<?php /*?><?php error_reporting(E_ALL);
ini_set('display_errors','On');?><?php */?>
<html>
<head>
<style type="text/css">
<!--
.style1 {
	font-size: medium;
	font-weight: bold;
}
.style2 {font-size: 24px}
-->
</style>
<table bgcolor="#047C0C" width="1024px" align="center">
<tr>
<td>
<img src="images/bangladesh-logo.png" alt=""  />
<td>
<td><img src="images/bangladesh-mis.png" alt="" /><td>
</tr>
</table>
<table width="1024px" align="center" bgcolor="#DF4C17" >
<tr>
<td ></td>
</tr>
</table>
<table width="1024px" align="center" bgcolor="#EEF5FD" >
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
function showDiv()
{
var divid=document.form1.divid.value;
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
    document.getElementById("disid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","dist.php?divid="+divid,true);
xmlhttp.send();
}
function showDis()
{
var disid=document.form1.disid.value;
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
    document.getElementById("upoid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","upozila.php?disid="+disid,true);
xmlhttp.send();
}

function showHospital()
{
var upoid=document.form1.upoid.value;
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
xmlhttp.open("GET","organization.php?upoid="+upoid,true);
xmlhttp.send();
}
</script>
<!--ending of calculation-->

</head>
<body width="1024px" bgcolor="#ecf1f7" >
<p>
<table width="1024" align="center">
 <tr><td>root name</td><td> down1 name</td> <td>down2 name</td> <td>down3 name</td></tr> 
  <?php
include('db.php');

 $query=mysql_query("select distinct(root.name)  as root_name,down1.name as down1_name,down2.name as down2_name,down3.name as down3_name from treeview_item as root
left outer join treeview_item as down1 on down1.parent_id = root.id
left outer join treeview_item as down2 on down2.parent_id = down1.id
left outer join treeview_item as down3 on down3.parent_id = down2.id
 where root.parent_id is null order by root_name, down1_name,down2_name,down3_name");

echo $query;
	 while ($row=mysql_fetch_assoc($query)){
	   
?>
		
  <tr><td><?php echo $row['root_name'];?></td>
  <td> <?php echo $row['down1_name'];?></td> 
  <td><?php echo $row['down2_name'];?></td> 
  <td><?php echo $row['down3_name'];?></td>
  </tr> 
  
  <div style="border:1;border-color:#990000"> 
  <ul>
	
      <li><?php echo $row['root_name'];?>
	  <ul>
	  <li><?php echo $row['down1_name'];?></li>
	</ul></li>	
  </ul>

</tr>
</div>
<?php }?>



</table>
</body>
</html>