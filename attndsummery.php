
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
<table bgcolor="#047C0C" width="1200px" align="center" >
<tr>
<td style="padding-left:5px">
<img src="images/bangladesh-logo.png" alt=""  />
</td>
<td ><img src="images/bangladesh-mis.png" alt="" align="left" /><td>
<td width="450px" ></td>
<tr>
</table>
<table bgcolor="#DF4C17" width="1200px" align="center">
<tr>
<td ></td>
</tr>
</table>
<table  bgcolor="#EEF5FD" width="1200px" align="center">
</table>
    <script src="js/jscal2.js"></script>
    <script src="js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jscal2.css"/>
    <link rel="stylesheet" type="text/css" href="css/border-radius.css"/>
    <link rel="stylesheet" type="text/css" href="css/steel/steel.css"/>
	 
	<link rel="stylesheet" href="treeview/jquery.treeview.css" />
	<link rel="stylesheet" href="treeview/screen.css" />
	<!--menu part -->
	<link rel="stylesheet" href="superfish/css/superfish-modified.css"/>
	<link rel="stylesheet" href="superfish/css/superfish-navbar.css"/>
	<link rel="stylesheet" href="superfish/css/superfish-vertical.css"/>
	<link rel="stylesheet" href="superfish/css/superfish.css"/>
	
	<script src="treeview/lib/jquery.js" type="text/javascript"></script>
	<script src="treeview/lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="treeview/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="treeview/demo.js"></script>
	
	
<!-- calculate date and time -->
<script type="text/javascript">
function showstaff_sum()
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
    document.getElementById("attend").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","staff_attend_sum.php?hosid="+hosid+"&cdate="+cdate+"&date2="+date2,true);
xmlhttp.send();
}
</script>
<!--ending of calculation-->

</head>
<body bgcolor="#EEF5FD" >

  <?php
include('db.php');
 //$hosid=$_GET['hosid'];

$tree = mysql_query("SELECT * from divisions");

?>

<form method="post" action="" name="form1" id="form1">         
  <div style="width:770px;" align="center"></div>

<table width="1113px" align="center"><tr>
 <td colspan="4" >&nbsp;</td>
  </tr>
	  <tr>
	    <td width="141" ><?php echo ' <a href="index.php">Home</a>'; ?></td>
	    <td width="30" >&nbsp;</td>
	    <td width="129" >&nbsp;</td>
	    <td width="793"  >&nbsp;</td>
      </tr>
	  <tr>
	    <td colspan="3" valign="top"><div id="main" align="left" style="width:300px; background-color:#EEF5FD">
	
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
                                <li style="background-color:#EEF5FD"><a href="#"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = mysql_fetch_array($hos)){
									?>
									<li style="background-color:#EEF5FD"><a href="staff_attend.php?hosid=<?php echo $rowhos['hosid'];?>"><?php echo $rowhos['hosname']; ?></a></li>
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

</div></td>
	    <td  ><div id="hosid" align="left" style="width:900px" ></div></td>
    </tr>
	</table>
		
</form>

</body>
</html>