<?php
/*
本文件位置
$redirect_url= "http://israel.duapp.com/weixin/oauth2_openid.php";

URL
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ca4836ebbda7287&redirect_uri=http://1.ehac.sinaapp.com/oauth2_openid.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
*/
session_start();

include_once( '../weibo/config.php' );
include_once( '../weibo/saetv2.ex.class.php' );
$code = $_GET["code"];
$token =$_GET["access"];
$userinfo = getUserInfo($code);
$userinfo1 = getUserInfo1($code);
function getUserInfo($code)
{
	$appid = "wx5ca4836ebbda7287";
	$appsecret = "afd33592eb230c2f8f9936881b2383ba";

   //oauth2的方式获得openid
	$access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$access_token_json = https_request($access_token_url);
	$access_token_array = json_decode($access_token_json, true);
	$openid = $access_token_array['openid'];

    //非oauth2的方式获得全局access token
    $new_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    $new_access_token_json = https_request($new_access_token_url);
	$new_access_token_array = json_decode($new_access_token_json, true);
	$new_access_token = $new_access_token_array['access_token'];
    
    //全局access token获得用户基本信息
    $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$new_access_token&openid=$openid";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);
	return $userinfo_array;
}

function https_request($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
	curl_close($curl);
	return $data;
}
function getUserUid($code2)
{
    $token =  $_SESSION['token']['access_token'];
 $uid_url = "https://api.weibo.com/2/place/users/show.json?access_token=$token";
    $uid_json=https_request($uid_url);
    $uid_array = json_decode($uid_json, true);
    return $uid_array;
}
function getUserInfo1($code)
{
//全局access token获得用户基本信息
    $code2 = $_GET["code2"];
    $uid = getUserUid($code2);
    $a = $uid["uid"];
    $userinfo_url = "https://api.weibo.com/2/users/show.json?access_token=2.00yoq1vBJW9sPCf4ca32826fgdsvYC&uid=$a";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);
	return $userinfo_array;
}
require_once 'face/facepp_sdk.php';
$facepp = new Facepp();
?>
<?php 
setcookie("userid", $userinfo["openid"], time()+1200);
session_start();
$uid=  $_SESSION['token']['uid'];
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>智能家居</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="css/framework7.min.css">
	<link rel="stylesheet" href="css/framework7.themes.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/todo7.css">
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
    <!-- add scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.Jcrop.min.js"></script>
    <script src="js/script.js"></script>
      <style>
          li .unlink{
              color:red;
          }
          .facebook-card{
              padding:0;
              margin:0;
          }
          .facebook-card .card-header {
            display: block;
            padding: 20px;
          }
          .facebook-card .facebook-avatar {
            float: left;
          }
          .facebook-card .facebook-name {
            margin:5 100px;
            font-size: 16px;
            font-weight: 500;
              color: #ffffff;
          }
          .facebook-card .facebook-date {
            font-size: 16px;
            color: #ffffff;
          }
          .facebook-card .facebook-name img
          {
              border:2px solid #ffffff;
              border-radius:100%;
          
          }
          .fileInput{width:102px;height:34px; background:url(http://ehac-img.stor.sinaapp.com/005EB277AC3A84244D9941ECA550364B_dat.jpg);overflow:hidden;position:relative;}
 		  .upfile{position:absolute;top:-100px;}
 		  .upFileBtn{width:102px;height:34px;opacity:0;filter:alpha(opacity=0);cursor:pointer;}
     
      </style>
  </head>
  <body>
    <div class="statusbar-overlay"></div>
    <div class="panel-overlay"></div>
    <div class="panel panel-right panel-cover">
      <div class="view view-right">
        <div class="pages">
          <div data-page="panel-right1" class="page">
            <div class="page-content"> 
              <div class="list-block cards-list">
				<ul>
				  <li  valign="bottom" class="fengmian card demo-card-header-pic no-border">
					  <div  class="card-header color-white no-border">
						<div class="facebook-avatar"><img src="<?php echo $userinfo["headimgurl"];echo $userinfo1["profile_image_url"];?>" width="44" height="44"></div>
						<div class="facebook-name"><?php echo $userinfo["nickname"];echo $userinfo1["screen_name"];?></div>
						<div class="facebook-date"><?php  echo $userinfo["sex"];echo $userinfo1["sex"];?></div>
					  </div>
					  <div class="card-content">
						<div class="card-content-inner">
						 <p class="color-white"><?php echo $userinfo1["description"];?></p>
						 <a href="color-themes.html" class="link color-white">主题</a>
						</div>
					  </div>
					</li>
				  <li><a href="#"  data-popup=".popup-help" class="close-panel open-popup">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">使用帮助</div>
                        </div>
                      </div></a></li>
				  <li><a href="#"  data-popup=".popup-about" class="close-panel open-popup">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">关于</div>
                        </div>
                      </div></a></li>
                  <li><a href="#"  data-popup=".popup-face-group" class="close-panel open-popup">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">Face++ Group</div>
                        </div>
                      </div></a></li>    
				  <li><a href="#"  data-popup=".popup-face-history" class="close-panel open-popup">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">Face++ 记录</div>
                        </div>
                      </div></a></li>                    
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views tabs toolbar-through">
      <!-- Your first view, it is also a .tab and should have "active" class to make it visible by default-->
      <div id="view-1" class="view view-main tab active">
          <!-- Top Navbar-->
        <div class="navbar">
          <!-- Navbar inner for Index page-->
          <div data-page="index" class="navbar-inner">
            <!-- We have home navbar without left link-->
            <div class="left">
              <!-- Right link contains only icon - additional "icon-only" class--><a href="#" class="link icon-only open-panel"><i class="icon icon-bars"></i></a>
            </div>
            <div class="center sliding">我的设备</div>
            <div class="right">
              <a href="#" class="link icon-only open-popup"><i class="icon icon-plus">+</i></a>
            </div>
          </div>
        </div>
        <!-- Pages-->
        <div class="pages navbar-through">
          <!-- Page, data-page contains page name-->
          <div data-page="index-1" class="page">
            <!-- Scrollable page content-->
            <div class="page-content pull-to-refresh-content">
                <div class="pull-to-refresh-layer">
                  <div class="preloader"></div>
                  <div class="pull-to-refresh-arrow"></div>
                </div>
                							 
			 <div class="content-block-title">设备列表</div>
				<div class="list-block media-list">
					  <ul>
              <?php
                    include 'include/conn.php';
                    $mysql_state = "SELECT * FROM device  WHERE openid ='".$userinfo['openid']."' OR uid ='".$uid."' ";
                    $con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
                        if (! $con) {
                            die ( 'Could not connect: ' . mysql_error () );
                        }
                        mysql_query ( "SET NAMES 'UTF8'" );
                        mysql_select_db ( $mysql_database, $con );
                        $result = mysql_query ( $mysql_state );
                        while($row = mysql_fetch_array($result))
                        { 
                         if($row['sid']==1) {
                             $temp = substr($row['data'],3);
                             $shidu = substr($row['data'],0,2);?>
                          <li class="swipeout">
						<div class="swipeout-content">
						  <div class="item-content">
                              <div class="item-media"><img src="img/device/<?php echo $row['devicepic'];?>.png" width="44"></div>
							<div class="item-inner">
							  <div class="item-title-row">
								<div class="item-title"><a href="temp.php" class="unlink olor-green"><?php echo $row['devicename'];?> </a></div>
							  </div>
							  <div class="item-subtitle"><?php echo $shidu;?> % <?php echo $temp;?>℃</div>
							</div>
						  </div>
						</div>
						<div class="swipeout-actions-right">
							<a href="updevice.php?deviceid=<?php echo $row['id'];?>" class="bg-green">设备信息</a>
							<a class="swipeout-delete bg-red" href="devicedel.php?id=<?php echo $row['id'];?>">删除</a>
					    </div>
                              </li>
                         <?php  } if($row['data']!= null&&$row['sid']==2) {?>
                          						<li class="swipeout">
						<div class="swipeout-content">
						  <div class="item-content">
                              <div class="item-media"><img src="img/device/<?php echo $row['devicepic'];?>.png" width="44"></div>
							<div class="item-inner">
							  <div class="item-title-row">
                                  <div class="item-title"><a href="smokealarm.php" class="unlink color-black"><?php echo $row['devicename'];?></a></div>
							  </div>
                                <div class="item-subtitle"><?php echo $row['data'];?>  N<small>2</small>O</div>
							</div>
						  </div>
						</div>
						<div class="swipeout-actions-right">
							<a href="updevice.php?deviceid=<?php echo $row['id'];?>" class="bg-green">设备信息</a>
							<a class="swipeout-delete bg-red" href="devicedel.php?id=<?php echo $row['id'];?>">删除</a>
					    </div>
						</li> 
                          <?php  } if($row['data']== null&&$row['sid']==4) {?>
                          						<li class="swipeout">
						<div class="swipeout-content">
						  <div class="item-content">
                              <div class="item-media"><img src="img/device/<?php echo $row['devicepic'];?>.png" width="44"></div>
							<div class="item-inner">
							  <div class="item-title-row">
								<div class="item-title"><?php echo $row['devicename'];?></div>
							  </div>
                                <div class="item-subtitle">
                                 <?php 
                                   if($row['status']==0)
                         			{
		                             echo "环境正常";
                                   }else if($row['status']==1){
                                     echo "环境异常";
                                   }else{
                                     echo "设备连接失败！";
                                   }
                                   ?>                                
                                </div>
							</div>
						  </div>
						</div>
						<div class="swipeout-actions-right">
							<a href="updevice.php?deviceid=<?php echo $row['id'];?>" class="bg-green">设备信息</a>
							<a class="swipeout-delete bg-red" href="devicedel.php?id=<?php echo $row['id'];?>">删除</a>
					    </div>
						</li> 
                         <?php  } if($row['data']==null&&$row['sid']==3) {?>
						<li class="swipeout">
						<div class="swipeout-content">
						  <div class="item-content">
                              <div class="item-media"><img src="img/device/<?php echo $row['devicepic'];?>.png" width="44"></div>
							<div class="item-inner">
							  <div class="item-title-row">
								<div class="item-title"><?php echo $row['devicename'];?></div>
							  </div>
							  <div class="item-subtitle">
                                  <?php 
                                   if($row['status']==0)
                         			{
		                             echo "状态：关闭";
                                   }else if($row['status']==1){
                                     echo "状态：打开";
                                   }else{
                                     echo "设备连接失败！";
                                   }
                                   ?>
                              </div>
							</div>
						  </div>
						</div>
						<div class="swipeout-actions-right">
							<a href="updevice.php?deviceid=<?php echo $row['id'];?>" class="bg-green">设备信息</a>
							<a class="swipeout-delete bg-red" href="devicedel.php?id=<?php echo $row['id'];?>">删除</a>
					    </div>
						</li> 	
                     <?php }}?>
					</ul>
			    </div>
                <br/>
                <br/>
            </div>
          </div>
        </div>
      </div>
      <!-- Second view (for second wrap)-->
      <div id="view-2" class="view view-user tab ">
       
         <!-- Navbar -->
        <div class="navbar">
         
        </div>
 
        <!-- Pages -->
        <div class="pages navbar-through">
          
 

 
          
        </div>

      </div>
      <div id="view-3" class="view view-scene tab">
         <!-- Top Navbar-->
        <div class="navbar">
          <!-- Navbar inner for Index page-->
          <div data-page="index" class="navbar-inner">
            <!-- We have home navbar without left link-->
            <div class="left">
              <!-- Right link contains only icon - additional "icon-only" class--><a href="#" class="link icon-only open-panel"><i class="icon icon-bars"></i></a>
            </div>
            <div class="center sliding">Face++</div>
            <div class="right">
                <a href="face/person/add_person.php"   class="link icon-only "><i class="icon icon-plus">+</i></a>
            </div>
          </div>
        </div>
        <div class="pages navbar-through">
          <div data-page="index-2" class="page">
              <!-- Search bar -->
              <form data-search-list=".list-block-search" data-search-in=".item-inner" class="searchbar searchbar-init">
                <div class="searchbar-input">
                  <input type="search" placeholder="Search"><a href="#" class="searchbar-clear"></a>
                </div><a href="#" class="searchbar-cancel">Cancel</a>
              </form>
             
              <!-- Search bar overlay -->
              <div class="searchbar-overlay"></div>
            <div class="page-content">
                  <div class="list-block">
                  <ul>
                    <li class="item-content">
                      <div class="item-media"><i class="icon iconfont">&#xe607;</i></div>
                      <div class="item-inner">
                        <div class="item-title">访客管理</div>
                      </div>
                    </li>
                    <li class="item-content">
                      <div class="item-media"><i class="icon iconfont">&#xe601;</i></div>
                      <div class="item-inner">
                        <div class="item-title">未采集识别照片</div>
                      </div>
                    </li>                      
                    </ul>
                    </div>
              <div class="list-block media-list list-block-search  searchbar-found">
                <ul>
                    <?php 
                        $personlist = $facepp->execute('/info/get_person_list',array(''));
                        $arr = json_decode($personlist,true); //后面加true转换为数组
                        $b = count($arr['person']);
                        for($j=0;$j<$b;$j++){
                           $get_face_id = $facepp->execute('/person/get_info',array('person_name'=>$arr['person'][$j]['person_name']));
                            		$arr_face = json_decode($get_face_id,true);
                            		$get_img = $facepp->execute('/info/get_face',array('face_id'=>$arr_face['face'][0]['face_id']));
                                    $arr_img = json_decode($get_img,true);
                                    $img_url = $arr_img['face_info'][count($arr_img)-1]['url'];
                            //if($arr_face['group'][0]['group_name'] != null){
                        ?> 
                    <li><a href="face/person/person_info.php?person_id=<?php echo $arr['person'][$j]['person_id'];?>" class="item-link">
                      <div class="item-content">
                        <div class="item-media"><img src="<?php echo $img_url;?>" width="60" height="60"></div>
                        <div class="item-inner"> 
                          <div class="item-title-row">
                            <div class="item-title"><?php echo $arr['person'][$j]['person_name'];?></div>
                            <div class="item-after"><?php echo $arr_face['tag'][0];?></div>
                          </div>
                          <div class="item-subtitle"><?php echo $arr_face['group'][0]['group_name'];?></div>
                        </div>
                      </div></a></li>
                    <?php }?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="view-4" class="view view-help tab">
 
      </div>
      <!-- Bottom Tabbar-->
      <div class="toolbar tabbar tabbar-labels">
        <div class="toolbar-inner">	
        <a href="#view-1" class="tab-link active"> <i class="icon iconfont">&#xe60a;</i><span class="tabbar-label">我的设备</span></a>
        <a href="#view-2" class="tab-link "><i class="icon iconfont">&#xe60b;</i><span class="tabbar-label">个人中心</span></a>
        <a href="#view-3" class="tab-link"> <i class="icon iconfont">&#xe602;</i><span class="tabbar-label">Face++</span></a>
        </div>
      </div>
    </div> 
<!-- Face++ 历史 popup -->
<div  class="popup popup-face-history no-navbar no-toolbar no-swipeback">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"><a href="#" class="link close-popup">Cancel</a></div>
            <div class="center sliding">Face++ 记录</div>
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
<!-- Face++ Group popup -->
<div  class="popup popup-face-group no-navbar no-toolbar no-swipeback">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"><a href="#" class="link close-popup">Cancel</a></div>
            <div class="center sliding">Face++ Group</div>
          </div>
        </div>
        <div class="pages">
          <div class="page">
            <div class="page-content">
               <div class="content-block-title">分组管理</div>
                <div class="list-block">
                  <ul>
                    <li class="item-content group_add">
                      <div class="item-inner">
                        <div class="item-title">添加分组</div>
                      </div>
                    </li>
                    <li class="item-divider"></li>
                    <?php
					$get_group = $facepp->execute('/info/get_group_list',array(''));
                    $arr_group = json_decode($get_group,true);
                    $group_num = count($arr_group['group']);
                    for($i=0;$i<$group_num;$i++)
                    {
					?>
                      <li class="swipeout">
                      <!-- 被“swipeout-content”包裹起来的普通列表元素 -->
                      <div class="swipeout-content">
                        <!-- 你的列表元素放在这里 -->
                        <div class="item-content">
                          <div class="item-inner" id="group_name"><?php echo $arr_group['group'][$i]['group_name'];?></div>
                        </div>
                      </div>
                      <!-- Swipeout actions right -->
                      <div class="swipeout-actions-right">
                        <!-- Swipeout actions links/buttons -->
                        <a href="#" class="swipeout-close bg-green">Edit</a>
                        <a class="swipeout-close  bg-red group_del" onclick="del_group('<?php echo $arr_group['group'][$i]['group_name'];?>');">Del</a>
                      </div>
                    </li>
                      <?php }?>
                  </ul>
                </div>  
            </div>
          </div>
        </div>
      </div>
</div>  
    <!-- Popup 关于 -->     
	   <div  class="popup popup-about no-navbar no-toolbar no-swipeback">
  <div class="content-block login-screen-content">
    <div class="login-screen-title">智能家居系统</div>
            <form>
              <div class="list-block accordion-list">
                
                <div class="list-block-label">基于Arduino的智能家居系统<br>安防报警系统、云端服务器软件、安防监控系统、智能家居网关4部分组成</div>
				<div class="content-block-title">团队成员：</div>
				  <ul>
					<li class="accordion-item"><a href="#" class="item-content item-link">
						<div class="item-inner">
						  <div class="item-title">桂富波</div>
						  <div class="item-after">云端服务器软件设计</div>

						</div></a>
					  <div class="accordion-item-content">
						<div class="content-block">
						  <p>云端服务器软件的设计</p>
						</div>
					  </div>
					</li>
					<li class="accordion-item"><a href="#" class="item-content item-link">
						<div class="item-inner">
						  <div class="item-title">刘昱</div>
						  <div class="item-after">安防监控系统设计</div>

						</div></a>
					  <div class="accordion-item-content">
						<div class="content-block">
						  <p>安防监控系统的设计</p>
						</div>
					  </div>
					</li>
					<li class="accordion-item"><a href="#" class="item-content item-link">
						<div class="item-inner">
						  <div class="item-title">杨烁</div>
						  <div class="item-after">智能家居网关设计</div>

						</div></a>
					  <div class="accordion-item-content">
						<div class="content-block">
						  <p>智能家居网关的设计</p>
						</div>
					  </div>
					</li>
				  </ul>
				<ul>
                  <li><a href="#" class="item-link list-button close-popup">CLOSE</a></li>
                </ul>
              </div>
            </form>
  </div>
</div> 
    <!-- Popup 使用帮助 -->     
<div  class="popup popup-help no-navbar no-toolbar ">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"><a href="#" class="link close-popup">Cancel</a></div>
            <div class="center sliding">使用帮助</div>
          </div>
        </div>
        <div class="pages">
          <div class="page">
            <div class="page-content">
             <div class="content-block-inner">
              <p>使用帮助文档</p>
         
              <p>
                <img data-src="https://api.sinas3.com/v1/SAE_ehac/wechatimg/system.jpg" width="100%" class="lazy lazy-fadeIn">
              </p>
              <p>目前未填充内容</p>
         
              <p>
                <img data-src="https://api.sinas3.com/v1/SAE_ehac/wechatimg/team.jpg" width="100%" class="lazy lazy-fadeIn">
              </p>
            </div>
            </div>
          </div>
        </div>
      </div>
</div>  
       <!-- Popup添加设备 -->
    <div class="popup">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"></div>
            <div class="center sliding">添加设备</div>
            <div class="right"><a href="#" class="link close-popup">Cancel</a></div>
          </div>
        </div>
        <div class="pages">
          <div class="page">
            <div class="page-content">
              <div class="list-block">
                <ul>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">设备名称</div>
                        <div class="item-input">
                          <input type="text" name="title">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">设备编号</div>
                        <div class="item-input">
                          <input type="text" name="nid">
                        </div>
                      </div>
                    </div>
                  </li>                    
				  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">设备类型：</div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-input">
							<span data-sid="003" data-color="chazuo" class="color selected"></span>
							<span data-sid="003"  data-color="diandeng" class="color"></span>
							<span data-sid="003"  data-color="kaiguan" class="color"></span>
							<span data-sid="003"  data-color="diannao" class="color"></span>
							<span data-sid="003"  data-color="dianshi" class="color"></span>
							<span data-sid="003"  data-color="dianfanguo" class="color"></span>
							<span data-sid="003"  data-color="kongtiao" class="color"></span>
							<span data-sid="003"  data-color="jiashiqi" class="color"></span>
							<span data-sid="002"  data-color="qiti" class="color"></span>
							<span data-sid="001"  data-color="wenduji" class="color"></span>
							<span data-sid="004"  data-color="hongwaixian" class="color"></span>
							<span data-sid="005"  data-color="shexiangtou" class="color"></span>
						</div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="content-block"><a href="#" class="button link close-popup" onclick="addDevice()">添加设备</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
	<!-- Template for 设备-->
    <script id="todo-item-template" type="text/template">
      <ul>{{#each this}}
        <li data-color="{{color}}" data-id="{{id}}" class="swipeout">
          <div class="swipeout-content">
            <label class="label-checkbox item-content"><input type="checkbox" {{checked}}>
              <div class="item-media"><i class="icon icon-form-checkbox"></i></div>
              <div class="item-inner">
                <div class="item-title">{{title}}</div>
              </div>
            </label>
          </div>
          <div class="swipeout-actions-right"><a href="#" class="swipeout-delete">Delete</a></div>
        </li>{{/each}}
      </ul>
    </script>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="js/framework7.min.js"></script>
    <script type="text/javascript" src="js/todo71.js"></script>
  </body>
</html> 
<script type="text/javascript">
$$('.swipeout').on('deleted', function () {
  myApp.modal({
    title:  '',
    text: '删除成功！',
    buttons: [
      {
        text: '确定',
      },
    ]
  })
});
function addDevice()
{
var title = $$('.popup input[name="title"]').val().trim();
var nid = $$('.popup input[name="nid"]').val().trim();
var color = $$('.popup .color.selected').attr('data-color');
var sid = $$('.popup .color.selected').attr('data-sid');
var id = (new Date()).getTime();
var url = "add.php?devicename="+title+"&nid="+nid+"&devicepic="+color+"&sid="+sid+"&id="+id;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();
myApp.modal({
    title:  '',
    text: '设备添加成功！',
    buttons: [
      {
        text: '确定',
        onClick: function() {
        window.location.assign("/ehac/index.php")
        }
      },
    ]
  })


}
</script>