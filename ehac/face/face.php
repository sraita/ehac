<?PHP
require_once 'facepp_sdk.php';
$facepp = new Facepp();

#检测图片
$params=array('img'=>'{image file path}');
$params['attribute'] = 'gender,age,race,smiling,glass,pose';
$response = $facepp->execute('/detection/detect',$params);


#检测图片 by url
$params=array('url'=>'http://www.faceplusplus.com.cn/wp-content/themes/faceplusplus/assets/img/demo/1.jpg');
$response = $facepp->execute('/detection/detect',$params);


//if($response['http_code']==200){
    #json decode 
//  $data = json_decode($response['body'],1);
    #get face landmark
//  foreach ($data['face'] as $face) {
//      $response = $facepp->execute('/detection/landmark',array('face_id'=>$face['face_id']));

//  }
    #create person 
    //$response = $facepp->execute('/person/create',array('person_name'=>'unique_person_name'));

    #添加一张脸
    // $response = $facepp->execute('/person/add_face',array('person_name'=>'unique_person_name','url'=>'http://ehac-img.stor.sinaapp.com/_副本_副本.jpg'));


    #delete person
    //$response = $facepp->execute('/person/delete',array('person_name'=>'unique_person_name'));
    //print_r($response);

//}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>face++</title>
    <!-- Path to Framework7 Library CSS-->
      <link rel="stylesheet" href="../css/framework7.min.css">
      <link rel="stylesheet" href="../css/framework7.themes.min.css">
    <!-- Path to your custom app styles-->
      <link rel="stylesheet" href="../css/todo7.css">
      <style>
          .facebook-card .card-header {
            display: block;
            padding: 10px;
          }
          .facebook-card .facebook-avatar {
            float: left;
          }
          .facebook-card .facebook-name {
            margin:5 44px;
            font-size: 14px;
            font-weight: 500;
          }
          .facebook-card .facebook-date {
            margin-left: 44px;
              margin-right:44px;
            font-size: 13px;
            color: #8e8e93;
          }
          .facebook-card .facebook-name .list-block
          {
              margin-left:-50px;
          }
          .facebook-card .facebook-name img
          {
              border:2px solid #ffffff;
              border-radius:100%;
          }
     
      </style>
  </head>
  <body>
    <div class="statusbar-overlay"></div>
    <div class="panel-overlay"></div>
    <div class="panel panel-right panel-cover">
      <div class="view view-right1">
        <div class="pages">
          <div data-page="panel-right1" class="page">
            <div class="page-content"> 
              <div class="content-block-title">Full Layout</div>
                <div class="list-block accordion-list">
                  <ul>
                    <?php     
                    $response = $facepp->execute('/info/get_group_list',array(''));
                     $arr = json_decode($response,true); //后面加true转换为数组
                    $a = count($arr['group']);
                    for($i=0;$i<$a;$i++){
                    ?>
                      <li>
                          <div class="item-inner"><?php echo $arr['group'][$i]['group_name'];?></div>
                      </li>
                   <?php }?>
                  </ul>
                </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views tabs ">
      <!-- Your first view, it is also a .tab and should have "active" class to make it visible by default-->
      <div id="view-1" class="view view-main tab active">
          <!-- Navbar -->
        <div class="navbar theme-green">
          <!-- Home page navbar -->
         <div class="navbar-inner" data-page="person-info">
             <div class="left">
                <!-- Right link contains only icon - additional "icon-only" class-->
                <a href="#" popup-data="history" class="link icon-only open-popup"><i class="icon icon-time"></i></a>
              </div>
              <div class="center">Face++</div>
              <div class="right">
                <a href="#" class="link icon-only open-popup"><i class="icon icon-plus">+</i></a>
              </div>
         </div>
      </div>
        <!-- Pages-->
        <div class="pages navbar-through">
          <!-- Page, data-page contains page name-->
          <div data-page="home-page" class="page">
              <!-- Search bar -->
              <form data-search-list=".list-block-search" data-search-in=".item-inner" class="searchbar searchbar-init">
                <div class="searchbar-input">
                  <input type="search" placeholder="Search"><a href="#" class="searchbar-clear"></a>
                </div><a href="#" class="searchbar-cancel">Cancel</a>
              </form>
             
              <!-- Search bar overlay -->
              <div class="searchbar-overlay"></div>
             
            
            <!-- Scrollable page content-->
            <div class="page-content">
                  <div class="list-block media-list list-block-search searchbar-found">
                    <div class="list-group">
                      <ul>
                         <?php 
                        $personlist = $facepp->execute('/info/get_person_list',array(''));
                        $arr = json_decode($personlist,true); //后面加true转换为数组
                        $b = count($arr['person']);
                        for($j=0;$j<$b;$j++){
                        ?> 
                          <a href="person/person_info.php" class="link">
                            <li>
                              <div class="item-content">
                                 <?php 
                            		$get_face_id = $facepp->execute('/person/get_info',array('person_name'=>$arr['person'][$j]['person_name']));
                            		$arr_face = json_decode($get_face_id,true);
                            		$get_img = $facepp->execute('/info/get_face',array('face_id'=>$arr_face['face'][0]['face_id']));
                                    $arr_img = json_decode($get_img,true);
                                    $img_url = $arr_img['face_info'][count($arr_img)-1]['url'];
                                    
                                  ?>
                                 <div class="item-media"><img src="<?php echo $img_url;?>" width="60" height="60"></div>
                                 <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title"><?php echo $arr['person'][$j]['person_name'];?></div>
                                     	<div class="item-after"><?php echo $arr_face['tag'][0];?></div>
                                    </div>
                                    <div class="item-subtitle"><?php echo $arr_face['group'][0]['group_name'];?></div>
                                 </div>   
                              </div>
                            </li>
                          </a>
                          <?php }?>
                      </ul>
                        <br/>
                    </div>
                  </div>

            </div>
          </div>
        </div>
      </div>
      <!-- Second view (for second wrap)-->
      <div id="view-2" class="view view-user tab ">
         <!-- Pages -->
        <div class="pages">     
           <!-- page -->
          <div class="page" data-page="userinfo">
            <div class="page-content">
              <div class="content-block-title">分组管理</div>
                <div class="list-block media-list">
                  <ul>
                      <a href="person_info.php">
                    <li>
                      <div class="item-content">
                        <div class="item-media"><img src="..." width="44"></div>
                        <div class="item-inner">
                          <div class="item-title-row">
                            <div class="item-title">Yellow Submarine</div>
                          </div>
                          <div class="item-subtitle">Beatles</div>
                        </div>
                      </div>
                          </li></a>
                    <li>
                      <div class="item-content">
                        <div class="item-media"><img src="..." width="44"></div>
                        <div class="item-inner">
                          <div class="item-title-row">
                            <div class="item-title">Yellow Submarine</div>
                          </div>
                          <div class="item-subtitle">Beatles</div>
                        </div>
                      </div>
                    </li> 
                    <li class="item-divider"></li>
                    <li>
                      <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title add-fenzu">添加分组</div>
                        </div>
                      </div>
                    </li>                       
                  </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div id="view-3" class="view view-scene tab">
 
        <!-- Pages -->
        <div class="pages navbar-through">
          
 
          <!-- page -->
          <div class="page" data-page="userinfo">
            <div class="page-content">
              <div class="list-block cards-list">
                  <ul>
                    <li class="card">
                      <div class="card-header">Card Header</div>
                      <div class="card-content">
                        <div class="card-content-inner">Card content</div>
                      </div>
                      <div class="card-footer">Card footer</div>
                    </li>
                    <li class="card">
                      <div class="card-header">Card Header</div>
                      <div class="card-content">
                        <div class="card-content-inner">Card content</div>
                      </div>
                      <div class="card-footer">Card footer</div>
                    </li>
                  </ul>
                </div>  
                
            </div>
          </div>
 
          
        </div>

      </div>
      <!-- Bottom Tabbar-->
      <div class="toolbar tabbar tabbar-labels">
        <div class="toolbar-inner">	
        <a href="#view-1" class="tab-link active"> <i class="icon iconfont">&#xe60e;</i><span class="tabbar-label">Group</span></a>
        <a href="#view-2" class="tab-link btn get_user_json"><i class="icon iconfont">&#xe603;</i><span class="tabbar-label">face++</span></a>
        <a href="#view-3" class="tab-link">   <i class="icon iconfont">&#xe630;</i><span class="tabbar-label">help</span></a>
        </div>
      </div>
    </div>
          <!-- Popup添加 -->
    <div class="popup">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"></div>
            <div class="center sliding">添加</div>
            <div class="right"><a href="#" class="link close-popup">Cancel</a></div>
          </div>
        </div>
        <div class="pages">
          <div class="page">
            <div class="page-content">
             	<div class="list-block">
                  <form enctype="multipart/form-data" action="person_f.php"  method="post">
                  <ul>
                    <!-- Text inputs -->
                    <li>
                      <div class="item-content">
                        <div class="item-inner">
                          <div class="item-title label">姓名</div>
                          <div class="item-input">
                              <input type="text" name="name" placeholder="Your name" >
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="item-content">
                        <div class="item-inner">
                          <div class="item-title label">照片</div>
                          <div class="item-input">
                            <input type="file" name="myfile" valuer="选择图片" style="width:100%">
                          </div>
                        </div>
                      </div>
                    </li>
                   
                    <!-- Select -->
                    <li>
                      <div class="item-content">
                        <div class="item-inner">
                          <div class="item-title label">分组</div>
                          <div class="item-input">
                            <select name="group">
                            <?php     
                            $response = $facepp->execute('/info/get_group_list',array(''));
                             $arr = json_decode($response,true); //后面加true转换为数组
                            $a = count($arr['group']);
                            for($i=0;$i<$a;$i++){
                            ?>
                              <option	 value="<?php echo $arr['group'][$i]['group_name'];?>" <?php if($group== $arr['group'][$i]['group_name'])echo "selected=\"selected\"";?>><?php echo $arr['group'][$i]['group_name'];?></option>
                             <?php }?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                      <div class="content-block">
                  <input type="submit" class="button" value="确定">
                </div>
                  </form>
                </div>              
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- Popup历史记录 -->
    <div class="popup history">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"></div>
            <div class="center sliding">face++记录</div>
            <div class="right"><a href="#" class="link close-popup">Cancel</a></div>
          </div>
        </div>
        <div class="pages">
          <div class="page">
            <div class="page-content">
                <div class="list-block cards-list">
                  <ul>
                    <li class="card">
                      <div class="card-content">
                        <div class="list-block media-list">
                          <ul>
                            <li class="item-content pb-standalone">
                              <div class="item-media">
                                <img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="44">
                              </div>
                              <div class="item-inner">
                                <div class="item-title-row">
                                  <div class="item-title">陌生人</div>
                                </div>
                                <div class="item-subtitle">15：20</div>
                              </div>
                            </li>
                            <li class="item-content pb-standalone">
                              <div class="item-media pb-standalone">
                                <img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="44">
                              </div>
                              <div class="item-inner">
                                <div class="item-title-row">
                                  <div class="item-title">朋友</div>
                                </div>
                                <div class="item-subtitle">14：30</div>
                              </div>
                            </li>
                            <li class="item-content pb-standalone">
                              <div class="item-media">
                                <img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="44">
                              </div>
                              <div class="item-inner">
                                <div class="item-title-row">
                                  <div class="item-title">朋友</div>
                                </div>
                                <div class="item-subtitle">13：00</div>
                              </div>
                            </li>                          
                          </ul>
                        </div>
                      </div>
                     
                      <div class="card-footer">
                        <span>2015/05/19</span>
                        <span>3 条记录</span>
                      </div>
                    </li>
                  </ul>
                </div>        
            </div>
          </div>
        </div>
      </div>
    </div>
       <!-- Popup person_info -->
    <div class="popup person-info">
      <div class="view view-popup">
          <!-- Navbar -->
        <div class="navbar theme-green">
          <!-- Home page navbar -->
         <div class="navbar-inner" data-page="person_info">
             <div class="left">
                <!-- Right link contains only icon - additional "icon-only" class-->
                <a href="#" class="link close-popup"><i class="icon icon-back"></i>返回</a>
              </div>
              <div class="right">Face++</div>
         </div>
      </div>
        <div class="pages">
          <div class="page">
            <div class="page-content">
                <div class="card facebook-card">
				<div  class="card-header no-border person-edit" style="background-image:url(http://1.ehac.sinaapp.com/ehac/img/theme/theme_default.png); background-size:cover;" valign="bottom">
                    <div class="facebook-name left"><a href="#" class="link close-popup">Cancel</a></div>
                    <div class="facebook-name"><img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="60" height="60"></div>
                    <div  class="facebook-name del-photo ">John Doe</div>
                    <div class="facebook-date">分组：同学</div>
				</div>
				<div class="card-content">
					<div class="card-content-inner row">
						<img class="col-33 add-face" src="http://1.ehac.sinaapp.com/ehac/img/photo_get.png"  height="120">
						<img class="col-33  del-photo" src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg"  height="120">
						<img class="col-33  del-photo" src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg"  height="120">
					</div>
				</div>
			</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Path to Framework7 Library JS-->
      <script type="text/javascript" src="../js/framework7.min.js"></script>
      <script type="text/javascript" src="../js/face.js"></script>
  </body>
</html> 