<?php
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
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                case "voice":
                    $resultStr = $this->receiveVoice($postObj);
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

    private function receiveText($object)
    {
        if (isset($object->Recognition)){
            $content = strval($object->Recognition);
            $mediaid = trim($object->MediaID);
        }else{
            $content = trim($object->Content);
        }
        if (isset($_SERVER['HTTP_APPNAME'])){
            include("segment.php");
            $result = sinasegment($content);
            if (is_array($result)){
                $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                mysql_select_db("app_ehac", $con);//修改数据库名
                switch ($result['keyword'])
                {
                    case "打开"; 
                    $sql = "UPDATE device SET status = '1' WHERE devicename='".$result['category']."' AND openid='".$object->FromUserName."'";
                    $replyContent ="'". $result['category']."'已经打开";
                    	break;
                    case "关闭";
                    $sql = "UPDATE device SET status = '0' WHERE devicename='".$result['category']."' AND openid='".$object->FromUserName."'";
                    $replyContent ="'". $result['category']."'已经关闭";
                    	break;
                    case "查看";
                    $sql = "SELECT * FROM device WHERE openid='".$object->FromUserName."'";
                    $sql1 = mysql_query($sql,$con);
                    while($arr = mysql_fetch_array($sql1)){
                      if ($arr['type'] ==2) {
                         $wendu = $arr['wendu'];
                         $shidu = $arr['shidu'];
                    	 }
                      if($arr['type']==3){
                         $smoke = $arr['data'];
                        }
                     }
                   
                        $replyContent = array();
                       $replyContent[] = array("Title" =>"室内环境状态", 
                                                "Description" =>"室内温度(℃)：".$wendu."\n".
                                                                "室内湿度：".$shidu."\n".
                                                                "烟雾浓度(PPM)：".$smoke."\n",

                                                "PicUrl" =>"", );

                     break;
                    default:
                        $replyContent = "还不支持这一功能：".$result['category'];
                    
                        break;
                }
                if(!mysql_query($sql,$con)){
                    die('Error:'.mysql_error());
                }
                else{
                mysql_close($con);
               
            }
            }else{
                
                        $replyContent = array();
                       $replyContent[] = array("Title" =>"指令错误！", 
                                                "Description" =>"支持的指令：\n".
                                                                "1.打开+设备名（如：打开客厅电灯）\n".
                                                            	"2.关闭+设备名（如：打开客厅电灯）\n".
                                               					"3.查看+数据（如：查看温度）\n\n".
                                                                "[同时支持文字指令&语言指令]\n",

                                                "PicUrl" =>"", );
            }
        }else{
            $replyContent = "只能运行在SAE环境！";
        }
        
        if (is_array($replyContent)){
            $resultStr = $this->transmitNews($object, $replyContent);
        }else{
            $resultStr = $this->transmitText($object, $replyContent);
        }
        return $resultStr;
    }
    
    private function receiveEvent($object)
    {
       $funcFlag = 0;
        $replyContent = "";
        switch ($object->Event)
        {
            case "subscribe":
                $replyContent = "欢迎关注方倍工作室";
            case "unsubscribe":
                break;
            case "scancode_waitmsg":
                $scan_result = $object->ScanCodeInfo->ScanResult;
                $result_str = explode('|', $scan_result);
                $devicename = $result_str[1];
                $sid = $result_str[2];
                $nid = $result_str[3];
                if ($result_str[0] == "ehacadd"){
                    $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db("app_ehac", $con);//修改数据库名
                    switch($sid){
                        case "001":
                        $devicepic = "wenduji";
                        break;
                        case "002":
                        break;
                        case "003":
                        
                        break;
                        case "004":
                        break;
                    }
                    //$sql = "INSERT INTO device (openid,devicename, sid,nid,devicepic)VALUES ("..", ".$devicename.",".$sid.",".$nid.",".$devicepic.",)";
                    $replyContent = array();
                    $replyContent[] = array("Title"=>"设备添加成功", "Description"=>"设备名（默认）：".$devicename.",\nSID：".$sid.",\nNID：".$nid.",\n点击“查看全文”，进入云端服务器软件设备管理", "PicUrl"=>"http://images.cnitblog.com/i/340216/201404/301756448922305.jpg", "Url" =>"http://mm.wanggou.com/item/jd2.shtml?sku=11447844");
                }else{
                    $replyContent = "设备添加提示：二维码信息错误!你扫描的二维码信息如下：\n类型： ".$object->ScanCodeInfo->ScanType." \n二维码信息：\n".$object->ScanCodeInfo->ScanResult;
                }
                break;            
            case "CLICK":
                switch ($object->EventKey)
                {
                    case "查看气体信息":
                        $replyContent = "离开模式已启用";
                        break;
                    case "查看湿度":
                        $replyContent[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "查看温度":
                        $replyContent[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "查看室内环境":
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
                        $replyContent = "报告大王："."\n"."截止".$timr."用电总量为：".$tempr."KWh，电量计费为".$money."元";
                        break;
                    case "团队介绍":
                        $replyContent = array();
                        $replyContent[] = array("Title"=>"基于Arduino的智能家居系统团队", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $replyContent[] = array("Title"=>"桂富波\n云端服务器软件设计", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $replyContent[] = array("Title"=>"刘  煜\n安防监控系统设计", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $replyContent[] = array("Title"=>"杨  烁\n智能家居网关设计", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");                    
                        break;
                    case "系统简介":
                        $replyContent[] = array("Title" =>"公司简介", 
                        "Description" =>"方倍工作室提供移动互联网相关的产品及服务", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"weixin://addfriend/pondbaystudio");
                        break;
                    case "使用帮助":
					$replyContent = array(); 
					$replyContent[] = array("Title" =>"云端服务器软件使用帮助", "Description" =>"", "PicUrl" =>"", "Url" =>"");
					$replyContent[] = array("Title" =>"【智能家居云端】\n1. 设备管理\na) 添加设备：通过设备管理菜单进入云端后，点击右上角+号进入添加设备流程\nb)通过添加设备菜单扫描设备二维码进入设备添加流程\n2. 用户中心\n通过用户中心菜单进入用户中心后，你可以设置预警通知接收邮件，设置气体预警值以及温湿度自动调节范围。", "Description" =>"", "PicUrl" =>"http://e.hiphotos.bdimg.com/wisegame/pic/item/9e1f4134970a304e1e398c62d1c8a786c9175c0a.jpg", "Url" =>"http://m.cnblogs.com/99079/3153567.html?full=1");
					$replyContent[] = array("Title" =>"【文本&语音指令】\n智能家居云端除了自定义菜单操作之外同时支持文本和语音指令\n1.查询命令：输入或说出包含关键词'查看'、'设备名'。例如：查看一下温度。\n2.设备操作命令：包含关键词‘打开’或‘关闭’、‘设备名’，例如：打开客厅电灯", "Description" =>"", "PicUrl" =>"http://g.hiphotos.bdimg.com/wisegame/pic/item/3166d0160924ab186196512537fae6cd7b890b24.jpg", "Url" =>"http://israel.duapp.com/taobao/index.php?id=1");
                    break;
                    case "查看室内环境":
                    case "LOCATION";
                    $replyContent = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
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

        if(is_array($replyContent)){
          if (isset($replyContent[0]['PicUrl'])){
                $resultStr = $this->transmitNews($object, $replyContent);
          }
       }else{
          $resultStr = $this->transmitText($object, $replyContent);
      }
	  return $resultStr;
    }

    private function receiveVoice($object)
    {
        $funcFlag = 0;
        
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = strval($object->Recognition);
             include("segment.php");
            $result = sinasegment($content);
            if (is_array($result)){
                $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                mysql_select_db("app_ehac", $con);//修改数据库名
                switch ($result['keyword'])
                {
                    case "打开"; 
                    $sql = "UPDATE device SET status = '1' WHERE devicename='".$result['category']."' AND openid='".$object->FromUserName."'";
                    $replyContent ="'". $result['category']."'已经打开";
                    	break;
                    case "关闭";
                    $sql = "UPDATE device SET status = '0' WHERE devicename='".$result['category']."' AND openid='".$object->FromUserName."'";
                    $replyContent ="'". $result['category']."'已经关闭";
                    	break;
                    case "查看";
                     $sql = "SELECT * FROM device WHERE openid='".$object->FromUserName."'";
                    $sql1 = mysql_query($sql,$con);
                    while($arr = mysql_fetch_array($sql1)){
                      if ($arr['type'] ==2) {
                         $wendu = $arr['wendu'];
                         $shidu = $arr['shidu'];
                    	 }
                      if($arr['type']==3){
                         $smoke = $arr['data'];
                        }
                     }
                   
                        $replyContent = array();
                       $replyContent[] = array("Title" =>"室内环境状态", 
                                                "Description" =>"室内温度(℃)：".$wendu."\n".
                                                                "室内湿度：".$shidu."\n".
                                                                "烟雾浓度(PPM)：".$smoke."\n",

                                                "PicUrl" =>"", );

                     break;
                    default:
                        $replyContent = "还不支持这一功能：".$result['category'];
                    
                        break;
                }
                if(!mysql_query($sql,$con)){
                    die('Error:'.mysql_error());
                }
                else{
                mysql_close($con);
               
            }
            }else{
               $replyContent = array();
                       $replyContent[] = array("Title" =>"指令错误！", 
                                                "Description" =>"支持的指令：\n".
                                                                "1.打开+设备名（如：打开客厅电灯）\n".
                                                            	"2.关闭+设备名（如：打开客厅电灯）\n".
                                               					"3.查看+数据（如：查看温度）\n\n".
                                                                "[同时支持文字指令&语言指令]\n",

                                                "PicUrl" =>"", );
                
            }
        }else{
            $replyContent = "未开启语音识别功能";
        }
        if (is_array($replyContent)){
            $resultStr = $this->transmitNews($object, $replyContent);
        }else{
            $resultStr = $this->transmitText($object, $replyContent);
        }
        return $resultStr;
    }
    
    
    private function transmitText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
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
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $resultStr = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $resultStr;
    }
}
?>