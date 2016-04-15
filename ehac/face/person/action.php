<?php
//person action
$person_name = $_GET['person_name'];
$group_name = $_GET['group_name'];
require_once '../facepp_sdk.php';
$facepp = new Facepp();
$add_person = $facepp->execute('/person/create',array('person_name'=>$person_name,'group_name'=>$group_name));
echo $person_name;
echo $froup_name;
?>