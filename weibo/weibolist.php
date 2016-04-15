<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid2 = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息


$code = $_GET["code"];
$token =$_GET["access"];
$userinfo = getUserInfo($code);



function https_request($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
	curl_close($curl);
	return $data;
}
function getUserUid($code2)
{
    $token =  $_SESSION['token']['access_token'];
 $uid_url = "https://api.weibo.com/2/place/users/show.json?access_token=$token";
    $uid_json=https_request($uid_url);
    $uid_array = json_decode($uid_json, true);
    return $uid_array;
}
function getUserInfo($code)
{
//全局access token获得用户基本信息
    $code2 = $_GET["code2"];
    $uid = getUserUid($code2);
    $a = $uid["uid"];
    $userinfo_url = "https://api.weibo.com/2/users/show.json?access_token=2.00yoq1vBJW9sPCf4ca32826fgdsvYC&uid=$a";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);
	return $userinfo_array;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新浪微博V2接口演示程序-Powered by Sina App Engine</title>
    
</head>

<body>
    <div>
        <div><img src="<?php echo $userinfo["profile_image_url"];?>"/></div>
        <p>ID:<?php echo $userinfo["id"];?></p>
        <p>用户名:<?php echo $userinfo["screen_name"];?></p>
        <p>城市:<?php echo $userinfo["location"];?></p>
        <p>简介:<?php echo $userinfo["description"];?></p>
        
    </div>
	
</body>
</html>
