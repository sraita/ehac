<?php

//此文档为开发模式自定义回复功能实现demo，开发模式详情：http://t.cn/zRp0sr6
//其中主要演示receive接口的 单次 连接，实际使用时需写成循环，断开后再连
//运行说明：
//   1：启动前需将"./flag.txt"文件中的值设置为0未启动
//   2：可在安装了curl 的终端直接运行php start.php
    
    
//根据receive接口要求，需设置最大执行时间为5分钟超过时间自动断开，请确认该设置在运行环境中能生效


//加载SDK
require_once 'MessageClient.php';

//定义基本信息
//指定用于开发模式的应用appkey，详见：http://t.cn/zRp0sr6
define("APP_KEY", "2066890041");

//认证用户的微博ID，认证用户需已指定APP_KEY开发。如何指定：http://t.cn/zRp0sr6
define("UID", "1763353592");

//APP_KEY这个应用所有者（注意应用所有者可以不是需要获取消息的认证用户，认证用户指定该应用开发就行）的微博登录名
define("USER", "weitas@qq.com");

//APP_KEY这个应用所有者的微博登录密码
define("PWD", "621215");
    
//消息推送接口，需要长连接，详见文档：http://open.weibo.com/wiki/2/messages/receive
define("RECEIVE_URL", "https://m.api.weibo.com/2/messages/receive.json");
    
//消息回复接口，详见文档：http://open.weibo.com/wiki/2/messages/reply
define("REPLY_URL", "https://m.api.weibo.com/2/messages/reply.json");

//设置脚本运行标记存储文件路径
define("RUN_FLAG_FILE", "./flag.txt");
//设置脚本最后处理到的since_id标记存储文件路径
define("SINCE_ID_FILE", "./since_id.txt");

//设置运行标记,0表示未运行，1表示运行，启动前需将"./flag.txt"文件中的值设置为0未启动
function setFlag($flag = 0) {
    file_put_contents(RUN_FLAG_FILE, $flag);
}

//获取运行标记
function getFlag() {
    return file_get_contents(RUN_FLAG_FILE);
}

//判断运行标记，若已在运行则退出
$is_run = getFlag();
if ( ! empty($is_run)) {
    exit;
}

//设置脚本结束时清楚运行标记
register_shutdown_function("setFlag");

//设置运行标记为运行中，防止多个脚本同时运行
setFlag(1);

//获取最后处理到的消息id
$since_id = file_get_contents(SINCE_ID_FILE);
$since_id = $since_id ? $since_id : '';

//设置请求参数，其中参数since_id表示上次最后一次获取到的消息id
$args = array('source' => APP_KEY, "uid" => UID, "since_id" => $since_id);
//实例化SDK
$push = new MessageClient($args, RECEIVE_URL, USER, PWD);
foreach ($push as $v) {
    //开始处理业务
    $since_id = $v["id"];
    //记录当前处理的消息id
    file_put_contents(SINCE_ID_FILE, $since_id);

    //处理自动回复
    //纯文本回复
    //$type = "text";
    //$replayText = json_encode(array("text" => '收到 "' . $v["text"] . '"'));
    //图文方式回复
    $type = "articles";
    $replayText = json_encode(
        array(
            "articles" => array(
                array(
                    'display_name' => '消息服务 - "' . $v["text"] . '"',
                    'summary' => '消息服务是为认证帐号、应用提供的与微博用户进行消息互动的服务。​',
                    'image' => 'http://storage.mcp.weibo.cn/0JlIv.jpg',
                    'url' => 'http://open.weibo.com/wiki/Messages'
                )
            )
        )
    );

    //多图文方式回复，多个图文时在“articles”中添加多个数组既可，最多支持8个
//    $type = "articles";
//    $replayText = json_encode(
//        array(
//            "articles" => array(
//                array (
//                    'display_name'=>'图文标题1',
//                    'summary'=>'图文摘要​1',
//                    'image'=>'http://storage.mcp.weibo.cn/0JlIv.jpg',
//                    'url'=>'http://open.weibo.com/wiki/Messages'
//                ),
//                array (
//                    'display_name'=>'图文标题2',
//                    'summary'=>'图文摘要​2',
//                    'image'=>'http://ww2.sinaimg.cn/small/71666d49tw1dxms4qp4q0j.jpg',
//                    'url'=>'http://open.weibo.com/wiki/Messages'
//                ),
//                array (
//                    'display_name'=>'图文标题3',
//                    'summary'=>'图文摘要​3',
//                    'image'=>'http://http://ww2.sinaimg.cn/small/71666d49tw1dxms5mm654j.jpg',
//                    'url'=>'http://open.weibo.com/wiki/Messages'
//                )
//            )
//        )
//    );

    $post = array(
        "id" => $v["id"],
        'source' => APP_KEY,
        "type" => $type,
        "data" => $replayText,
    );
    $send = MessageClient::httpPost($post, REPLY_URL, USER, PWD);
}