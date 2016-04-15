<?php

$access_token = "EV9kw3XwioTSIDyK3je_0afnJtlnTeL56eyR_xGT3zIZoXKr0S1velaX_jL64IL3eMawDyDh_em9gw91Fg5IN2mhBDcGfslqBlQwdHVaotw";

$jsonmenu = '{
      "button":[
      {
            "name":"情景模式",
           "sub_button":[
            {
               "type":"click",
               "name":"离开模式",
               "key":"离开模式"
            },
            {
               "type":"click",
               "name":"回家模式",
               "key":"回家模式"
            },
            {
               "type":"click",
               "name":"起床模式",
               "key":"起床模式"
            },
            {
                "type":"view",
                "name":"情景设置",
                "url":"http://1.ehac.sinaapp.com/help.html"
            }]
      

       },
       {
           "name":"我的设备",
           "sub_button":[
            {
               "type":"view",
               "name":"延时开关",
               "url":"http://1.ehac.sinaapp.com/help.html"
            },
            
            {
                "type":"click",
                "name":"电量",
                "key":"电量查询"
            },
            {
               "type":"view",
               "name":"我的设备",
               "url":"http://1.ehac.sinaapp.com/help.html"
            }
            ,
            {
               "type":"click",
               "name":"基本信息",
               "key":"userlist"
            }]
       

       },
       {    "type":"view",
            "name":"使用帮助",
            "url":"http://1.ehac.sinaapp.com/help.html"
       }]
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