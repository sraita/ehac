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
    <title>温湿度变化</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="css/framework7.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css/todo7.css">
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
	height:240px;
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
            <div class="center sliding">温湿度变化</div>
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
				<div class="facebook-avatar" id="main" style="height:200px; width:200px;"></div>
				<div class="facebook-name">
					<?php 
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
					?> ℃
				</div>
				<div class="facebook-date">
					<?php 
                    mysql_query ( "SET NAMES 'UTF8'" );
                    mysql_select_db ( $mysql_database, $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					   if(strlen($row['data'])==8)
					   {
					   $humidity = substr($row['data'],0,2);
					   }
					 }
					echo $humidity;
					?> %
				</div>
			  </div>
			  <div class="card-content" id="main2" style="height:200px; width:100%;">
				  
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
			?>, name: '温度'}]
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
            data:[{value: 
			<?php 
					mysql_query ( "SET NAMES 'UTF8'" );
                    mysql_select_db ( $mysql_database, $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
			   if(strlen($row['data'])==8)
			   {
			   $humidity = substr($row['data'],0,2);
			   }
			 }
			echo $humidity;
			?>, name: '湿度'}]
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
    legend: {
        data:['温度','湿度']
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
        x2:30,
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
			   echo substr($row['time'],10,6);
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
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'湿度',
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
			   echo "'";
			   echo substr($row['data'],0,2);
			   echo "'";
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
        },
        {
            name:'温度',
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
        }
    ]
};
                   
    // 为echarts对象加载数据 
        myChart2.setOption(option2);                               
</script>


<?php 
	mysql_close ( $con );
?>