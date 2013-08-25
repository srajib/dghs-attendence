<html>
<head>
<table bgcolor="#047C0C" width=1024px align="center">
<tr>
<td>
<img src="images/bangladesh-logo.png" alt=""  />
<td>
<td><img src="images/bangladesh-mis.png" alt="" /><td>
<tr>
</table>
<table width=1024px bgcolor="#DF4C17" align="center" >
<tr>
<td ></td>
</tr>
</table>
<table width=1024px bgcolor="#EEF5FD" align="center">
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
<body width="1024px" bgcolor="#EEF5FD">
<?php
include('db.php');

?>
  <form method="post" action="" name="form1" id="form1">         
           
<table width="1024px" align="center">
 <tr>
 <td width="74" height="33">Date From </td>
  <td width="163">
   <input size="15" id="f_date1" name="f_date1" value="<?php echo @$_POST['f_date1'];?>" />
   <button id="f_btn1">...</button>
   <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
    //]]></script>	</td>
	<td width="47">&nbsp;</td>
	<td colspan="2">&nbsp;</td></td><td width="76">	
 </tr><tr>
	<td width="74"> Division </td>
			<td width="163"><select name="divid" id="divid" onChange="showDiv()" style="width:130px" >
              <?php 
						$sql="select divid,divname from divisions ORDER BY divname";
						$data = mysql_query($sql);					
						while($row = mysql_fetch_array($data))    
						{echo "<option value='".$row[divid]."'>".$row[divname]."</option>";}  
						?>
            </select></td>
			<td width="47"> District </td>
			<td width="135"><select name= "disid" id="disid" onChange = "showDis()" style="width:130px">
            </select></td>
			<td width="67"> Upazilla </td>
			 <td width="130"><select name="upoid" id="upoid" onChange = "showHospital()" style="width:130px">
             </select></td>
			 <td width="76" >Organization</td>
			<td width="130"><select name="hosid" id="hosid" style="width:130px">
            </select></td>
			 <td width="8"></td>
			 <td width="90"><input name="submit" type="submit" value="Show Report" /></td>
			<td width="56">&nbsp;</td>					
	</tr>
 <tr>
   <td colspan="2"><?php echo '<a href="javascript:window.print()">Print</a>'; ?> | <?php echo '<a href="../index.php">Home</a>'; ?> </td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td >&nbsp;</td>
   <td>&nbsp;</td>
   <td></td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
	</table>		
</form>

	<table width="1024" align="center" cellpadding="5px">
    <tr bgcolor="#8BB5EB">
        <td width="19" >SL</td>
		<td width="163" align="center">Name of Staff </td>
        <td width=267 align="center">Designation</td>
       
    </tr>

    <?php	
    if(isset($_POST['f_date1']))
    {  
	   $divid = $_POST['divid'];
		@$hosid = $_POST['hosid'];
		@$disid = $_POST['disid'];
		//echo $divid;
		$fromDatee   =   $_POST['f_date1'];
		
		$res_div = mysql_query("SELECT * FROM divisions	WHERE divid =$divid");
		$row_div = mysql_fetch_assoc($res_div);
		$div=$row_div['divname'];
		
		$res_dis = mysql_query("SELECT * FROM district	WHERE disid =$disid");
		$row_dis = mysql_fetch_assoc($res_div);
		$dis=$row_dis['disname'];
		
		
		$res_absent = mysql_query("SELECT department FROM employees	WHERE hosid =$hosid");
		$row_absent = mysql_fetch_assoc($res_absent);
		$dept=$row_absent['department'];
		
		
	$res_emp = mysql_query("SELECT empid, empname, designation, department	FROM employees	WHERE hosid =$hosid
	AND staffid NOT	IN (SELECT staffid FROM LOGS WHERE hosid=2003 AND DATE_FORMAT( timing, '%Y-%m-%d' )='$fromDatee')");
	
	?>
	
	<div id="colorbox" style="border:double; border-color:#AFDBFE; width:1010px;margin:0 auto;" >
	<div><?php echo " <strong> Division : </strong> $div"; ?></div>
	<div><?php echo " <strong> District : </strong> $dis"; ?></div>
	<div><?php echo " <strong> Department : </strong> $dept"; ?></div>
	</div>
	
	<?php	
	             $i=1;
			 while($row_emp = mysql_fetch_assoc($res_emp))
            {
			
			 if($i%2==0)
                {
                ?>
                <tr style="background-color: #BDD9FD;">
                <?php 
                }else{
                    ?> 
                <tr style="background-color: #E6F2FF;">
                    <?php
                } ?>
					  <td> <?php echo $i;$i++; ?></td>
					  <td align="left" width="400px" style="padding-left:5px;"><? echo $row_emp['empname'];?></td>
					  <td align="left" width="400px" style="padding-left:5px;"><? echo $row_emp['designation'];?></td>
					                 
				</tr>				
			   <?php
		  }	
}
	
?>

</table>
</div>
</body>
</html>