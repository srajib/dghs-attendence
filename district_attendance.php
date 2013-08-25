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
	 
	<link rel="stylesheet" href="treeview/jquery.treeview.css" />
	<link rel="stylesheet" href="treeview/screen.css" />
	
	<script src="treeview/lib/jquery.js" type="text/javascript"></script>
	<script src="treeview/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="treeview/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="treeview/demo.js"></script>
	
<!-- calculate date and time -->
<script type="text/javascript">
function showdistrict()
{
var disid=document.form1.disid.value;
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
    document.getElementById("disid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","district.php?disid="+disid+"&cdate="+cdate+"&date2="+date2,true);
xmlhttp.send();
}

</script>
<!--ending of calculation-->

</head>
<body bgcolor="#EEF5FD">
<?php
include('db.php');
$tree = mysql_query("SELECT * from divisions");
?>
  <form method="post" action="" name="form1" id="form1">         
           
<table width="1046" align="center">

 <tr>
   <td colspan="2"><?php echo '<a href="javascript:window.print()">Print</a>'; ?> | <?php echo '<a href="index.php">Home</a>'; ?> </td>
   <td width="28">&nbsp;</td>
   <td width="5">&nbsp;</td>
   <td width="19">&nbsp;</td>
   <td width="149">&nbsp;</td>
 </tr>
 <tr>
   <td width="345">
<div id="main" style="width:300px; background-color:#EEF5FD">
	
	<ul id="navigation">
		<li style="background-color:#EEF5FD"><a href="cont.php">Bangladesh</a>
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
						<li style="background-color:#EEF5FD"><a href="dist_attend.php?disid=<?php echo $rowdist['disid'];?>" ><?php echo $rowdist['disname']; ?></a>
                            <ul>
							<?php
							$disid=$rowdist['disid'];
				            $upo = mysql_query("SELECT * FROM upozilas WHERE disid='$disid'");
							while($rowupo = mysql_fetch_array($upo)){
							?>
                                <li style="background-color:#EEF5FD"><a href="upo_attend.php"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = mysql_fetch_array($hos)){
									?>
										<li style="background-color:#EEF5FD"><a href="hos.php?hosid=<?php echo $rowhos['hosid'];?>"><?php echo $rowhos['hosname']; ?></a></li>
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
</div>	</td></tr>
	</table>
			
	<div id="disid"></div>		
</form>
	
	
</table>
</body>
</html>