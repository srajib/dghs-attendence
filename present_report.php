<html>
<head>
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
	<!--<link rel="stylesheet" type="text/css" href="css/style.css"/>	--> 
	<link rel="stylesheet" href="treeview/jquery.treeview.css"/>
	<link rel="stylesheet" href="treeview/screen.css"/>
	<!-- Menue Part -->
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
function showDis()
{
var disid=document.form1.disid.value;
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
    document.getElementById("disid").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","dist.php?disid="+disid+"&cdate="+cdate,true);
xmlhttp.send();
}

function showhos()
{
var hosid=document.form1.hosid.value;
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
xmlhttp.open("GET","hospital.php?hosid="+hosid+"&cdate="+cdate,true);
xmlhttp.send();
}

</script>
<!--ending of calculation-->

</head>
<body bgcolor="#EEF5FD" >
<?php
include('db.php');
$tree = @mysql_query("SELECT * from divisions");
?>
<div id="disid"></div>

<form method="post" action="" name="form1" id="form1">         
<table width="1200" align="center">
 <tr>
   <td width="371"><?php echo '<a href="../index.php">Home</a>'; ?> </td>
   <td width="90">&nbsp;</td>
   <td width="217">&nbsp;</td>
   <td width="109">&nbsp;</td>
   <td width="209">&nbsp;</td>
 </tr>
 <tr>
   <td><div id="main" style="width:300px; background-color:#EEF5FD">
	<ul id="navigation" style="border:double; border-color:#AFDBFE">
		<li style="background-color:#EEF5FD"><a href="cont.php?bd=<?php echo $bd;?>" style="text-decoration:none">Bangladesh</a>
			<ul>
<?php
    while($row = mysql_fetch_array($tree))
            {
                ?>
				<li style="background-color:#EEF5FD"><a href="div.php?divid=<?php echo $row['divid'];?>"style="text-decoration:none"><?php echo $row['divname']; ?></a>
					<ul>
                <?php
                $divid = $row['divid'];
                $dist = @mysql_query("SELECT * FROM districts WHERE divid='$divid'");
                while($rowdist = @mysql_fetch_array($dist))
               {  
                ?>
						<li style="background-color:#EEF5FD"><a href="#" style="text-decoration:none"><?php echo $rowdist['disname']; ?></a>
                            <ul>
							<?php
							$disid=$rowdist['disid'];
				            $upo = @mysql_query("SELECT * FROM upozilas WHERE disid='$disid'");
							while($rowupo = @mysql_fetch_array($upo)){
							?>
                                <li style="background-color:#EEF5FD"><a href="upo_attend.php?upoid=<?php echo $row['upoid'];?>" style="text-decoration:none"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= @mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = @mysql_fetch_array($hos)){
									?>
										<li style="background-color:#EEF5FD"><a href="hos.php?hosid=<?php echo $rowhos['hosid'];?>" style="text-decoration:none"><?php echo $rowhos['hosname']; ?></a></li>
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
   <td colspan="4">&nbsp;</td>
   </tr>
	</table>	


	
    <?php
    /*mysql_connect("103.247.238.173","root","mistestdb");
    mysql_select_db("org_registry");*/
    $tree = mysql_query("SELECT * from divisions");
	
    ?>

</form>
</body>
</html>