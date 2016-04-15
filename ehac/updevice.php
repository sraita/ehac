
<!-- Navbar -->
<div class="navbar">
 <!-- Home page navbar -->
 <div class="navbar-inner" data-page="updevice">
  <div class="left"><a href="#" class="back link"> <i class="icon icon-back"> </i><span>取消</span></a></div>
  <div class="center">设备信息</div>
 </div>
</div>
<!-- Pages -->
<div class="pages  navbar-through">
 <!-- Home page -->
 <div class="page" data-page="updevice">
  <div class="page-content pull-to-refresh-content">
  <?php
                    include 'include/conn.php';
                    $mysql_table = "device";
                    $mysql_state = "SELECT * FROM " . $mysql_table . " WHERE id =".$_GET['deviceid']."";
                    $con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
                        if (! $con) {
                            die ( 'Could not connect: ' . mysql_error () );
                        }
                        mysql_query ( "SET NAMES 'UTF8'" );
                        mysql_select_db ( $mysql_database, $con );
                        $result = mysql_query ( $mysql_state );
                        $row = mysql_fetch_array($result);
                         ?>
				<div class="list-block">
				<form action="./php/update.php?action=deviceinfo" method="POST" class="ajax-submit">
				<ul>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">设备名称</div>
                        <div class="item-input">
                          <input type="text" name="devicename" value="<?php echo $row['devicename'];?>">
						  <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                        </div>
                      </div>
                    </div>
                  </li>
				  <div class="content-block-title">定时任务</div>
				  <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">设备状态</div>
							<div class="item-input" align="right">
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
                            <select>
                                <option>5分钟后</option>
                                <option>10分钟后</option>
								<option>15分钟后</option>
								<option>20分钟后</option>
								<option>25分钟后</option>
								<option>30分钟后</option>
								<option>35分钟后</option>
								<option>40分钟后</option>
								<option>45分钟后</option>
								<option>50分钟后</option>
								<option>55分钟后</option>
								<option>1小时后</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    </li>
                </ul>
				<div class="content-block"><input type="submit" class="button button-saveupdevice" value="保存"/></div>
				</form>
              </div>
  </div>
 </div>
</div>

