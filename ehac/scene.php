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
    $total = mysql_num_rows($result);
    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
    {        
        $nickname = $row['nickname'];
        $name = $row['name'];
		$email = $row['email'];
		$alarm = $row['alarm'];
		$sex=$row['sex'];
 	}
	$update_useer = "SELECT * FROM " . $mysql_table . " WHERE openid ='o_x4Lj0NzaEevvqdSl5vypXE3BvY' ";
	mysql_close ( $con );
	echo $nickname;
?>
<!-- Navbar -->
<div class="navbar">
 <!-- Home page navbar -->
 <div class="navbar-inner" data-page="scene">
      <div class="left">
        <!-- Right link contains only icon - additional "icon-only" class-->
        <a href="#" class="link icon-only open-panel"><i class="icon icon-bars color-white"></i></a>
      </div>
      <div class="center">情景模式</div>
      <div class="right">
        <a href="#" class="link icon-only open-popup"><i class="icon icon-plus">+</i></a>
      </div>
 </div>
</div>
<!-- Pages -->
<div class="pages navbar-through">
 <!-- Home page -->
 <div class="page" data-page="scene">
  <div class="page-content">
    <!--离开模式-->
    <div class="card demo-card-header-pic">
    <a href="scene/leave_mode.html" class="link item-link">
      <div style="background-image:url(img/leave_mode.jpg);  background-size:cover;   height:160px;" valign="bottom" class="card-header color-pink no-border">离开模式<i class="icon iconinfo">&#xe61f;</i></div></a>
    </div>
    <!--回家模式-->
    <div class="card demo-card-header-pic">
    <a href="scene/home_mode.html" class="link item-link">
      <div style="background-image:url(img/home_mode.jpg); background-size:cover;  height:160px;" valign="bottom" class="card-header color-orange no-border">回家模式<i class="icon iconinfo">&#xe619;</i></div></a>
    </div>
    <!--起床模式-->
    <div class="card demo-card-header-pic">
     <a href="scene/rise_mode.html" class="link item-link">
      <div style="background-image:url(img/starting_mode.jpg); background-size:cover;   height:160px;" valign="bottom" class="card-header color-blue no-border">起床模式<i class="icon iconinfo">&#xe609;</i></div></a>
    </div>
    <!--end-->
  </div>
 </div>
</div>

