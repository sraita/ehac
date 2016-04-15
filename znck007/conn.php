<?php
//mysql_select_db选择 MySQL 数据库
//第一步：
//数据库连接配置文件
$mysql_host = SAE_MYSQL_HOST_M;
$mysql_host_s = SAE_MYSQL_HOST_S;
$mysql_port = SAE_MYSQL_PORT;
$mysql_user = SAE_MYSQL_USER;
$mysql_password = SAE_MYSQL_PASS;
$mysql_database = SAE_MYSQL_DB;
$con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
if (! $con) {
   die ( 'Could not connect: ' . mysql_error () );
}
else{
    define ( 'DB_NAME', $mysql_database );
mysql_select_db ( DB_NAME, $con ) or die ( "mysql_select_db err"); //连接上数据库了
//echo "连接上数据库了";//正式使用请注释这句，这句只是为了检测是否连接数据库成功！
    //echo "连接上数据库了";//正式使用请注释这句，这句只是为了检测是否连接数据库成功！
}
?>