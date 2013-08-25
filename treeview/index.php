<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>jQuery treeview</title>
	
	<link rel="stylesheet" href="jquery.treeview.css" />
	<link rel="stylesheet" href="screen.css" />
	
	<script src="lib/jquery.js" type="text/javascript"></script>
	<script src="lib/jquery.cookie.js" type="text/javascript"></script>
	<script src="jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="demo.js"></script>
	
	</head>
	<body>
	
	<div id="main">
	
    <?php
    /*mysql_connect("103.247.238.173","root","mistestdb");
    mysql_select_db("org_registry");*/
	include('db.php');
    $tree = mysql_query("SELECT * from divisions");
    ?>

	<ul id="navigation">
		<li><a href="?1">Bangladesh</a>
			<ul>
<?php
    while($row = mysql_fetch_array($tree))
            {

                ?>
				<li><a href="?1.0"><?php echo $row['divname']; ?></a>
					<ul>
                <?php
                $divid = $row['divid'];
                $dist = mysql_query("SELECT * FROM districts WHERE divid='$divid'");
                while($rowdist = mysql_fetch_array($dist))
               {
				  
                ?>
						<li><a href="?1.0.0"><?php echo $rowdist['disname']; ?></a>
                            <ul>
							<?php
							$disid=$rowdist['disid'];
				            $upo = mysql_query("SELECT * FROM upozilas WHERE disid='$disid'");
							while($rowupo = mysql_fetch_array($upo)){
							?>
                                <li><a href="?1.0.0"><?php echo $rowupo['uponame']; ?></a>
									<ul>
									<?php 
									$upoid=$rowupo['upoid'];
				           			$hos= mysql_query("SELECT * FROM hospitals WHERE upoid='$upoid'");
										while($rowhos = mysql_fetch_array($hos)){
									?>
										<li><a href="?1.0.0"><?php echo $rowhos['hosname']; ?></a></li>
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

</div>
 
</body></html>