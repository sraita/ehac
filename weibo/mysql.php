<?php

include '../ehac/include/conn.php';
$mysql_table = "api_worklist";
$mysql_state = "SELECT * FROM " . $mysql_table . " ";
	
$con = mysql_connect ( $mysql_host . ':' . $mysql_port, $mysql_user, $mysql_password, true );
                    if (!$con)
                      {
                      die('Could not connect: ' . mysql_error());
                      }
                    
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
                    mysql_close($con);
?>