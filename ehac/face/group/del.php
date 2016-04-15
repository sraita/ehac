<?php
//删除分组
$group_name = $_GET['group_name'];
require_once '../facepp_sdk.php';
$facepp = new Facepp();
$group_del = $facepp->execute('/group/delete',array('group_name'=>$group_name,'tag'=>"ol"));
echo $group_del;
?>