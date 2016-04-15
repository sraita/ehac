<?php
//修改设备信息
require("include/conn.php");
		//通过post获取页面提交数据信息
	$id = $_POST['id'];
	$devicename = $_POST['devicename'];
	$conn = mysql_connect( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true ); 
	mysql_query("set names 'utf8'");
	mysql_select_db("app_ehac",$conn); 
	$sql = "update device set devicename='".$devicename." where id='".$id."'";
	mysql_query($sql,$conn);//执行SQL
	$mark  = mysql_affected_rows();//返回影响行数
	$url = "index.php"; 
	if($mark>0){
		echo "alert('修改成功')";
		}else{
			echo "alert('修改失败')";
            echo $id;
		}

?>