<?php 
//百度ECharts图表数据获取类

//获取当前用户openid或uid
//引入数据库连接文件
include 'include/conn.php';
$mysql_table = "api_worklist";
$mysql_state = "SELECT * FROM " . $mysql_table . " ";
	
$con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
	if (! $con) {
		die ( 'Could not connect: ' . mysql_error () );
	}
//根据openid或uid获取sid和nid
//$sid = '';
//$nid = '';
//$sql = "SELECT  * FROM ehac_user WHERE openid '' OR uid = ''";
//$result = mysqli_query($conn,$sql);
//while($row = mysqli_fetch_array($result))
//{
  // if(strlen($row['data'])==8)
   //{
   //$humidity = substr($row['data'],0,2);
   //}
 //}
 //echo $humidity;
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- Your app title -->
    <title>烟雾值</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="css/framework7.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/my-app.css">
<script src="js/echarts-all.js"></script>
 <script>
 function loadScript(url,callback){ 
   var script = document.createElement("script");
   script.type = "text/javascript"; 
   script.src = url;
   if (script.readyState){//IE 
      script.onreadystatechange = function(){ 
         if (script.readyState ==  "loaded" || script.readyState == "complete"){ 
            script.onreadystatechange = null;
            eval(callback + '()');
         } 
      }; 
   } else { //Others: Firefox, Safari, Chrome, and Opera 
      script.onload = function(){ 
         eval(callback + '()');
      }; 
   }
   document.body.appendChild(script);
}
</script>
<style>
  .facebook-card .card-header {
    display: block;
    padding: 10px;
	height:220px;
  }
  .facebook-card .facebook-avatar {
    float: left;
  }
  .facebook-card .facebook-name {
    margin-left: 44px;
	padding-top:60px;
    font-size: 30px;
    font-weight: 500;
  }
  .facebook-card .facebook-date {
    margin-left: 44px;
    font-size: 30px;
    color: #8e8e93;
  }
  .facebook-card .card-footer {
    background: #fafafa;
  }
  .facebook-card .card-footer a {
    color: #81848b;
    font-weight: 500;
  }
  .facebook-card .card-content{
    display: block;
    padding: 0px;
    margin:0px;
	height:220px;
  }
  .facebook-card .card-content-inner {
    padding: 15px 10px;
  }  
</style>
  </head>
  <body>
    <!-- Status bar overlay for full screen mode (PhoneGap) -->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>
    <!-- Left panel with reveal effect-->
    <div class="panel panel-left panel-reveal">
      <div class="content-block">
        <p>Left panel content goes here</p>
      </div>
    </div>
    <!-- Views -->
    <div class="views">
      <!-- Your main view, should have "view-main" class -->
      <div class="view view-main">
        <!-- Top Navbar-->
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left">
              <!-- 
                Right link contains only icon - additional "icon-only" class
                Additional "open-panel" class tells app to open panel when we click on this link
              -->
              <a href="index.php" class="link icon-only open-panel"><i class="icon icon-back"></i>返回</a>
            </div>              
            <!-- We need cool sliding animation on title element, so we have additional "sliding" class -->
            <div class="center sliding">烟雾值</div>
            <div class="right">
              <!-- 
                Right link contains only icon - additional "icon-only" class
                Additional "open-panel" class tells app to open panel when we click on this link
              -->
              <a href="#" class="link icon-only open-panel"><i class="icon icon-bars-blue"></i></a>
            </div>
          </div>
        </div>
        <!-- Pages container, because we use fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through">
          <!-- Page, "data-page" contains page name -->
          <div data-page="index" class="page">
            <!-- Scrollable page content -->
            <div class="page-content">
              <div class="card facebook-card">
			  <div class="card-header">
				<div class="facebook-avatar" id="main" style="height:200px; width:100%;"></div>
			  </div>
			  <div class="card-content">
				<div class="card-content-inner" id="main2" style="height:200px; width:100%;">
				  
				</div>
			  </div>
			  <div class="card-footer">
				数据更新时间：<?php 
					mysql_query ( "SET NAMES 'UTF8'" );
                    mysql_select_db ( $mysql_database, $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
			   if(strlen($row['data'])==8)
			   {
			   $time = $row['time'];
			   }
			 }
			echo $time;
			?> 
			  </div>
			</div>  
            </div>
          </div>
        </div>
        <!-- Bottom Toolbar-->

      </div>
    </div>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="js/framework7.min.js"></script>
    <!-- Path to your app js-->
    <script type="text/javascript" src="js/my-app.js"></script>
  </body>
</html>
<script>
<!--图表入口-->
 var myChart = echarts.init(document.getElementById('main'));
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
            center : ['50%', 210],    // 默认全局居中
            radius : 180,
            min:0,
            max:1000,
            startAngle:150,
            endAngle:30,
            splitNumber:2,
            axisLine: {            // 坐标轴线
                lineStyle: {       // 属性lineStyle控制线条样式
                    color: [[0.5, 'green'],[0.7, 'orange'],[1, 'red']],
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
                        case '500' : return 'N';
                        case '1000' : return 'H';
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
            data:[{value: <?php 
					mysql_query ( "SET NAMES 'UTF8'" );
                    mysql_select_db ( $mysql_database, $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
			   if(strlen($row['data'])==8)
			   {
			   $temp = substr($row['data'],3);
			   }
			 }
			echo $temp;
			?>, name: 'N2O'}]
        }
    ]
};
          
 // 为echarts对象加载数据 
        myChart.setOption(option);      
		
		


var myChart2 = echarts.init(document.getElementById('main2'));		
		option2 = {
    tooltip : {
        trigger: 'axis'
    },
    toolbox: {
        show : true,
        feature : {           
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    grid:{
        x:30,
        y:30,
        x2:40,
        y2:30,            
    },            
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : <?php 

			echo "[";
					mysql_query ( "SET NAMES 'UTF8'" );
                    mysql_select_db ( $mysql_database, $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
			   if(strlen($row['data'])==8)
			   {
			   echo "'";
			   echo substr($row['time'],5,5);
			   echo "'";
			   echo ",";
			   }
			 }
			echo "]";
			?>
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value} '
            }
        }
    ],
    series : [
        {
            name:'烟雾值',
            type:'line',
            data:<?php 
			echo "[";
					mysql_query ( "SET NAMES 'UTF8'" );
                    mysql_select_db ( $mysql_database, $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
			   if(strlen($row['data'])==8)
			   {
			   echo substr($row['data'],3);
			   echo ",";
			   }
			 }
			echo "]";
			?>,
            markPoint : {
                data : [
                    {type : 'max', name: '最大值'},
                    {type : 'min', name: '最小值'}
                ]
            },

            markLine : {
                data : [
                    {type : 'average', name: '平均值'}
                ]
            },
        }
    ]
};
                   
    // 为echarts对象加载数据 
        myChart2.setOption(option2);                               
</script>


<?php 
	mysql_close ( $con );
?>