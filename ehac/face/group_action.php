<?php
$group_name = $_GET['group_name'];
require_once 'facepp_sdk.php';
$facepp = new Facepp();
switch($_GET['action']){
    case "add":
    $group_add = $facepp->execute('/group/create',array('group_name'=>$group__name));
    echo $group_add;
    break;
	case "update"
	$group_update = $facepp->execute('/group/create',array('group_name'=>$group_name));}
    break;
	case "del":
    $group_del = $facepp->execute('/group/delete',array('group_name'=>$group_name));
    echo $group_del;
	break;
}
?>