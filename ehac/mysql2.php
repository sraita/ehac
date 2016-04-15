<?php
include 'include/conn.php';
$mysql_table = "api_worklist";
$mysql_state = "SELECT * FROM " . $mysql_table . " ";
	
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
					   if($row['sid']==1&&strlen($row['data'])==8)
					   {
					   $humidity = $row['data'];
					   }
					   if($row['sid']==2)
					   {
					   $smoke = $row['data'];
					   } 
                       if($row['sid']==4strlen($row['data'])==1)
                       {
                       $renti = $row['data'];
                       }
					 }
					echo $humidity;
					echo $smoke;
					echo $renti;
mysql_query("UPDATE device SET data = '".$humidity."' WHERE sid='001'");
mysql_query("UPDATE device SET data = '".$smoke."' WHERE sid='002'");
mysql_query("UPDATE device SET data = '".$renti."' WHERE sid='004'");
mysql_close ( $con );
?>