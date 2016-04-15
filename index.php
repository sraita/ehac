<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>智能家居</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="css/framework7.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
    <link rel="stylesheet" href="css/todo7.css">
    <style>
  	.facebook-card .card-header {
   	 display: block;
     padding: 10px;
    }
    .facebook-card .facebook-avatar {
     float: left;
    }
    .facebook-card .facebook-name {
     margin-left: 50px;
     font-size: 16px;
     font-weight: 500;
    }
    .facebook-card p{
	font-size:36px;
	  margin:0px;
	  padding:0px;
	}
	.card{
	font-size:14px;
	color:#999;
	}
	.facebook-card .temp{
		position:absolute;
		float:right;
	  margin-top:40px;
	  padding-left:210px;
	}
    .facebook-card .button{
	 color:#F00;
	  border-bottom:#F00;
	  border-radius:0px;
	}
    .facebook-card .tab-link{
	 border-radius:0px;
    }
   .facebook-card .card-footer {
    background:none;
   }
   .facebook-card .card-content img {
    display: block;
   }
   .facebook-card .card-content-inner {
    padding: 15px 10px;
   }  
 
  </style>
  </head>
  <body>
    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>
    <!-- Right panel with cover effect-->
    <div class="panel panel-right panel-cover">
      <div class="content-block">
        
          
      </div>
    </div>
    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views tabs toolbar-through">
      <!-- Your first view, it is also a .tab and should have "active" class to make it visible by default-->
      <div id="view-1" class="view view-main tab active">
          <!-- Top Navbar-->
        <div class="navbar theme-white">
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
            <div class="page-content">
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
                        { 
                         if($row['type']==3) {
                             $yanwu = $row['data'];}
                         if($row['type']==2) {
                             $temp = $row['wendu'];
                             $shidu = $row['shidu'];
                            echo 
                '<!--传感器-->
             <div class="list-block cards-list">
              <ul>
                <li class="card facebook-card">
                   <div class="card-content tabs">
                    <div id="smoke" style="height:200px; width:100vmax;" class="tab active">
                      
                    </div>
                    <div id="tab2" style="height:200px; width:100vmax;" class="tab">
                        <div id="wenshidu" style="background-image:url(img/tmp_bg.jpg);  background-size:cover;height:200px;width:200px; float:left;"></div>
                        <div class="temp">
                            <p class="color-green"><i class="icon iconfont">&#xe607;</i> ';
                               echo $shidu;
                              echo  ' %</p>
                        <p class="color-orange"><i class="icon iconfont">&#xe601;</i> ' ;
                            echo $temp;
                            echo '℃</p>
                        </div>
                    
                    </div>
                    <div id="tab3" style="height:200px; width:100vmax; background-image:url(img/home_mode.jpg); background-size:cover;" class="tab pb-standalone-video">
                      
                       </div>  
                  </div>
                  <div class="buttons-row color-red">
                      <!-- 关联到第一个tab, 默认激活 -->
                      <a href="#smoke"  class="tab-link active button">烟雾火警</a>
                      <!-- 关联到第二个tab -->
                      <a href="#tab2" class="tab-link  button">温湿度</a>
                      <!-- 关联到第三个tab -->
                      <a href="#tab3" class="tab-link button">智能安防</a>
                  </div>
                </li>';
					
                        }   
                    echo '<li class="card swipeout"><div class="card-content swipeout-content">';
                  switch ($row['devicepic'])
                   {case "diandeng":
                    echo '<div class="list-block item-content color-orange"><div class="item-media"><i class="icon icondevice">&#xe63d;</i>';
                    break;
                    case "kongdiao":
                     echo '<div class="list-block item-content color-green"><div class="item-media"><i class="icon icondevice">&#xe604;</i>';
                    break;
                    case "jiashiqi":
                     echo '<div class="list-block item-content color-bule"><div class="item-media"><i class="icon icondevice">&#xe607;</i>';
                    break;
                    case "dianshi":
                    break;
                    default:
                    echo '<div class="list-block item-content color-red"><div class="item-media"><i class="icon icondevice">&#xe61b;</i>';
                    break;
                   }
                    echo '</div>
                          <div class="item-inner ">
                            <div class="item-title-row">
                              <div class="item-title">';
                    echo    $row['devicename'];
 					echo '</div>
                            </div>';
                    switch ($row['devicescene'])
                   {case "leave_mode":
                    echo '<div class="item-subtitle "><i class="icon iconfont color-lightblue">&#xe61f;</i></div>';
                    break;
                    case "home_mode":
            		echo '<div class="item-subtitle "><i class="icon iconfont color-lightblue">&#xe61f;</i></div>';
                    break;
                    case "rise_mode":
                    echo '<div class="item-subtitle "><i class="icon iconfont color-lightblue">&#xe61f;</i></div>';
                    break;
                    default:
                    echo '<div class="item-subtitle "><i class="icon iconfont color-lightblue">&#xe61b;</i></div>';
                    break;
                   }
                   echo '</div>
                    </div>
                  </div>
                  <div class="swipeout-actions-left">
                        <a href="#" data-popup=".popup-device_info" class="action2 bg-green open-popup">设备信息</a>
                        
                    </div>
                    <div class="swipeout-actions-right">
                    
                        <a href="#" class="swipeout-delete" data-confirm="确认删除';
                            echo $row['id'];
                            echo '?" data-confirm-title="';
                            echo $row['devicename'];
                            echo '">删除</a>
                    </div>
                </li>';
                   }
                        mysql_close ( $con );
                  ?>
                  
              </ul>
            </div>
            <!---->      
                
            </div>
          </div>
        </div>
      </div>
      <!-- Second view (for second wrap)-->
      <div id="view-2" class="view view-user tab ">
       
         <!-- Navbar -->
        <div class="navbar theme-white">
         
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
        <div class="navbar theme-white">


        </div>
           <!-- Pages -->
        <div class="pages navbar-through">
		
          </div>
      </div>
      <div id="view-4" class="view view-help tab">
         <!-- Navbar -->
        <div class="navbar theme-white">


        </div>
           <!-- Pages -->
        <div class="pages navbar-through">
		
          </div>
      </div>
      <!-- Bottom Tabbar-->
      <div class="toolbar tabbar tabbar-labels theme-red">
        <div class="toolbar-inner">	
        <a href="#view-1" class="tab-link active"> <i class="icon iconfont">&#xe60e;</i><span class="tabbar-label">我的设备</span></a>
        <a href="#view-2" class="tab-link"><i class="icon iconfont">&#xe603;</i><span class="tabbar-label">个人中心</span></a>
        <a href="#view-3" class="tab-link">   <i class="icon iconfont">&#xe630;</i><span class="tabbar-label">情景模式</span></a>
        <a href="#view-4" class="tab-link"> <i class="icon iconfont">&#xe62a;</i><span class="tabbar-label">使用帮助</span></a>
        </div>
      </div>
    </div>
    <!-- Popup 设备信息 -->
    <div class="popup popup-device_info">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"></div>
            <div class="center sliding">设备信息</div>
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
                          <input type="text" name="title" >
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-inner">
						<div class="item-title label">设备描述</div>
							<div class="item-input">
							<input type="text" name="设备描述">
							</div>
					  </div>
					</div>
                  </li>
                </ul>
              </div>
              <div class="content-block"><a class="button add-task">保存</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>      
 
      <!-- Popup 定时任务 -->
    <div class="popup popup-device_dingshi">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"></div>
            <div class="center sliding">定时任务</div>
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
                        <div class="item-title label">设备状态</div>
                        <div class="item-input">
                          <label class="label-switch">
                            <input type="checkbox">
                            <div class="checkbox"></div>
                          </label>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">任务时间</div>
                        <div class="item-input">
                           <input type="text" placeholder="09:00 - 10:00" readonly id="automate">

                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="content-block"><a class="button add-task">设定任务</a></div>
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
                  <br>
                  <br>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-input"><span data-color="orange" class="color selected"></span><span data-color="green" class="color"></span><span data-color="blue" class="color"></span><span data-color="yellow" class="color"></span><span data-color="white" class="color"></span><span data-color="pink" class="color"></span><span data-color="purple" class="color"></span><span data-color="cyan" class="color"></span></div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="content-block"><a class="button add-task">Add  Task</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>        
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="js/framework7.min.js"></script>
    <!-- Path to your app js-->
    <script type="text/javascript" src="js/todo7.js"></script>
  </body>
</html>      <!-- ECharts单文件引入 -->
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
    backgroundColor: '#1b1b1b',
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