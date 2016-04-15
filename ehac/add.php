<?php
if (isset($_COOKIE["userid"]))
$openid = $_COOKIE["userid"];
session_start();
$uid=  $_SESSION['token']['uid'];
require("include/conn.php");
 $openid = "o_x4Lj0NzaEevvqdSl5vypXE3BvY";
 $devicename = $_GET['devicename'];
 $devicepic = $_GET['devicepic'];
 $id = $_GET['id']; 
 $sid = $_GET['sid']; 
 $nid = $_GET['nid']; 
 $con = mysql_connect( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true ); 
 if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }
mysql_query("set names 'utf8'");
mysql_select_db("app_ehac", $con);

mysql_query("INSERT INTO device (id,openid,uid,sid,nid,devicename,devicepic) VALUES ('".$id."','".$openid."','".$uid."','".$sid."','".$nid."', '".$devicename."','".$devicepic."')");


mysql_close($con);
 ?>