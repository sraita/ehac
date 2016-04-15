<?php
//从memcache获取access_token$mmc=memcache_init();
$mmc=memcache_init();
if($mmc==false)
    echo "mc init failed\n";
else
{
$access_token = memcache_get($mmc,"access_token");
}
//创建自定义菜单
$jsonmenu = '{
      "button":[
      {
            "name":"家居云端",
           "sub_button":[
            {
               "type":"click",
               "name":"用户中心",
               "key":"用户中心"
            },
            {
               "type":"scancode_waitmsg",
               "name":"添加设备",
               "key": "rselfmenu_0_1", 
               "sub_button": [ ]

            },
            {
                "type":"view",
                "name":"设备管理",
                "url":"http://ehac.sinaapp.com/ehac"
            }]
      

       },
       {
           "name":"环境查看",
           "sub_button":[
            {
               "type":"click",
               "name":"查看气体信息",
               "key":"查看气体信息"
            },
            
            {
                "type":"click",
                "name":"查看湿度",
                "key":"查看湿度"
            },
            {
               "type":"click",
               "name":"查看温度",
               "key":"查看温度"
            }
            ,
            {
               "type":"click",
               "name":"查看室内环境",
               "key":"查看室内环境"
            }]
       

       },
       {
           "name":"关于我们",
           "sub_button":[
            {
               "type":"click",
               "name":"团队介绍",
               "key":"团队介绍"
            },
            
            {
                "type":"click",
                "name":"系统简介",
                "key":"系统简介"
            },
            {
               "type":"click",
               "name":"使用帮助",
               "key":"使用帮助"
            }
            ,
            {
               "type":"click",
               "name":"在线客服",
               "key":"在线客服"
            }]
       

       },
 }';


$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
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

?>