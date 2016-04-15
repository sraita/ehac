<?php
//通知条件判断&自动调节判断程序
//从memcache获取access_token
$mmc=memcache_init();
if($mmc==false)
    echo "mc init failed\n";
else
{
$access_token = memcache_get($mmc,"access_token");
}

//邮件发送类
function send_mail_lazypeople($to, $subject = 'Your register infomation', $body) {
     $loc_host = "SAE";         
     $smtp_acc = "weitas@qq.com";
     $smtp_pass="GFB7219621215";       
     $smtp_host="smtp.qq.com";   
     $from="weitas@qq.com";     
     $headers = "Content-Type: text/plain; charset=\"utf-8\"\r\nContent-Transfer-Encoding: base64";
     $lb="\r\n";             //linebreak
         
     $hdr = explode($lb,$headers);   
    if($body) {$bdy = preg_replace("/^\./","..",explode($lb,$body));}//??????Body

     $smtp = array(
           array("EHLO ".$loc_host.$lb,"220,250","HELO error: "),
           array("AUTH LOGIN".$lb,"334","AUTH error:"),
           array(base64_encode($smtp_acc).$lb,"334","AUTHENTIFICATION error : "),
           array(base64_encode($smtp_pass).$lb,"235","AUTHENTIFICATION error : "));
     $smtp[] = array("MAIL FROM: <".$from.">".$lb,"250","MAIL FROM error: ");
     $smtp[] = array("RCPT TO: <".$to.">".$lb,"250","RCPT TO error: ");
     $smtp[] = array("DATA".$lb,"354","DATA error: ");
     $smtp[] = array("From: ".$from.$lb,"","");
     $smtp[] = array("To: ".$to.$lb,"","");
     $smtp[] = array("Subject: ".$subject.$lb,"","");
     foreach($hdr as $h) {$smtp[] = array($h.$lb,"","");}
     $smtp[] = array($lb,"","");
     if($bdy) {foreach($bdy as $b) {$smtp[] = array(base64_encode($b.$lb).$lb,"","");}}
     $smtp[] = array(".".$lb,"250","DATA(end)error: ");
     $smtp[] = array("QUIT".$lb,"221","QUIT error: ");
     $fp = @fsockopen($smtp_host, 25);
     if (!$fp) echo "Error: Cannot conect to ".$smtp_host."
 ";
     while($result = @fgets($fp, 1024)){if(substr($result,3,1) == " ") { break; }}
     
     $result_str="";
     foreach($smtp as $req){
           @fputs($fp, $req[0]);
           if($req[1]){
                 while($result = @fgets($fp, 1024)){
                     if(substr($result,3,1) == " ") { break; }
                 };
                 if (!strstr($req[1],substr($result,0,3))){
                     $result_str.=$req[2].$result."
 ";
                 }
           }
     }
     @fclose($fp);
     return $result_str;
}

//数据库连接
$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
mysql_select_db("app_ehac", $con);//修改数据库名
$sql = mysql_query("SELECT device.data, device.sid, device.nid, device.devicename, device.id, device.status,
						ehac_user.openid, ehac_user.nickname, ehac_user.email, ehac_user.temp_l, ehac_user.temp_h, ehac_user.humidity_l, ehac_user.humidity_h, ehac_user.alarm
                        FROM device LEFT JOIN ehac_user ON device.openid = ehac_user.openid ;");
while($arr = mysql_fetch_array($sql))
{		//湿度低于
        if($arr['sid']=1&&$arr['data']!=null && $arr['humidity_l']>substr($arr['data'],0,2))
        {	
            $humidity = substr($arr['data'],0,2);
            //$sql=mysql_query("UPDATE device SET status=1 WHERE openid=".$arr['openid'].";");
            //邮件通知
            $message = "您好".$arr['nickname']."！湿度低于设定值(".$arr['humidity_l']."%),开启自动调节,当前湿度为".$humidity."%";
            send_mail_lazypeople($arr['email'],'自动调节通知',$message);//测试
            //模板消息—自动调节通知
            $template_humidity_l = '{
                "touser": "'.$arr['openid'].'", 
                "template_id": "6nllHSTSz9s0Xd3O5pAhtVbaXGSllrd60pRRTSVh0Cc", 
                "url": "http://weixin.qq.com/download", 
                "topcolor": "#DC143C", 
                "data": {
                    "first": {
                        "value": "您好'.$arr['nickname'].'！湿度低于设定值('.$arr['humidity_l'].'%),开启自动调节", 
                        "color": "#173177"
                    }, 
                    "device": {
                        "value": "'.$arr['devicename'].'", 
                        "color": "#FFFF00"
                    }, 
                    "status": {
                        "value": "当前湿度为'.$humidity.'%", 
                        "color": "#F0E68C"
                    },  
                    "remark": {
                        "value": "智能家居云端：http://ehac.sinaapp.com", 
                        "color": "#800080"
                    }
                }
            }';
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;   
            $result = https_request($url, $template_humidity_l);
            var_dump($result);
             
        }
    //湿度高于
        if($arr['sid']=1&&$arr['data']!=null && $arr['humidity_h']<substr($arr['data'],0,2))
        {
            $humidity = substr($arr['data'],0,2);
            //$sql=mysql_query("UPDATE device SET status="0" WHERE openid=".$arr['openid'].";");
            //邮件通知
            $message = "您好".$arr['nickname']."！湿度高于设定值(".$arr['humidity_h']."%),开启自动调节,将关闭".$arr['devicename'].",,当前湿度为".$arr['humidity']."%";
            send_mail_lazypeople($arr['email'],'自动调节通知',$message);//测试
            //模板消息-自动调节通知
            $template_humidity_h = '{
                "touser": "'.$arr['openid'].'", 
                "template_id": "6nllHSTSz9s0Xd3O5pAhtVbaXGSllrd60pRRTSVh0Cc", 
                "url": "http://weixin.qq.com/download", 
                "topcolor": "#DC143C", 
                "data": {
                    "first": {
                        "value": "您好'.$arr['nickname'].'！湿度高于设定值('.$arr['humidity_h'].'%),开启自动调节,将关闭'.$arr['devicename'].'", 
                        "color": "#173177"
                    }, 
                    "device": {
                        "value": "'.$arr['devicename'].'",  
                        "color": "#FFFF00"
                    }, 
                    "status": {
                        "value": "当前湿度为'.$humidity.'%", 
                        "color": "#F0E68C"
                    }, 
                    "remark": {
                        "value": "智能家居云端：http://ehac.sinaapp.com", 
                        "color": "#800080"
                    }
                }
            }';
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;   
            $result = https_request($url, $template_humidity_h);
            var_dump($result);
        }
    //温度低于
    	if($arr['sid']=1&&$arr['data']!=null && $arr['humidity_l']>substr($arr['data'],3))
        {
            $temp = substr($arr['data'],3);
            //$sql=mysql_query("UPDATE device SET status="1" WHERE openid=".$arr['openid'].";");
            //邮件通知
            $message = "您好".$arr['nickname']."！温度低于设定值(".$arr['temp_l']."℃),开启自动调节,当前温度为".$temp."℃";
            send_mail_lazypeople($arr['email'],'自动调节通知',$message);//测试
            //模板消息-自动调节通知
            $template_temp_l = '{
                "touser": "'.$arr['openid'].'", 
                "template_id": "6nllHSTSz9s0Xd3O5pAhtVbaXGSllrd60pRRTSVh0Cc", 
                "url": "http://weixin.qq.com/download", 
                "topcolor": "#DC143C", 
                "data": {
                    "first": {
                        "value": "您好'.$arr['nickname'].'！温度低于设定值('.$arr['temp_l'].'℃),开启自动调节", 
                        "color": "#173177"
                    }, 
                    "device": {
                        "value": "'.$arr['devicename'].'",
                        "color": "#FFFF00"
                    }, 
                    "status": {
                        "value": "当前温度为'.$temp.'℃", 
                        "color": "#F0E68C"
                    }, 
                    "remark": {
                        "value": "智能家居云端：http://ehac.sinaapp.com", 
                        "color": "#800080"
                    }
                }
            }';
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;   
            $result = https_request($url, $template_temp_l);
            var_dump($result);
        }
    //温度高于
    	if($arr['sid']=1&&$arr['data']!=null && $arr['temp_h']<substr($arr['data'],3))
        {
            $temp = substr($arr['data'],3);
            //$sql=mysql_query("UPDATE device SET status="1" WHERE openid=".$arr['openid'].";");
            //邮件通知
            $message = "您好".$arr['nickname']."！温度高于设定值(".$arr['temp_h']."℃),开启自动调节,当前温度为".$temp."℃";
            send_mail_lazypeople($arr['email'],'自动调节通知',$message);//测试
            //模板消息-自动调节通知
            $template_temp_h = '{
                "touser": "'.$arr['openid'].'", 
                "template_id": "6nllHSTSz9s0Xd3O5pAhtVbaXGSllrd60pRRTSVh0Cc", 
                "url": "http://weixin.qq.com/download", 
                "topcolor": "#DC143C", 
                "data": {
                    "first": {
                        "value": "您好'.$arr['nickname'].'！温度高于设定值('.$arr['temp_h'].'℃),开启自动调节", 
                        "color": "#173177"
                    }, 
                    "device": {
                        "value": "'.$arr['devicename'].'",
                        "color": "#FFFF00"
                    }, 
                    "status": {
                        "value": "当前温度为'.$temp.'℃", 
                        "color": "#F0E68C"
                    }, 
                    "remark": {
                        "value": "智能家居云端：http://ehac.sinaapp.com", 
                        "color": "#800080"
                    }
                }
            }';
			$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;   
            $result = https_request($url, $template_temp_h);
            var_dump($result);
        }
    //烟雾预警值超限
        if($arr['sid']=2&&$arr['data']!=null && $arr['alarm']<$arr['data'])
        {	
            //邮件通知
            $message = "您好".$arr['nickname']."！烟雾预警值超限(".$arr['alarm']."PPM),请及时查看,当前烟雾值：".$arr['data']."";
            send_mail_lazypeople($arr['email'],'烟雾预警通知',$message);//测试
            //模板消息-烟雾预警通知
        	$template_alarm = '{
            "touser": "'.$arr['openid'].'", 
            "template_id": "wIlMvoQwB73FkE25RHBIyTzDhvvUZ5XakkYXM1rmhTQ", 
            "url": "http://weixin.qq.com/download", 
            "topcolor": "#DC143C", 
            "data": {
                "first": {
                    "value": "您好,'.$arr['nickname'].',温度超出设定范围,开启自动调节,当前烟雾值：'.$arr['data'].'", 
                    "color": "#173177"
                },   
                "remark": {
                    "value": "具体请查看：http://ehac.sinaapp.com", 
                    "color": "#800080"
                }
            }
        }';
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;   
        $result = https_request($url, $template_alarm);
        var_dump($result);
        }
    //室内环境异常
        if($arr['sid']=4&& $arr['status']=1)
        {	
            //邮件通知
            $message = "您好".$arr['nickname']."！室内环境异常，请及时查看！";
            send_mail_lazypeople($arr['email'],'烟雾预警通知',$message);//测试
            //模板消息-烟雾预警通知
        	$template_alarm = '{
            "touser": "'.$arr['openid'].'", 
            "template_id": "R35mJZoFONyXBoupIF_PmqrzN9bw80ujDwgN5LXywmo", 
            "url": "http://weixin.qq.com/download", 
            "topcolor": "#DC143C", 
            "data": {
                "first": {
                    "value": "您好,'.$arr['nickname'].'！，室内环境异常，请及时查看！", 
                    "color": "#173177"
                },   
                "remark": {
                    "value": "具体请查看：http://ehac.sinaapp.com", 
                    "color": "#800080"
                }
            }
        }';
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;   
        $result = https_request($url, $template_alarm);
        var_dump($result);
        }
}
mysql_close($con);	
//模板通知处理
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
