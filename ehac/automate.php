
<!-- Navbar -->
<div class="navbar">
 <!-- Home page navbar -->
 <div class="navbar-inner" data-page="automate">
  <div class="left"><a href="#" class="back link"> <i class="icon icon-back"> </i><span>返回</span></a></div>
  <div class="center">自动调节</div>
 </div>
</div>
<!-- Pages -->
<div class="pages  navbar-through">
 <!-- Home page -->
 <div class="page" data-page="automate">
  <div class="page-content">
  <form action="./php/update.php?action=automate"  method="POST" class="ajax-submit-onchange">  
      <div class="content-block-title">自动调节室内温度</div>
     <div class="list-block">
	   
  <ul>
        <!-- Select -->
   <li><a href="#" class="smart-select" data-back-on-select="true">
        <select name="temp_device">
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
                         if($row['data']==null&&$row['sid']==3) {
                             $device_id = $row['id'];
                             $devicepic = $row['devicepic'];
							 $devicename = $row['devicename'];
                            echo '<option value="';
							echo $device_id;
							echo '" data-option-image="img/device/';
							echo $devicepic;
							echo '.png">';
							echo $devicename;
							echo '</option>';
							}
						}
						 mysql_close ( $con );
				?>
        </select>
        <div class="item-content">
          <div class="item-inner">
            <div class="item-title">选择设备</div>
          </div>
        </div></a>
      </li>
		        <?php
                    include 'include/conn.php';
                    $mysql_table = "ehac_user";
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
      					     $temp_l = $row['temp_l'];
        				     $temp_h = $row['temp_h'];  
						}
						 mysql_close ( $con );
				?>      

          <!-- Text inputs -->
     <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">温度范围</div>
                        <div class="item-input">
                           <input type="text" name="temp" placeholder="<?php echo $temp_l;?>℃-<?php echo $temp_h;?>℃" readonly id="automate">

                        </div>
                      </div>
                    </div>
                  </li>
  </ul>
</div>
      <div class="content-block-title">自动调节室内湿度</div>
      <div class="list-block">
  <ul>
        <!-- Select -->
   <li><a href="#" class=" smart-select" data-back-on-select="true">
        <select name="humidity_device">
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
                         if($row['data']==null&&$row['sid']==3) {
                             $device_id = $row['id'];
                             $devicepic = $row['devicepic'];
							 $devicename = $row['devicename'];
                            echo '<option value="';
							echo $device_id;
							echo '" data-option-image="img/device/';
							echo $devicepic;
							echo '.png">';
							echo $devicename;
							echo '</option>';
							}
						}
						 mysql_close ( $con );
				?>
        </select>
        <div class="item-content">
          <div class="item-inner">
            <div class="item-title">选择设备</div>
          </div>
        </div></a>
      </li>
          <!-- Text inputs -->
      <li>
          <a href="#" class=" smart-select" data-page-title="室内湿度" data-back-text="返回" data-back-on-select="true">
             <select name="humidity_l" >
                          <option value="10" data-option-color="green">低于10%</option>
                          <option value="20" data-option-color="green">低于20%</option>
                          <option value="30" data-option-color="green">低于30%</option>
                          <option value="40" data-option-color="orange">低于40%</option>
                          <option value="50" data-option-color="orange">低于50%</option>
                          <option value="60" data-option-color="orange">低于60%</option>
                          <option value="70" data-option-color="pink" selected>低于70%</option>
                          <option value="80" data-option-color="pink">低于80%</option>
                          <option value="90" data-option-color="pink">低于90%</option>
                          <option value="100" data-option-color="pink">低于100%</option>
                        </select>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">打开设备</div>
                          </div>
                        </div>           
                        </a>
                    </li>
   <li>
          <a href="#" class="smart-select" data-page-title="室内湿度" data-back-text="返回" data-back-on-select="true">
             <select name="humidity_h" >
                          <option value="10" data-option-color="green">高于10%</option>
                          <option value="20" data-option-color="green">高于20%</option>
                          <option value="30" data-option-color="green">高于30%</option>
                          <option value="40" data-option-color="orange">高于40%</option>
                          <option value="50" data-option-color="orange">高于50%</option>
                          <option value="60" data-option-color="orange">高于60%</option>
                          <option value="70" data-option-color="pink" selected>高于70%</option>
                          <option value="80" data-option-color="pink">高于80%</option>
                          <option value="90" data-option-color="pink">高于90%</option>
                          <option value="100" data-option-color="pink">高于100%</option>
                        </select>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">关闭设备</div>
                          </div>
                        </div>           
                        </a>
                        
                    </li>
       
              </ul>
            </div>
         </form>
        </div>
     </div>
    </div>
     

