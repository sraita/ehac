<?php

define("APP_SECRET", "ea6b22077436db890e7991c05d4196f1");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    //验证签名
    public function valid()
    {
       $signature = $_GET["signature"];        
        $timestamp = $_GET["timestamp"];        
        $nonce = $_GET["nonce"];	        				
        $token = APP_SECRET; 
        // 与微信不同,用APP_SECRET验证		
        $tmpArr = array($token, $timestamp, $nonce);		
        sort($tmpArr, SORT_STRING);		
        $tmpStr = implode( $tmpArr );		
        $tmpStr = sha1( $tmpStr );				
        if( $tmpStr == $signature )
        {			
            return true;		
        }else{			
            return false;		
        }	
    }

    //响应消息
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
             
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T ".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //接收事件消息
    private function receiveEvent($object)
    {
        $funcFlag = 0;
        $content = "";
        switch ($object->Event)
        {
             case "subscribe":
			$replyContent = array(); 
			$replyContent[] = array("Title" =>"系统简介","Description" =>"基于Ardunio的智能家居系统", "PicUrl" =>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/system.jpg",  "Url" =>"1.ehac.sinaapp.com");
			$replyContent[] = array("Title" =>"点击此处绑定账户","Description" =>"点击此处绑定账户", "PicUrl" =>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/link.png","Url" =>"1.ehac.sinaapp.com");  
            break;
            case "unsubscribe":
                break;           
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "查看气体信息":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']=2&&$row['data']!=null)
					   {
					   $smoke = $row['data'];
					   }
					 }
                    echo $smoke;                      
                        $content = "室内气体信息为：".$smoke."N2O";  
                    mysql_close ( $con );                     
                        break;
                    case "查看湿度":
                        $content = "室内湿度为：%"; 
                        break;
                    case "查看温度":
                        $content = "室内温度为℃";
                        break;
                    case "查看室内环境":
                       $content = array();
                       $content[] = array("Title" =>"室内环境状态", 
                                                "Description" =>"室内温度(℃)：".$wendu."\n".
                                                                "室内湿度：".$shidu."\n".
                                                                "烟雾浓度(N2O)：".$smoke."\n",

                                         
                       $content[] = array("Title" =>"室内环境状态", 
                                                "Description" =>"室内温度(℃)：".$wendu."\n".
                                                                "室内湿度：".$shidu."\n".
                                                                "烟雾浓度(N2O)：".$smoke."\n",

                                                "PicUrl" =>"", );
                        break;
                    case "团队介绍":
                        $content = array();
                        $content[] = array("Title"=>"基于Arduino的智能家居系统团队", "Description"=>"基于Arduino的智能家居系统团队", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/team.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $content[] = array("Title"=>"桂富波\n云端服务器软件设计", "Description"=>"桂富波\n云端服务器软件设计", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/iconfont-cloud.png", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $content[] = array("Title"=>"刘  煜\n安防监控系统设计", "Description"=>"刘  煜\n安防监控系统设计", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/iconfont-unie608.png", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $content[] = array("Title"=>"杨  烁\n智能家居网关设计", "Description"=>"杨  烁\n智能家居网关设计", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/iconfont-luyouqi.png", "Url" =>"http://m.cnblogs.com/?u=txw1958");                    
                        break;
                    case "系统简介":
                        $content = array();
                        $content[] = array("Title" =>"系统简介", 
                        "Description" =>"基于Ardunio的智能家居系统", 
                        "PicUrl" =>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/system.jpg", 
                        "Url" =>"1.ehac.sinaapp.com");
                        break;
                    case "使用帮助":
					$content = array(); 
					$content[] = array("Title" =>"云端服务器软件使用帮助", "Description" =>"\n【智能家居云端】\n
1. 设备管理\na) 添加设备：通过设备管理菜单进入云端后，点击右上角+号进入添加设备流程\nb)通过添加设备菜单扫描设备二维码进入设备添加流程\n
2. 用户中心\n通过用户中心菜单进入用户中心后，你可以设置预警通知接收邮件，设置气体预警值以及温湿度自动调节范围。\n
【文本&语音指令】\n
智能家居云端除了自定义菜单操作之外同时支持文本和语音指令\n
1.查询命令：输入或说出包含关键词'查看'、'设备名'。例如：查看一下温度。\n
2.设备操作命令：包含关键词‘打开’或‘关闭’、‘设备名’，例如：打开客厅电灯", 
                    "PicUrl" =>" ", "Url" =>"1.ehac.sinaapp.com");
                    break;
                    default:
                        break;
                }
                break;
            default:
                break;      

        }
        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if (strstr($keyword, "您好") || strstr($keyword, "你好") || strstr($keyword, "在吗")){
             
            $result = $this->transmitService($object);
        }
        //自动回复模式
        else{
            if (strstr($keyword, "开灯")){
                $content = "客厅电灯已经打开了";
            }else if(strstr($keyword, "绑定")){
                $urla= "https://api.weibo.com/oauth2/authorize?client_id=2066890041";
                $urlb = "&redirect_uri=http://1.ehac.sinaapp.com/weibo/callback.php&response_type=code";
                $content = array();
                $content[] = array("Title"=>"账户绑定\n",  "Description"=>"\n点击下面链接进行绑定\n", "PicUrl"=>"", "Url" =>$urla.$urlb);                
            }else if (strstr($keyword, "打开监控")|| strstr($keyword, "室内")){
                $content = array();
                $content[] = array("Title"=>"实时监控\n",  "Description"=>"\n建议在WiFi环境下查看\nPS：土豪请随意", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
                $content = array();
                $content[] = array("Title"=>"实时监控\n",  "Description"=>"\n建议在WiFi环境下查看\nPS：土豪请随意", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                $content[] = array("Title"=>"实时监控\n",  "Description"=>"\n建议在WiFi环境下查看\nPS：土豪请随意", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
            }else if (strstr($keyword, "音乐")){
                $content = array();
                $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3");
            }else{
                $content = date("Y-m-d H:i:s",time())."\n技术支持 方倍工作室";
            }
            
            if(is_array($content)){
                if (isset($content[0]['PicUrl'])){
                    $result = $this->transmitNews($object, $content);
                }
            }else{
                $result = $this->transmitText($object, $content);
            }
        }

        return $result;
    }

    //接收图片消息
    private function receiveImage($object)
    {
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
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

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
    <MediaId><![CDATA[%s]]></MediaId>
</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
 <ToUserName><![CDATA[%s]]></ToUserName>
 <FromUserName><![CDATA[%s]]></FromUserName>
 <CreateTime>%s</CreateTime>
 <MsgType><![CDATA[%s]]></MsgType>
 <PicUrl><![CDATA[%s]]></PicUrl>
 <MediaId><![CDATA[%s]]></MediaId>
 <MsgId>%s</MsgId>
 </xml>";
        


        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
    <MediaId><![CDATA[%s]]></MediaId>
</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "   
<item>
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
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
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

        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //生成参数二维码
    public function create_qrcode($scene_type, $scene_id)
    {
        switch($scene_type)
        {
            case 'QR_LIMIT_SCENE': //永久
                $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
                break;
            case 'QR_SCENE':       //临时
                $data = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
                break;
        }
        $url = "https://api.weibo.com/2/eps/qrcode/create.json?access_token=".$this->access_token;
        $res = $this->https_request($url, $data);
        $result = json_decode($res, true);
        return "https://api.weibo.com/2/eps/qrcode/show?ticket=".urlencode($result["ticket"]);
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