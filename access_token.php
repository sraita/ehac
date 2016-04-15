<?php
//access_token更新
$appid = "wx5ca4836ebbda7287";
$appsecret = "afd33592eb230c2f8f9936881b2383ba";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$jsoninfo = json_decode($output, true);
$access_token = $jsoninfo["access_token"];
//将access_token存入Memcache
$mmc=memcache_init();
echo $access_token;
if($mmc==false)
    echo "mc init failed\n";
else
{
    memcache_set($mmc,"access_token",$access_token);
    echo memcache_get($mmc,"access_token");
}
?>