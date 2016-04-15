<?php
if (isset($_COOKIE["userid"]))
$openid = $_COOKIE["userid"];
session_start();
$uid=  $_SESSION['token']['uid'];
include 'include/conn.php';
$mysql_table = "ehac_user";
$mysql_state = "SELECT * FROM " . $mysql_table . " WHERE openid ='".$openid."' OR uid ='".$uid."' ";
	
$con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
	if (! $con) {
		die ( 'Could not connect: ' . mysql_error () );
	}
	mysql_query ( "SET NAMES 'UTF8'" );
	mysql_select_db ( $mysql_database, $con );
	$result = mysql_query ( $mysql_state );
    $total = mysql_num_rows($result);
    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
    {        
        $nickname = $row['nickname'];
        $name = $row['name'];
		$email = $row['email'];
		$alarm = $row['alarm'];
		$sex=$row['sex'];
      
 	}
	$update_useer = "SELECT * FROM " . $mysql_table . " WHERE openid ='".$openid."' OR uid ='".$uid."' ";
	mysql_close ( $con );
	echo $nickname;
?>
    <!-- Navbar -->
        <div class="navbar">
          <!-- Home page navbar -->
         <div class="navbar-inner" data-page="leave_mode">
             <div class="left">
                <!-- Right link contains only icon - additional "icon-only" class-->
                <a href="#" class="link icon-only open-panel"><i class="icon icon-bars"></i></a>
              </div>
              <div class="center">个人中心</div>
              <div class="right">
                <a href="#" class="link icon-only open-popup"><i class="icon icon-plus">+</i></a>
              </div>
         </div>
      </div>
        <!-- Pages -->
        <div class="pages navbar-through">
          <div class="page" data-page="userinfo">
            <div class="page-content">
              <div class="list-block" >
                <ul>
                    <form action="./php/update.php?action=update" id="userinfo" method="POST" class="ajax-submit-onchange">  
                  <li class="item-divider">基本信息</li>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">昵称</div>
                        <div class="item-content">
                          <input type="text"  readonly name="weixin" value="<?php  echo $nickname; ?>">
                        </div>
                      </div>
                    </div>
                  </li>
                    <!-- Select -->
                    <li>
                    <div class="item-content">
                        <div class="item-inner">
                            <div class="item-title label">性别</div>
                            <div class="item-input">
                            <select name="sex">
                                <option	 value="1" <?php if($sex== "1")echo "selected=\"selected\"";?>>男</option>
                                <option	value="0" <?php if($sex== "0")echo "selected=\"selected\"";?>>女</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    </li>
                    <li>
                    <div class="item-content" >
                        <div class="item-inner">
                        <div class="item-title label">Email </div>
                            <div class="item-input">
           						 <input type="email" name="email" value="<?php  echo $email; ?>">
         					 </div>
                        </div>
                    </div>
                    </li>
                    <li class="item-divider">自动调节设置</li>
                    <li>
                        <a href="automate.php">
                    <div class="item-content" >
                        <div class="item-inner">
                        <div class="item-title label">自动调节</div>
                        </div>
                    </div>
                    </a>
                    </li>
                    <li class="item-divider">设置气体预警值</li>
                    <li>
                        <a href="#" class=" smart-select" data-page-title="预警值" data-back-text="返回" data-back-on-select="true">
                        <select name="alarm" >
                          <option value="100" data-option-color="green"<?php if($alarm  == "100")echo "selected=\"selected\"";?>>100</option>
                          <option value="200" data-option-color="green"<?php if($alarm  == "300")echo "selected=\"selected\"";?>>200</option>
                          <option value="300" data-option-color="green"<?php if($alarm  == "300")echo "selected=\"selected\"";?>>300</option>
                          <option value="400" data-option-color="orange"<?php if($alarm  == "400")echo "selected=\"selected\"";?>>400</option>
                          <option value="500" data-option-color="orange"<?php if($alarm  == "500")echo "selected=\"selected\"";?>>500</option>
                          <option value="600" data-option-color="orange"<?php if($alarm  == "600")echo "selected=\"selected\"";?>>600</option>
                          <option value="700" data-option-color="pink" <?php if($alarm == "700")echo "selected=\"selected\"";?>>700</option>
                          <option value="800" data-option-color="pink"<?php if($alarm  == "800")echo "selected=\"selected\"";?>>800</option>
                          <option value="900" data-option-color="pink"<?php if($alarm  == "900")echo "selected=\"selected\"";?>>900</option>
                          <option value="1000" data-option-color="pink"<?php if($alarm  == "1000")echo "selected=\"selected\"";?>>1000</option>
                        </select>
                        <div class="item-content">
                          <div class="item-inner">
                            <div class="item-title">烟雾火警</div>
                          </div>
                        </div>
                        </a>
                    </li>
                    </form>
                </ul>
              </div>
            </div>
          </div>
        </div>
