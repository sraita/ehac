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
//接收文本消息
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
                $result_o = mysql_query("SELECT * FROM device WHERE  devicename='".$result['category']."' AND openid='".$object->FromUserName."'");
                while($row = mysql_fetch_array($result_o))
                  {
                	$sid_o = $row['sid'];
                    $nid_o = $row['nid'];
                  }
				echo $sid_o;
                echo $nid_o;
                $nowt=time()-60*10;//当前时间 60*60是一个小时 
				$time=date("Y-m-d H:i:s",$nowt);
                switch ($result['keyword'])
                {
                    case "打开"; 
                    $sql = "INSERT INTO api_worklist (sid, nid, data,time) VALUES ('".$sid_o."', '".$nid_o."', '1','".$time."')";
                    $sql1 = mysql_query($sql,$con);                    
                    $replyContent ="'". $result['category']."'已经打开";
                    	break;
                    case "关闭";
                    $sql = "INSERT INTO api_worklist (sid, nid, data,time) VALUES ('".$sid_o."', '".$nid_o."', '0','".$time."')";
                    $sql1 = mysql_query($sql,$con);                    
                    $replyContent ="'". $result['category']."'已经关闭";
                    	break;
                    case "查看";
                    $sql = "SELECT * FROM device WHERE openid='".$object->FromUserName."'";
                    $sql1 = mysql_query($sql,$con);
                    while($arr = mysql_fetch_array($sql1)){
                      if ($arr['sid'] ==1) {
                         $tempnid = $arr['nid'];
                    	 }
                      if($arr['sid']==2){
                         $smokenid = $arr['nid'];
                        }
                     }
                    echo $tempnid;
                    echo $somkenid;
                    if(!mysql_query($sql,$con)){
                    die('Error:'.mysql_error());
                	}
                	else{
                		mysql_close($con);
           			}
                    switch($result['category'])
                    {
                        case "温度":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']==1&&$row['nid']==$tempnid)
					   {
					   $temp = substr($row['data'],3);
					   }
					 }
                    echo $temp;                         
                        $replyContent = "室内温度为".$temp."℃";
                    mysql_close ( $con );                         
                        break;
                        case "湿度":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']==1&&$row['nid']==$smokenid)
					   {
					   $humidity = substr($row['data'],0,2);
					   }
					 }
                    echo $humidity;                          
                        $replyContent = "室内湿度为：".$humidity."%";
                    mysql_close ( $con );                          
                        break;
                        case "烟雾浓度":
                        case "气体信息":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']==2&&$row['nid']!=$smokenid)
					   {
					   $smoke = $row['data'];
					   }
					 }
                    echo $smoke;                         
                        $replyContent = "室内气体信息为：".$smoke."N2O"; 
                    mysql_close ( $con );                        
                        break;
                    }
                     break;
                    default:
                        $replyContent = "还不支持这一功能：".$result['category'];
                    
                        break;
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
			$replyContent = array(); 
			$replyContent[] = array("Title" =>"系统简介","Description" =>"基于Ardunio的智能家居系统", "PicUrl" =>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/system.jpg",  "Url" =>"1.ehac.sinaapp.com");
			$replyContent[] = array("Title" =>"点击此处绑定账户","Description" =>"", "PicUrl" =>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/link.png","Url" =>"1.ehac.sinaapp.com");  
            break;
            case "unsubscribe":
                break;
            case "scancode_waitmsg":
                $scan_result = $object->ScanCodeInfo->ScanResult;
                $result_str = explode('|', $scan_result);
                $devicename = $result_str[1];
                $sid = $result_str[2];
                $nid = $result_str[3];
                $id = microtime(true) * 1000;
                if ($result_str[0] == "ehacadd"){
                    switch($sid){
                        case "001":
                        $devicepic = "wenduji";
                        break;
                        case "002":
                        $devicepic = "qiti";
                        break;
                        case "003":
                        $devicepic = "kaiguan";
                        break;
                        case "004":
                        $devicepic = "hongwaixian";
                        break;
                        case "005":
                        $devicepic = "shexiangtou";
                        break;
                    }
                 $con = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                mysql_select_db("app_ehac", $con);//修改数据库名
                    mysql_query("INSERT INTO device (id,openid,sid,nid,devicename,devicepic)VALUES ('".$id."','".$object->FromUserName."', '".$sid."','".$nid."','".$devicename."','".$devicepic."')");
                    $sql1 = mysql_query($sql,$con);
             mysql_close ( $con );                     
                    $replyContent = array();
                    $replyContent[] = array("Title"=>"设备添加成功", "Description"=>"设备名（默认）：".$devicename.",\nSID：".$sid.",\nNID：".$nid.",\n点击“查看全文”，进入云端服务器软件设备管理", "PicUrl"=>"", "Url" =>"http://ehac.sinaapp.com/ehac");
                       
                }else{
                    $replyContent = "设备添加提示：二维码信息错误!你扫描的二维码信息如下：\n类型： ".$object->ScanCodeInfo->ScanType." \n二维码信息：\n".$object->ScanCodeInfo->ScanResult;
                }
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
					 
					   if($row['sid']==2&&$row['data']!=null)
					   {
					   $smoke = $row['data'];
					   }
					 }
                    echo $smoke;                    
                    
                        $replyContent = "室内气体信息为：".$smoke."ppm"; 
                    mysql_close ( $con );                    
                        break;
                    case "查看湿度":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if(strlen($row['data'])==8)
					   {
					   $humidity = substr($row['data'],0,2);
					   }
					 }
                    echo $humidity;                    
                        $replyContent = "室内湿度为：".$humidity."%"; 
                    mysql_close ( $con );
                        break;
                    case "查看温度":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if(strlen($row['data'])==8)
					   {
					   $temp = substr($row['data'],3);
					   }
                      if(strlen($row['data'])==8)
					   {
					   $humidity = substr($row['data'],0,2);
					   }
					 }
					echo $temp;
                    echo $humidity;
                        $replyContent = "室内温度为".$temp."℃";
                    mysql_close ( $con );
                        break;
                    case "查看室内环境":
                                        $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if(strlen($row['data'])==8)
					   {
					   $temp = substr($row['data'],3);
					   }
                      if(strlen($row['data'])==8)
					   {
					   $humidity = substr($row['data'],0,2);
					   }
                       if($row['sid']==2&&$row['data']!=null)
					   {
					   $smoke = $row['data'];
					   }
					 }
					echo $temp;
                    echo $humidity;
                    echo $smoke;
                       $replyContent = array();
                       $replyContent[] = array("Title" =>"室内环境状态", 
                                                "Description" =>"室内温度(℃)：".$temp."\n".
                                                                "室内湿度：".$humidity."\n".
                                                                "烟雾浓度(ppm)：".$smoke."\n",

                                                "PicUrl" =>"", );
                    mysql_close ( $con );
                        break;
                    case "团队介绍":
                        $replyContent = array();
                        $replyContent[] = array("Title"=>"基于Arduino的智能家居系统团队", "Description"=>"", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/team.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $replyContent[] = array("Title"=>"桂富波\n云端服务器软件设计", "Description"=>"", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/iconfont-cloud.png", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $replyContent[] = array("Title"=>"刘  煜\n安防监控系统设计", "Description"=>"", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/iconfont-unie608.png", "Url" =>"http://m.cnblogs.com/?u=txw1958");
                        $replyContent[] = array("Title"=>"杨  烁\n智能家居网关设计", "Description"=>"", "PicUrl"=>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/iconfont-luyouqi.png", "Url" =>"http://m.cnblogs.com/?u=txw1958");                    
                        break;
                    case "系统简介":
                        $replyContent[] = array("Title" =>"系统简介", 
                        "Description" =>"基于Ardunio的智能家居系统", 
                        "PicUrl" =>"https://api.sinas3.com/v1/SAE_ehac/wechatimg/system.jpg", 
                        "Url" =>"1.ehac.sinaapp.com");
                        break;
                    case "使用帮助":
					$replyContent = array(); 
					$replyContent[] = array("Title" =>"云端服务器软件使用帮助", "Description" =>"", "PicUrl" =>"", "Url" =>"");
					$replyContent[] = array("Title" =>"【智能家居云端】\n1. 设备管理\na) 添加设备：通过设备管理菜单进入云端后，点击右上角+号进入添加设备流程\nb)通过添加设备菜单扫描设备二维码进入设备添加流程\n2. 用户中心\n通过用户中心菜单进入用户中心后，你可以设置预警通知接收邮件，设置气体预警值以及温湿度自动调节范围。", "Description" =>"", "PicUrl" =>"", "Url" =>"http://m.cnblogs.com/99079/3153567.html?full=1");
					$replyContent[] = array("Title" =>"【文本&语音指令】\n智能家居云端除了自定义菜单操作之外同时支持文本和语音指令\n1.查询命令：输入或说出包含关键词'查看'、'设备名'。例如：查看一下温度。\n2.设备操作命令：包含关键词‘打开’或‘关闭’、‘设备名’，例如：打开客厅电灯", "Description" =>"", "PicUrl" =>"", "Url" =>"http://israel.duapp.com/taobao/index.php?id=1");
                    break;
                    default:
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
                                $result_l = mysql_query("SELECT * FROM device WHERE  devicename='".$result['category']."' AND openid='".$object->FromUserName."'");
                while($row = mysql_fetch_array($result_l))
                  {
                	$sid_l = $row['sid'];
                    $nid_l = $row['nid'];
                  }
				echo $sid_o;
                echo $nid_o;
                $nowt=time()-60*10;//当前时间 60*60是一个小时 
				$time=date("Y-m-d H:i:s",$nowt);
                switch ($result['keyword'])
                {
                    case "打开"; 
                    $sql = "INSERT INTO api_worklist (sid, nid, data,time) VALUES ('".$sid_l."', '".$nid_l."', '1','".$time."')";
                    $sql1 = mysql_query($sql,$con);                    
                    $replyContent ="'". $result['category']."'已经打开";
                    	break;
                    case "关闭";
                    $sql = "INSERT INTO api_worklist (sid, nid, data,time) VALUES ('".$sid_l."', '".$nid_l."', '0','".$time."')";
                    $sql1 = mysql_query($sql,$con);                    
                    $replyContent ="'". $result['category']."'已经关闭";
                    	break;
                    case "查看";
                    $sql = "SELECT * FROM device WHERE openid='".$object->FromUserName."'";
                    $sql1 = mysql_query($sql,$con);
                    while($arr = mysql_fetch_array($sql1)){
                      if ($arr['sid'] ==1) {
                         $tempnid = $arr['nid'];
                    	 }
                      if($arr['sid']==2){
                         $smokenid = $arr['nid'];
                        }
                     }
                    echo $tempnid;
                    echo $somkenid;
                    if(!mysql_query($sql,$con)){
                    die('Error:'.mysql_error());
                	}
                	else{
                		mysql_close($con);
           			}
                    switch($result['category'])
                    {
                        case "温度":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']==1&&$row['nid']==$tempnid)
					   {
					   $temp = substr($row['data'],3);
					   }
					 }
                    echo $temp;                         
                        $replyContent = "室内温度为".$temp."℃";
                    mysql_close ( $con );                         
                        break;
                        case "湿度":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']==1&&$row['nid']==$tempnid)
					   {
					   $humidity = substr($row['data'],0,2);
					   }
					 }
                    echo $humidity;                          
                        $replyContent = "室内湿度为：".$humidity."%";
                    mysql_close ( $con );                          
                        break;
                        case "烟雾浓度":
                        case "气体信息":
                    $mysql_state = "SELECT * FROM api_worklist";                       
                    $con =  mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                    mysql_select_db ( "app_ehac", $con );
                    $result = mysql_query ( $mysql_state );
                    $total = mysql_num_rows($result);
                    while($row = mysql_fetch_array($result,MYSQL_ASSOC))
                    {  
					 
					   if($row['sid']==2&&$row['nid']!=$smokenid)
					   {
					   $smoke = $row['data'];
					   }
					 }
                    echo $smoke;                         
                        $replyContent = "室内气体信息为：".$smoke."N2O"; 
                    mysql_close ( $con );                        
                        break;
                    }
                     break;
                    default:
                        $replyContent = "还不支持这一功能：".$result['category'];
                    
                        break;
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