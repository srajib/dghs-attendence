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
function showHos()
{
var hosid=document.form1.hosid.value;
var cdate=document.form1.f_date1.value;
var date2=document.form1.f_date2.value;
var staffid=document.form1.staffid.value;


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
xmlhttp.open("GET","leave.php?hosid="+hosid+"&cdate="+cdate+"&date2="+date2+"&staffid="+staffid,true);
xmlhttp.send();
}

</script>
<!--ending of calculation-->

</head>
<body bgcolor="#EEF5FD">
<?php
include('db.php');
 $hosid=$_GET['hosid'];
// $staffid=$_GET['staffid'];
 $tree = mysql_query("SELECT * from divisions");
?>
<form method="post" action="" name="form1" id="form1">         
<table width="1113px" align="center">
 <tr>
 <td  height="33" colspan="2">Date From 
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
      <button id="f_btn2">...</button>       
        Staff code 
        <input name="staffid" type="text" id="staffid">
        <input name="submit" type="button" value="Show Report" onClick="showHos();" /></td>
			<td colspan="2"><script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date2",
        trigger    : "f_btn2",
        onSelect   : function() { this.hide() },
         dateFormat : "%Y-%m-%d"
      });
    //]]></script>	</td>	
			<td>&nbsp;</td>
 </tr>
 <tr>
   <td colspan="2"><?php echo '<a href="javascript:window.print()">Print</a>'; ?> | <?php echo '<a href="index.php">Home</a>'; ?> 
   <input type="hidden" name="hosid" value="<?php echo $hosid; ?>"></td>
 </tr>
 <tr>
   <td width="200"><div id="main" align="left" style="width:200px; background-color:#EEF5FD">
	
<ul id="navigation" style="border:double; border-color:#AFDBFE">
		<li><a href="cont.php">Bangladesh</a>
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
						<li style="background-color:#EEF5FD"><a href="#"><?php echo $rowdist['disname']; ?></a>
                            <ul>
							<?php
							$disid=$rowdist['disid'];
				            $upo = mysql_query("SELECT * FROM upozilas WHERE disid='$disid'");
							while($rowupo = mysql_fetch_array($upo)){
							?>
                                <li style="background-color:#EEF5FD"><a href="#"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = mysql_fetch_array($hos)){
									?>
										<li style="background-color:#EEF5FD"><a href="lev.php?hosid=<?php echo $rowhos['hosid'];?>"><?php echo $rowhos['hosname']; ?></a></li>
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
<td width="900" valign="top"><div id="hosid" align="left" style="width:900px"></div></td>
</tr>
	</table>	
</form>
</body>
</html>