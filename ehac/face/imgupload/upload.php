<?php
$person_id = $_POST['person_id'];
require_once '../facepp_sdk.php';
$facepp = new Facepp();
$s2 = new SaeStorage();
$name =$_FILES['image_file']['name'];
    //$imgname = date('YmdHis');
$filename = $s2->upload('cache',$name,$_FILES['image_file']['tmp_name']);
$percent = 0.5;
// Content type
header('Content-Type: image/jpeg');
// Get new sizes
list($width, $height) = getimagesize($filename);
// Load
$thumb = imagecreatetruecolor(200,200);
$source = imagecreatefromjpeg($filename);
// Resize
imagecopyresized($thumb, $source, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], 200, 200, (int)$_POST['w'], (int)$_POST['h']);
// Output

$s = new SaeStorage();
ob_start(); 
imagejpeg($thumb); 
$imgstr = ob_get_contents(); 
$imgurl = $s->write('img',$name,$imgstr); 
//$s2->upload('img',$name,$imgstr);
ob_end_clean(); 
imagedestroy($source); 

//Add Face
#检测图片 by url
$params=array('url'=>$imgurl);
$response = $facepp->execute('/detection/detect',$params);
$arr = json_decode($response,true);
$face_id = $arr['face'][0]['face_id'];
echo $face_id;
$add_face = $facepp->execute('/person/add_face',array('face_id'=>$face_id,'person_id'=>$person_id));
print_r($add_face);
$train_person = $facepp->execute('/train/verify',array('person_id'=>$person_id));
print_r($train_person);
print_r($person_id);

?>
