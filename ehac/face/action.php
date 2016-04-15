<?php
$group_add_name = "家人";
$group_del_name = $_GET['group_name'];
$person_name = $_GET['person_name'];
$person_del_name = $_GET['person_del_name'];
$person_update_name = $_GET['name'];
$face_add_id = $_GET['person_id'];
require_once 'facepp_sdk.php';
$facepp = new Facepp();
//$xunlian = $facepp->execute('/train/verify',array('person_name'=>"桂富波"));
//echo $xunlian;
$shibie = $facepp->execute('/recognition/verify',array('face_id'=>"82d96581271fb0d8549540b7dd0befe8",'person_name'=>"桂富波"));
echo $shibie;
//更改Person名
if($person_update_name != null){$person_update = $facepp->execute('/person/set_info',array('person_name'=>$person_name,'name'=>$person_update_name));}
//添加分组
if($group_add_name != null){
    $group_add = $facepp->execute('/group/create',array('group_name'=>$group_add_name,'tag'=>"ol"));
    echo $group_add;
}
//更新分组名称
if($group_update_name != null){$group_update = $facepp->execute('/group/create',array('group_name'=>$group_name));}
//删除分组
if($group_del_name != null){ 
    $group_del = $facepp->execute('/group/delete',array('group_name'=>$group_del_name));
    echo $group_del;
}
//添加Person
if($person_add_name != null){ $person_add = $facepp->execute('/group/create',array('group_name'=>$group_name));}
//更改Person名
if($person_update_name != null){ $person_update = $facepp->execute('/person/set_info',array('person_name'=>$person_name,'name'=>$person_update_name));}
//删除Person
if($person_del_name != null){$person_del = $facepp->execute('/person/delete',array('person_name'=>$person_del_name));}
//添加face
if($face_add_id != null){ 
    $s2 = new SaeStorage();
    $name =$_FILES['myfile']['name'];
    echo $s2->upload('img',$name,$_FILES['myfile']['tmp_name']);//把用户传到SAE的文件转存到名为test的storage
    // echo $s2->getUrl("test",$name);//输出文件在storage的访问路径
    echo "<br/>";
    $imgurl = $s2->upload('img',$name,$_FILES['myfile']['tmp_name']);
    #检测图片 by url
    $params=array('url'=>$imgurl);
    $response = $facepp->execute('/detection/detect',$params);
    $arr = json_decode($response,true);
    $face_id = $arr['face'][0]['face_id'];
    $face_add = $facepp->execute('/person/add_face',array('face_id'=>$face_id,'person_id'=>$face_add_id));
    echo $face_add;
}
//删除face
if($face_del_name != null){ $face_del = $facepp->execute('/group/create',array('group_name'=>$group_name));}
?>
