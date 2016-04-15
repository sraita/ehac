<?php  
//删除设备
require("include/conn.php");
$link = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true ); 
mysql_select_db("app_ehac", $link);  
$del_id=$_GET["id"];  
$exec="delete from device where id=$del_id";  
mysql_query($exec, $link);  
echo "删除成功!"; 
echo $del_id;  
mysql_close($link);  
?> 