<?php
if (isset($_COOKIE["userid"]))
$openid = $_COOKIE["userid"];
session_start();
$uid=  $_SESSION['token']['uid'];
require("../include/conn.php");
$link = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true ); 
mysql_select_db("app_ehac", $link);
switch($_GET["action"]){ 
//个人信息更新
case  "update":
	$sex = $_POST['sex'];
	$email = $_POST['email'];
	$alarm = $_POST['alarm'];
	$exec="UPDATE ehac_user SET sex = '".$sex."', email = '".$email."' ,alarm = '".$alarm."' WHERE openid = '".$openid."' OR uid = '".$uid."'";
mysql_query($exec, $link);  
break;
//预警
case "automate": 
	$temp_device = $_POST['temp_device'];
    $temp_l = substr($_POST['temp'],0,2);
    $temp_h = substr($_POST['temp'],8,2);
	$humidity_device = $_POST['humidity_device'];
	$humidity_l = $_POST['humidity_l'];
	$humidity_h = $_POST['humidity_h'];
	$automate="UPDATE ehac_user SET temp_device = '".$temp_device."',temp_l = '".$temp_l."',temp_h = '".$temp_h."',humidity_device='".$humidity_device."', humidity_l = '".$humidity_l."', humidity_h = '".$humidity_h."' WHERE openid = '".$openid."' OR uid = '".$uid."'";
mysql_query($automate, $link);  
break;
//修改设备信息
case "deviceinfo":
    $id = $_POST['id'];
	$devicename = $_POST['devicename'];
	$deviceinfo="UPDATE device SET devicename='".$devicename."' WHERE id='".$id."'";
mysql_query($deviceinfo, $link);  
    $mark  = mysql_affected_rows();//返回影响行数
break;
}
mysql_close($link);  
?> 