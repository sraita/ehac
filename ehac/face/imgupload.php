<?php
$person_name=$_POST['person_name'];
echo $person_name;
$s2 = new SaeStorage();
$name =$_FILES['myfile']['name'];
echo $s2->upload('img',$name,$_FILES['myfile']['tmp_name']);//把用户传到SAE的文件转存到名为test的storage
// echo $s2->getUrl("test",$name);//输出文件在storage的访问路径
echo "<br/>";
    require_once 'facepp_sdk.php';
$facepp = new Facepp();
$params=array('img'=>'{image file path}');
$params['attribute'] = 'gender,age,race,smiling,glass,pose';
#检测图片 by url
$params=array('url'=>$imgurl);
$response = $facepp->execute('/detection/detect',$params);
$arr = json_decode($response,true);
$face_id = $arr['face'][0]['face_id'];
echo $face_id;
    $add_face = $facepp->execute('/person/add_face',array('face_id'=>$face_id,'person_name'=>$person_name));
    print_r($add_face);
 
?>