<?php
require("../include/conn.php");
 $openid = "o_x4Lj0NzaEevvqdSl5vypXE3BvY";
 $devicename = $_GET['devicename'];
 $devicepic = $_GET['devicepic'];
 $id = $_GET['id']; 
 $con = mysql_connect( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true ); 
 if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }
mysql_query("set names 'utf8'");
mysql_select_db("app_ehac", $con);

mysql_query("INSERT INTO device (openid,id, type, devicename,devicepic) VALUES ('".$openid."','".$id."','1', '".$devicename."','".$devicepic."')");


mysql_close($con);
 ?>
