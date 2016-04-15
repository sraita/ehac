
<div class="navbar ">
  <div class="navbar-inner">
    <div class="left"><a href="#" class="back link"> <i class="icon icon-back"> </i><span>返回</span></a></div>
    <div class="center sliding">回家模式</div>
  </div>
</div>
<div class="pages ">
  <div data-page="leave_mode" class="page leave_mode">
    <div class="page-content">
      <div class="content-block-title">用于回家模式的设备</div>
      <div class="list-block">
                <ul>
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
                         if($row['type']==1) {
                             $device_id = $row['id'];
                             $devicepic = $row['devicepic'];
							 $devicename = $row['devicename'];
							 $status = $row['status'];
							 $devicescene = $row['devicescene'];
                            echo '<li>
                    <label class="label-checkbox item-content ">
                      <input type="checkbox" name="checkbox[]" value="';
							echo $device_id;
							echo '" ';
							if ($devicescene == "2"){
							echo 'checked';}
							echo '>
                      <div class="item-media "><i class="icon icon-form-checkbox"></i></div>
                      <div class="item-inner">
                        <div class=" item-media">';
							echo $devicename;
							echo '</div>
                        <div class="item-input" align="right">
                          <label class="label-switch">
                            <input type="checkbox"';
							if ($status == "1" &&$devicescene == "2"){
							echo 'checked';}
							echo '>
                            <div class="checkbox"></div>
                          </label>
                        </div>
                      </div>
                    </label>
                  </li>';
							}
						}
						 mysql_close ( $con );
				?>
                </ul>
              </div>
    </div>
  </div>
</div>