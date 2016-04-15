<?php
$str = '添加设备|001|003';
$result = explode('|', $str);
//echo $result[0];
$a = "15℃ - 25℃";
    $temp_l = substr($a,0,2);
    $temp_h = substr($a,8,2);
	$temp = "".$temp_l.""+"".$temp_h."";
echo $temp;
?>