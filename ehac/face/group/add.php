<?php
//添加分组
$group_name = $_GET['group_name'];
require_once '../facepp_sdk.php';
$facepp = new Facepp();
$group_add = $facepp->execute('/group/create',array('group_name'=>$group_name,'tag'=>"ol"));
echo $group_add;
?>