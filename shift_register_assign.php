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
	 
	<link rel="stylesheet" href="treeview/jquery.treeview.css" />
	<link rel="stylesheet" href="treeview/screen.css" />
	
	<script src="treeview/lib/jquery.js" type="text/javascript"></script>
	<script src="treeview/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="treeview/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="treeview/demo.js"></script>
	
<!-- calculate date and time -->
<script type="text/javascript">
function showhos()
{
var hosid=document.form1.hosid.value;
var cdate=document.form1.f_date1.value;
var date2=document.form1.f_date2.value;

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
    document.getElementById("hospitalid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","shifting.php?hosid="+hosid+"&cdate="+cdate+"&date2="+date2,true);
xmlhttp.send();

}

</script>
<!--ending of calculation-->

</head>
<body bgcolor="#EEF5FD">
<?php
include('db.php');
 $bd='Bangladesh';
 //$cdate=$_GET['f_date1'];
 //$date2=$_GET['f_date2'];
 echo $hosid=$_GET['hosid'];
$tree = mysql_query("SELECT * from divisions");

?>
<form method="post" action="" name="form1" id="form1">         
<table width="1107" align="center">
 <tr>
   <td colspan="2"><?php echo '<a href="javascript:window.print()">Print</a>'; ?> | <?php echo '<a href="index.php">Home</a>'; ?>  </td>
 </tr>
 <tr>
   <td width="302" valign="top"><div id="main" align="left" style="width:300px; background-color:#EEF5FD">
	
<ul id="navigation" style="border:double; border-color:#AFDBFE"> 
		<li><a href="cont.php?bd=<?php echo $bd;?>">Bangladesh</a>
			<ul>
<?php
    while($row = mysql_fetch_array($tree))
            {
                ?>
				<li style="background-color:#EEF5FD"><a href="div.php?divid=<?php echo $row['divid'];?>"><?php echo $row['divname']; ?></a>
					<ul>
                <?php
                $divid = $row['divid'];
                $dist = mysql_query("SELECT * FROM districts WHERE divid='$divid'");
                while($rowdist = mysql_fetch_array($dist))
               {  
                ?>
						<li style="background-color:#EEF5FD"><a href="dist_attend.php?disid=<?php echo $rowdist['disid'];?>"><?php echo $rowdist['disname']; ?></a>
                            <ul>
							<?php
							$disid=$rowdist['disid'];
				            $upo = mysql_query("SELECT * FROM upozilas WHERE disid='$disid'");
							while($rowupo = mysql_fetch_array($upo)){
							?>
                                <li style="background-color:#EEF5FD"><a href="upo_attend.php?upoid=<?php echo $rowupo['upoid'];?>"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = mysql_fetch_array($hos)){
										
									?>
								<li style="background-color:#EEF5FD"><a href="shift_register_assign.php?hosid=<?php echo $rowhos['hosid'];?>"><?php echo $rowhos['hosname']; ?></a></li>
									<?php }?></ul>
								</li>
                               <?php }?> </ul>
               		  </li>
                    <?php
                }?>
					</ul>
				</li>
                <?php
            }?>
			</ul>
		</li>
	</ul>

</div>	</td>

<td  height="33" colspan="2" valign="top">
<table width="793">
  <tr><td colspan="3">
Date From 
   <input size="15" id="f_date1" name="f_date1" value="<?php echo @$_POST['f_date1'];?>" />
   <button id="f_btn1">...</button>
   <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        dateFormat : "%Y-%m-%d"
      });
    //]]></script> 
   To
	  <input size="15" id="f_date2" name="f_date2" value="<?php echo @$_POST['f_date2'];?>" />
      <button id="f_btn2">...</button>  Shift Name <select name="shiftid" id="shiftid"> <?php 
		$sql="select shift_id,shift_name from shift ORDER BY shift_name";
		$data = mysql_query($sql);					
		while($row = mysql_fetch_array($data))    
		{echo "<option value='".$row[shift_id]."'>".$row[shift_name]."</option>";}?>
        </select>
     
        <input name="submit" type="button" value="Show Report" onClick="showhos();">
		<script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date2",
        trigger    : "f_btn2",
        onSelect   : function() { this.hide() },
         dateFormat : "%Y-%m-%d"
      });
    //]]></script>     </td>
	  </tr>
 <tr><td width="52"> <p>
        <select name="staffid" size="30" multiple="multiple" id="staffid" ><?php 
		echo $sql_emp="select staffid,empname from employees where hosid='$hosid' ORDER BY empname";
		echo $data = mysql_query($sql_emp);					
		while($row_emp = mysql_fetch_array($data))    
		{echo "<option value='".$row_emp[staffid]."'>".$row_emp[empname]."</option>";}?> 
        </select>
      </p></td><td width="729" valign="top"><div id="hospitalid" align="left" style="width:400px" style="border:dashed;border-color:#990000"></div></td></tr>
  <tr>   
    <td colspan="2">&nbsp;</td>
  </tr>
 </table>
 <p>&nbsp;</p>
<td width="10"></td>
 
</table>	
</form>
</body>
</html>