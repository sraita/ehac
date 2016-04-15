<?php

$access_token = "2.00yoq1vBJW9sPCf4ca32826fgdsvYC";

$jsonmenu = '

{
    
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
               "type":"click",
               "name":"室内环境",
               "key":"室内环境"
            },
            
            {
                "type":"click",
                "name":"电量",
                "key":"电量查询"
            },
            {
               "type":"view",
               "name":"我的设备",
               "url":"http://1.ehac.sinaapp.com/device.php"
            }
            ]
       

       },
       {    "type":"view",
            "name":"使用帮助",
            "url":"http://1.ehac.sinaapp.com/help.html"
       }]
 }';



$url = "https://m.api.weibo.com/2/messages/menu/create.json?access_token=".$access_token;
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