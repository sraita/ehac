<?php 
$person_id = $_GET['person_id'];
require_once '../facepp_sdk.php';
$facepp = new Facepp();
$get_face_id = $facepp->execute('/person/get_info',array('person_id'=>$person_id));
$arr_face = json_decode($get_face_id,true);
$face_num = count($arr_face['face']);
$get_imghead = $facepp->execute('/info/get_face',array('face_id'=>$arr_face['face'][0]['face_id']));
$arr_imghead = json_decode($get_imghead,true);
$img_urlhead = $arr_imghead['face_info'][count($arr_imghead)-1]['url'];
?>
<!-- Navbar -->
        <div class="navbar">
          <!-- Home page navbar -->
         <div class="navbar-inner" data-page="person_info">
             <div class="left">
                <!-- Right link contains only icon - additional "icon-only" class-->
                <a href="#" popup-data="history" class="link back"><i class="icon icon-back"></i>返回</a>
              </div>
              <div class="right">Face++</div>
         </div>
      </div>
<!-- Pages -->
<div class="pages">
<!-- page -->
	<div class="page" data-page="person_info">
		<div class="page-content">
			<div class="card facebook-card">
				<div  class="card-header no-border person-edit" style="background-image:url(http://1.ehac.sinaapp.com/ehac/img/theme/theme_default.png); background-size:cover;" valign="bottom">
                    <div class="facebook-name alert-text"><img src="<?php echo $img_urlhead;?>" width="60" height="60"></div>
                    <div  class="facebook-name" id="person_name"><?php echo $arr_face['person_name'];?></div>
                    <div class="facebook-date">分组：<?php echo $arr_face['group'][0]['group_name'];?></div>
				</div>
				<div class="card-content">
					<div class="card-content-inner row">
                        <a href="face/imgupload/add_face.php?person_id=<?php echo $person_id;?>" class="col-33">
                            <img  src="http://1.ehac.sinaapp.com/ehac/img/photo_get.png"  height="120">
                        </a>
                        <?php
						for($i=0;$i<$face_num;$i++){
                            $get_img = $facepp->execute('/info/get_face',array('face_id'=>$arr_face['face'][$i]['face_id']));
                            $arr_img = json_decode($get_img,true);
                            $img_url = $arr_img['face_info'][count($arr_img)-1]['url'];
					    ?>
						<img class="col-33 del-face" src="<?php echo $img_url;?>"  height="120">
                        <?php }?>
					</div>
				</div>
			</div>           
		</div>
	</div>
</div>