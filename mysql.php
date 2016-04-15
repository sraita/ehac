<?php
//两表操作
$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
mysql_select_db("app_ehac", $con);//修改数据库名
$sql = mysql_query("SELECT * FROM device;");
while($arr = mysql_fetch_array($sql))
{
    if($arr['sid']==3&&$arr['data']==1){
    $sql1 = "UPDATE api_worklist SET data = '1' WHERE sid='00".$arr['sid']."' AND nid='00".$arr['nid']."'";
                    $sql2 = mysql_query($sql1,$con); 
    }
    if($arr['sid']==3&&$arr['data']==0){
         $sql3 = "UPDATE api_worklist SET data = '0' WHERE sid='".$arr['sid']."' AND nid='".$arr['nid']."'";
                    $sql4 = mysql_query($sql3,$con); 
        echo $arr['nid'];
    }
}

mysql_close($con);

?>

