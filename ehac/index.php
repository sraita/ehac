<?php
/*
本文件位置
$redirect_url= "http://israel.duapp.com/weixin/oauth2_openid.php";

URL
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ca4836ebbda7287&redirect_uri=http://1.ehac.sinaapp.com/oauth2_openid.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
*/
$code = $_GET["code"];
$userinfo = getUserInfo($code);

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
						<div class="facebook-avatar"><img src="<?php echo $userinfo["headimgurl"];?>" width="44" height="44"></div>
						<div class="facebook-name">SRAITA</div>
						<div class="facebook-date">weitas@qq.com</div>
					  </div>
					  <div class="card-content">
						<div class="card-content-inner">
						 <p class="color-white">Posted on January 21, 2015</p>
						 <a href="color-themes.html" class="link color-white">主题</a>
						</div>
					  </div>
					</li>
                   <li><a href="#" class="close-panel open-login-screen">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">引导页</div>
                        </div>
                      </div></a></li>
                  <li><a href="#" data-popup=".popup-qrcode" class="close-panel open-popup">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">二维码</div>
                        </div>
                      </div></a></li>
				  <li><a href="#"  data-popup=".popup-about" class="close-panel open-popup">
                      <div class="item-content">
                        <div class="item-inner"> 
                          <div class="item-title">关于</div>
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
              <?php
                    include 'include/conn.php';
                    $mysql_table = "device";
                    $mysql_state = "SELECT * FROM " . $mysql_table . " WHERE openid ='o_x4Lj0NzaEevvqdSl5vypXE3BvY' ";
                    $con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
                        if (! $con) {
                            die ( 'Could not connect: ' . mysql_error () );
                        }
                        mysql_query ( "SET NAMES 'UTF8'" );
                        mysql_select_db ( $mysql_database, $con );
                        $result = mysql_query ( $mysql_state );
                        while($row = mysql_fetch_array($result))
                        { if($row['type']==3) {
                             $yanwu = $row['data'];}
                         if($row['type']==2) {
                             $temp = $row['wendu'];
                             $shidu = $row['shidu'];?>
							 <div class="list-block cards-list">
								<ul>
							 <li class="swiper-container swiper-init card facebook-card" data-speed="400" data-space-between="40" data-pagination=".swiper-pagination">
								<div class="swiper-wrapper card-content" style="height:200px; width:100vmax;">
									<div class="swiper-slide" id="smoke" style="height:200px; width:100vmax;"></div>
									<div class="swiper-slide"style="height:200px; width:100vmax;">
										<div id="wenshidu" style="background-image:url(img/tmp_bg.png);  background-size:cover;height:200px;width:200px; float:left;"></div>
											<div class="temp">
											<p class="color-green"><i class="icon iconfont">&#xe607;</i><?php echo $shidu;?> %</p>
											<p class="color-orange"><i class="icon iconfont">&#xe601;</i><?php echo $temp;?>℃</p>
										</div>
									</div>
									<div class="swiper-slide pb-standalone-video"style="height:200px; width:100vmax; background-image:url(img/home_mode.jpg); background-size:cover;"  ></div>
								</div>
								<div class="swiper-pagination"></div>
							  </li> 
							  </ul>
							  </div>
			 <div class="content-block-title">设备列表</div>
				<div class="list-block media-list">
					  <ul>
                         <?php  } if($row['type']==1) {?>
						<li class="swipeout">
						<div class="swipeout-content">
						  <div class="item-content">
                              <div class="item-media"><img src="img/device/<?php echo $row['devicepic'];?>.png" width="44"></div>
							<div class="item-inner">
							  <div class="item-title-row">
								<div class="item-title"><?php echo $row['devicename'];?></div>
							  </div>
							  <div class="item-subtitle">Beatles</div>
							</div>
						  </div>
						</div>
						<div class="swipeout-actions-right">
							<a href="updevice.php?deviceid=<?php echo $row['id'];?>" class="bg-green">设备信息</a>
							<a class="swipeout-delete bg-red" href="./php/del.php?id=<?php echo $row['id'];?>">删除</a>
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
          
 
          <!-- page -->
          <div class="page" data-page="userinfo">
            <div class="page-content">
              
            </div>
          </div>
 
          
        </div>

      </div>
      <div id="view-3" class="view view-scene tab">
           <!-- Navbar -->
        <div class="navbar">


        </div>
           <!-- Pages -->
        <div class="pages navbar-through">
		
          </div>
      </div>
      <div id="view-4" class="view view-help tab">
         <!-- Navbar -->
        <div class="navbar">


        </div>
           <!-- Pages -->
        <div class="pages navbar-through">
		
          </div>
      </div>
      <!-- Bottom Tabbar-->
      <div class="toolbar tabbar tabbar-labels">
        <div class="toolbar-inner">	
        <a href="#view-1" class="tab-link active"> <i class="icon iconfont">&#xe60e;</i><span class="tabbar-label">我的设备</span></a>
        <a href="#view-2" class="tab-link btn get_user_json"><i class="icon iconfont">&#xe603;</i><span class="tabbar-label">个人中心</span></a>
        <a href="#view-3" class="tab-link">   <i class="icon iconfont">&#xe630;</i><span class="tabbar-label">情景模式</span></a>
        <a href="#view-4" class="tab-link"> <i class="icon iconfont">&#xe62a;</i><span class="tabbar-label">使用帮助</span></a>
        </div>
      </div>
    </div>
    <!-- qrcode popup -->
      <div  class="popup popup-qrcode no-navbar no-toolbar no-swipeback">
  <div class="content-block login-screen-content">
    <div class="login-screen-title">My App</div>
    <form>
      <div class="list-block">
        <div class="swiper-container" style="width: auto; margin:5px -15px -15px">
            <div class="swiper-pagination"></div>
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img src="..." height="150" style="display:block"></div>
              <div class="swiper-slide"><img src="..." height="150" style="display:block"></div>
            </div>
        </div>
      </div>
      <div class="list-block">
        <ul>
          <li  class="row">
            <a href="#" class="col-50 item-link list-button close-popup">CLOSE</a>
            <a href="#" class="col-50 item-link list-button open-slider-modal">SHARE</a>
          </li>
        </ul>
        <div class="list-block-label">
        </div>
      </div>
    </form>
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
					<li class="accordion-item"><a href="#" class="item-content item-link">
						<div class="item-inner">
						  <div class="item-title">唐杰辉</div>
						  <div class="item-after">安防报警系统设计</div>

						</div></a>
					  <div class="accordion-item-content">
						<div class="content-block">
						  <p>安防报警系统的设计</p>
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
      <!--  引导页 -->
	<div class="login-screen">
      <div class="view">
        <div class="page">
          <div class="page-content login-screen-content">
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
					<li class="accordion-item"><a href="#" class="item-content item-link">
						<div class="item-inner">
						  <div class="item-title">唐杰辉</div>
						  <div class="item-after">安防报警系统设计</div>

						</div></a>
					  <div class="accordion-item-content">
						<div class="content-block">
						  <p>安防报警系统的设计</p>
						</div>
					  </div>
					</li>
				  </ul>
				<ul>
                  <li><a href="#" class="item-link list-button close-login-screen">CLOSE</a></li>
                </ul>
              </div>
            </form>
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
                        <div class="item-title label">选择设备：</div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-input">
							<span data-color="chazuo" class="color selected"></span>
							<span data-color="diandeng" class="color"></span>
							<span data-color="kaiguan" class="color"></span>
							<span data-color="diannao" class="color"></span>
							<span data-color="dianshi" class="color"></span>
							<span data-color="dianfanguo" class="color"></span>
							<span data-color="kongtiao" class="color"></span>
							<span data-color="jiashiqi" class="color"></span>
							<span data-color="shidu" class="color"></span>
							<span data-color="wenduji" class="color"></span>
							<span data-color="hongwaixian" class="color"></span>
							<span data-color="shexiangtou" class="color"></span>
						</div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="content-block"><a href="index2.php" class="button link close-popup" onclick="addDevice()">添加设备</a></div>
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
var color = $$('.popup .color.selected').attr('data-color');
var id = (new Date()).getTime();
var url = "./php/add.php?devicename="+title+"&devicepic="+color+"&id="+id;
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
            window.location.assign("/index.php")
        }
      },
    ]
  })


}
</script>
     <!-- ECharts单文件引入 -->
  <script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts图表
        var myChart = echarts.init(document.getElementById('smoke')); 
        
myChart.showLoading({
    text: '正在努力的读取数据中...',    //loading话术
});

// ajax getting data...............

// ajax callback
myChart.hideLoading();
	option = {
    tooltip : {
        formatter: "{a} <br/>{c} {b}"
    },
                loadingOption:{
    
    effect:'whirling',
    
    },
    toolbox: {
        show : false,
        feature : {
            mark : {show: true},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
        
        {
            name:'烟雾浓度',
            type:'gauge',
            center : ['50%', 220],    // 默认全局居中
            radius : 190,
            min:0,
            max:10000,
            startAngle:150,
            endAngle:30,
            splitNumber:2,
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.2, 'lime'],[0.4, '#1e90ff'],[0.7, '#ff4500'],[1, 'red']],
                    width: 2,
                    shadowColor : '#fff', //默认透明
                    shadowBlur: 10
                }
            },
            axisTick: {            // 坐标轴小标记
                length :5,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: 'auto',
                    shadowColor : '#fff', //默认透明
                    shadowBlur: 10
                }
            },
            axisLabel: {
                textStyle: {       // 属性lineStyle控制线条样式
                    fontWeight: 'bolder',
                    color: 'auto',
                    shadowColor : '#fff', //默认透明
                    shadowBlur: 10
                },
                formatter:function(v){
                    switch (v + '') {
                        case '0' : return 'L';
                        case '10000' : return 'H';
                    }
                }
            },
            splitLine: {           // 分隔线
                length :8,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                    width:3,
                    color:'auto',
                    shadowColor : '#fff', //默认透明
                    shadowBlur: 10
                }
            },
            pointer: {
                width:2,
                shadowColor : '#fff', //默认透明
                shadowBlur: 5
            },
             title : {
                  show : false,
                width: 80,
                height:30,
                offsetCenter: [25, -68], 
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    fontWeight: 'bolder',
                    fontSize: 20,
                    color: 'auto',
               
                }
            },
             detail : {
                //backgroundColor: 'rgba(30,144,255,0.8)',
               // borderWidth: 1,
              
                width: 80,
                height:30,
                formatter:'{value} ppm',
                offsetCenter: [0, -80],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    fontWeight: 'bolder',
                    color: 'auto',
                    fontSize: 20,
                }
            },
            data:[{value: <?php echo $yanwu;?>, name: 'ppm'}]
        }
    ]
};
         // 为echarts对象加载数据 
 myChart.setOption(option);
      var myChart2 = echarts.init(document.getElementById('wenshidu'));                                 
 option2 = {
  
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c}%"
    },
    toolbox: {
        show : false,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
        {
            name:'温度',
            type:'gauge',
            center : ['50%', '70%'],    // 默认全局居中
            radius : '40%',
            min:-10,
            max:50,
            startAngle:0,
            endAngle:-180,
            splitNumber: 10,       // 分割段数，默认为5
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.2, '#228b22'],[0.8, '#48b'],[1, '#ff4500']], 
                    width: 4
                }
            },
            axisTick: {            // 坐标轴小标记
                splitNumber: 10,   // 每份split细分多少段
                length :6,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: 'auto'
                }
            },
            axisLabel: { 
                show:false,// 坐标轴文本标签，详见axis.axisLabel
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto'
                },
                formatter:function(t){
                    switch (t + '') {
                        case '-10' : return 'L';
                        case '0' : return '0';
                        case '50' : return 'H';
                    }
                }
            },
            splitLine: {           // 分隔线
                show: true,        // 默认显示，属性show控制显示与否
                length :8,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                    color: 'auto'
                }
            },
            pointer : {
                width : 5,
                color:'orange',
            },
            title : {
                show : false,
                offsetCenter: [0, -150],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    fontZise:14,
                }
            },
            detail : {
                show:false,
                offsetCenter: [0, 25],
                formatter:'温度：{value}℃',
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'orange',
                    fontWeight: 'bolder',
                    fontSize:16,
                }
            },
            data:[{value: <?php echo $temp;?>, name: '℃'}]
        },
        {
            name:'湿度',
            type:'gauge',
            splitNumber: 10,       // 分割段数，默认为5
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.2, '#228b22'],[0.8, '#48b'],[1, '#ff4500']], 
                    width: 4
                }
            },
            axisTick: {            // 坐标轴小标记
                splitNumber: 10,   // 每份split细分多少段
                length :8,        // 属性length控制线长
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: 'auto'
                }
            },
            axisLabel: {           // 坐标轴文本标签，详见axis.axisLabel
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'auto'
                }
            },
            splitLine: {           // 分隔线
                show: true,        // 默认显示，属性show控制显示与否
                length :12,         // 属性length控制线长
                lineStyle: {       // 属性lineStyle（详见lineStyle）控制线条样式
                    color: 'auto'
                }
            },
            pointer : {
                width : 5
            },
            title : {
                show : false,
                offsetCenter: [0, 50],       // x, y，单位px
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    fontWeight: 'bolder'
                }
            },
            detail : {
                show:false,
                offsetCenter: [0, 40],
                formatter:'湿度：{value}%',
                textStyle: {       // 其余属性默认使用全局文本样式，详见TEXTSTYLE
                    color: 'blue',
                    fontWeight: 'bolder',
                    fontSize:16,
                }
            },
            data:[{value: <?php echo $shidu;?>, name: '%'}]
        }
    ]
};
                    
                          
myChart2.setOption(option2);

    </script>