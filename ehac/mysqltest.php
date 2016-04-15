 <?php

    include 'include/conn.php';
                    $sql = "SELECT * FROM device WHERE openid='o_x4Lj0NzaEevvqdSl5vypXE3BvY'";
                    $sql1 = "SELECT * FROM api_work WHERE sid=".$sid." AND nid = ".$nid."";
                    $con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
                        if (! $con) {
                            die ( 'Could not connect: ' . mysql_error () );
                        }
                        mysql_query ( "SET NAMES 'UTF8'" );
                        mysql_select_db ( $mysql_database, $con );
                        $result = mysql_query ( $sql );
                        while($row = mysql_fetch_array($result))
                        { 
                       GetDevice($row['sid'],$row['nid'],$row['devicename'],$row['devicepic']);


                        }

function GetDevice($sid,$nid,$devicename,$devicepic){

     $sql = "SELECT * FROM api_work WHERE sid=".$sid." AND nid = ".$nid."";
                              $result = mysql_query ( $sql );             
 while($row = mysql_fetch_array($result)){
                         
							$data = $row1['data'];

                        }
echo $data;
    echo "<br/>";
}
?>