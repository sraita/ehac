<?php
include '../include/conn.php';
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
    {  $array = array("nickname" => $row['nickname'],"openid" =>$row['openid'],"sex" =>$row['sex'],"email" =>$row['email']);
        echo json_encode($array);
        $a = $row['nickname'];
 	}
	mysql_close ( $con );
  echo $a;
?>
