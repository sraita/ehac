<?php
$devicename = $_POST['devicename'];
$sid = $_POST['sid'];
$nid = $_POST['nid'];
$scene_id = 001;
//从memcache获取access_token
$mmc=memcache_init();
if($mmc==false)
    echo "mc init failed\n";
else
{
$access_token = memcache_get($mmc,"access_token");
}
//创建二维码ticket
//$access_token = " xDx0pD_ZvXkHM3oeu5oGjDt1_9HxlA-9g0vtR6MZ-v4r7MpvZYC4ee4OxN97Lr4irkPKE94tzBUhpZG_OvqAC3D3XaWJIGIn0eeIZnfaofO1C3LNzGphd_rEv3pIimsW9lO-4FOw6D44T3sNsQ5yXQ";

//临时
//$qrcode = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 10000}}}';
//永久
$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';

$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
$result = https_request($url,$qrcode);
$jsoninfo = json_decode($result, true);
$ticket = $jsoninfo["ticket"];

function https_request($url, $data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}


//$ticket = "gQHi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0UweTNxNi1sdlA3RklyRnNKbUFvAAIELdnUUgMEAAAAAA==";

$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
echo "<script>";
echo "location.href='$url'"; 
echo "</script>"; 
?>