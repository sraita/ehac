<?php

//错误日志
function echo_server_log($log){
	file_put_contents("log.txt", $log, FILE_APPEND);
}

define("TOKEN", "ehac");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE)
            {
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                case "location"://位置消息
                    $result = $this->receiveLocation($postObj);
                    break;
                case "text":
                case "voice":
                    $resultStr = $this->receiveText($postObj);
                    break;
               
            }
             $this->logger("T ".$result);
            echo $resultStr;
            echo $result;
        }else {
            echo "";
            exit;
        }
    }
    
    //获取用户信息
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
/*
     * 接收位置消息
     */
    private function receiveLocation($object)
    {    $access_token = "ANVOdsmN6IRWlFxIT4YvTMrAkolQmgKu1sf2e9JfkPiSOVHB_k9sZHMBNKgg-c9ETt0x0IO3XQHWeTdKWNv0gHu1mNA3J7cNiUxK0Zd1yHM";
            $openid = $object->FromUserName;
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
            $output = $this->https_request($url);
            $jsoninfo = json_decode($output, true);
        $content = "你发送的位置信息为：".$object->Label."\n你的位置信息将会用作温度报警，湿度和天气提醒等功能\n如果设备地理位置改变请再次发送地理位置信息";
        $str = "".$object->Label."";
        $str1 = mb_substr($str,3,2,'utf-8');//字符串截取&字符编码处理中文字符3开始位置2为长度
        $str2 = mb_substr($str,2,1,'utf-8');//字符串截取&字符编码处理中文字符3开始位置2为长度
        $str3 = '省';
        $str4 =  mb_substr($str,0,2,'utf-8');
        $str5 = '市';
        $result = $this->transmitText($object, $content);
        $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
            mysql_select_db("app_ehac", $con);//修改数据库名
        if($str5==$str2){
            $sql = "UPDATE ehac_user SET city = '".$str4."' WHERE openid = '$openid'";
        }else if(($str3==$str2)){
         $sql = "UPDATE ehac_user SET city = '".$str1."' WHERE openid = '$openid'";
        }
            if(!mysql_query($sql,$con)){
                die('Error:'.mysql_error());
            }
            else{
            mysql_close($con);
           
            }
        return $result;
    }
    /*
    *接受用户地理位置
    */
    
    
    private function receiveText($object)
    {
        
        
         if (!empty($object->Recognition)){
            $keyword = trim($object->Recognition);
            $mediaid = trim($object->MediaID);
        }else{
            $keyword = trim($object->Content);
        }
        
        switch ($keyword)
        {   case "天气":
            case "明天天气怎么样";
            include("weather.php");
            $content = getWeatherInfo($keyword);
            break;
            case "查看温度":
            case "温度":
		    $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
	        mysql_select_db("app_ehac", $con);//修改数据库名
	        $result = mysql_query("SELECT * FROM sensor");
	          while($arr = mysql_fetch_array($result)){
	          if ($arr['openid'] ==$object->FromUserName) {
	  	     $tempr = $arr['data'];
             $timr = $arr['timestamp'];
	         }
	         }
	        mysql_close($con);
                $content = "报告大王："."\n"."主人房间的室温为".$tempr."℃，\n数据获取时间".$timr.",\n感谢您对主人的关心";
                break;
			case "电量":
			    //回复文本消息
			$con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
	        mysql_select_db("app_ehac", $con);//修改数据库名
	        $result = mysql_query("SELECT * FROM electricity");
	          while($arr = mysql_fetch_array($result)){
	          if ($arr['openid'] ==$object->FromUserName) {
	  	     $tempr = $arr['data'];
             $timr = $arr['timestamp'];
             $money = 0.6;
             $money *= $tempr;
	         }
	         }
	        mysql_close($con);
		
            $content ="报告大王："."\n"."截止".$timr."用电总量为：".$tempr."KWh，电量计费为".$money."元";
			   break;
            case "开灯":
            case "打开电灯":
            //回复文本消息
            $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
            $dati = date("h:i:sa");
	        mysql_select_db("app_ehac", $con);//修改数据库名
            $sql = "UPDATE switch SET timestamp = '$dati',state = '1' WHERE ID = '1'";
            if(!mysql_query($sql,$con)){
                die('Error:'.mysql_error());
            }
            else{
            mysql_close($con);
            $content ="报告大王："."\n". "电灯已经打开";
            }
               break;
            case "关灯":
            case "关闭电灯":
        //回复文本消息
            $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
	$dati = date("h:i:sa");
	mysql_select_db("app_ehac", $con);//修改数据库名
	$sql ="UPDATE switch SET timestamp='$dati',state = '0'
	WHERE ID = '1'";//修改开关状态值
	if(!mysql_query($sql,$con)){
	    die('Error: ' . mysql_error());
	}else{
		mysql_close($con);
            $content = "报告大王："."\n"."电灯已经关闭";
    }
               break;
             
            case "打开插座":
            //回复文本消息
            $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
            $dati = date("h:i:sa");
	        mysql_select_db("app_ehac", $con);//修改数据库名
            $sql = "UPDATE switch SET timestamp = '$dati',state = '1' WHERE ID = '2'";
            if(!mysql_query($sql,$con)){
                die('Error:'.mysql_error());
            }
            else{
            mysql_close($con);
            $content ="报告大王："."\n". "插座已经打开";
            }
               break;
            
            case "关闭插座":
        //回复文本消息
            $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
	$dati = date("h:i:sa");
	mysql_select_db("app_ehac", $con);//修改数据库名
	$sql ="UPDATE switch SET timestamp='$dati',state = '0'
	WHERE ID = '2'";//修改开关状态值
	if(!mysql_query($sql,$con)){
	    die('Error: ' . mysql_error());
	}else{
		mysql_close($con);
            $content = "报告大王："."\n"."插座已经关闭";
    }
               break;
            case "帮助":
            case "怎么用":
                $content = array();
            $content[] = array("Title"=>"使用帮助",  "Description"=>"查看如何使用微信相关命令", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://1.ehac.sina.app.com/help.html");
                break;
            case "多图文":
                $content = array();
                $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                break;
            case "音乐":
                $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3");
                break;
            case "授权":
            $content = "<a href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ca4836ebbda7287&redirect_uri=http://1.ehac.sinaapp.com/device.php&response_type=code&scope=snsapi_userinfo&state=1'>点击授权</a>";
                break;
         case "JSSDK":
         $content = "<a href='http://1.ehac.sinaapp.com/device1.php'>JSSDK</a>";
                break;
            default:
            $content = "你可以输入如下指令:\n1.开灯或者打开电灯\2.关灯或者关闭电灯\n3.电量\n4.温度\n回复帮助获取更多用法！";
                break;
        }
        
        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }
    
    
    
    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "你刚才说的是：".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }
 
        return $result;
    }
    private function receiveEvent($object)
    {
        
        switch ($object->Event)
        {
            case "subscribe":
             $access_token = "ANVOdsmN6IRWlFxIT4YvTMrAkolQmgKu1sf2e9JfkPiSOVHB_k9sZHMBNKgg-c9ETt0x0IO3XQHWeTdKWNv0gHu1mNA3J7cNiUxK0Zd1yHM";
            $openid = $object->FromUserName;
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
            $output = $this->https_request($url);
            $jsoninfo = json_decode($output, true);
            
            $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
            mysql_select_db("app_ehac", $con);//修改数据库名
             
	  	     $sql = "INSERT  into ehac_user (nickname,openid,province,city) VALUES ('".$jsoninfo["nickname"]."','".$object->FromUserName."','".$jsoninfo["province"]."','".$jsoninfo["city"]."')";  

             if(!mysql_query($sql,$con)){
                die('Error:'.mysql_error());
            }
            else{
            mysql_close($con);
           
            }
            $contentStr = "欢迎关注".(isset($object->EventKey)?("\n场景 ".$object->EventKey):"");
                $contentStr[] = array("Title" =>"使用帮助", 
                        "Description" =>"查看可用的指令和操作手册", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"http://mp.weixin.qq.com/s?__biz=MzA4MTQxNTIyMg==&mid=200423180&idx=1&sn=1e1e687a375ed990c17194933dd67744#rd");
            case "unsubscribe":
            
             
                break;
           
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "离开模式":
                        $contentStr = "离开模式已启用";
                        break;
                    case "回家模式":
                        $contentStr[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "起床模式":
                        $contentStr[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "电量查询":
                        $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS); 
	                    mysql_select_db("app_ehac", $con);//修改数据库名
	                    $result = mysql_query("SELECT * FROM electricity");
	                   while($arr = mysql_fetch_array($result)){
	                   if ($arr['ID'] == 1) {
	  	               $tempr = $arr['data'];
                        $timr = $arr['timestamp'];
                        $money = 0.6;
                        $money *= $tempr; 
	                      }
	                   }
	                  mysql_close($con);
                        $contentStr = "报告大王："."\n"."截止".$timr."用电总量为：".$tempr."KWh，电量计费为".$money."元";
                        break;
                    case "LOCATION";
                    $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                        break;
                    default:
                        $contentStr[] = array("Title" =>"默认菜单回复", 
                        "Description" =>"您正在使用的是方倍工作室的自定义菜单测试接口", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                }
                break;
            default:
                break;      

        }
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }

 //回复文本消息
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
}



?>