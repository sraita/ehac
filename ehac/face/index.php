<?PHP
require_once 'facepp_sdk.php';
$facepp = new Facepp();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>My App</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="../css/framework7.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="css.css">
      <style>
          .facebook-card{
              padding:0;
              margin:0;
          }
          .facebook-card .card-header {
            display: block;
            padding: 20px;
          }
          .facebook-card .facebook-avatar {
            float: left;
          }
          .facebook-card .facebook-name {
            margin:5 100px;
            font-size: 16px;
            font-weight: 500;
              color: #ffffff;
          }
          .facebook-card .facebook-date {
            font-size: 16px;
            color: #ffffff;
          }
          .facebook-card .facebook-name img
          {
              border:2px solid #ffffff;
              border-radius:100%;
          
          }
          .fileInput{width:102px;height:34px; background:url(http://ehac-img.stor.sinaapp.com/005EB277AC3A84244D9941ECA550364B_dat.jpg);overflow:hidden;position:relative;}
 		  .upfile{position:absolute;top:-100px;}
 		  .upFileBtn{width:102px;height:34px;opacity:0;filter:alpha(opacity=0);cursor:pointer;}
     
      </style>
  </head>
  <body>
    <!-- Status bar overlay for fullscreen mode-->
    <div class="statusbar-overlay"></div>
    <!-- Panels overlay-->
    <div class="panel-overlay"></div>
    <!-- Left panel with reveal effect-->
    <div class="panel panel-left panel-reveal">
      <div class="content-block">
        <p>Left panel content goes here</p>
      </div>
    </div>
    <!-- Right panel with cover effect-->
    <div class="panel panel-right panel-cover">
      <div class="content-block">
        <p>Right panel content goes here</p>
      </div>
    </div>
    <!-- Views, and they are tabs-->
    <!-- We need to set "toolbar-through" class on it to keep space for our tab bar-->
    <div class="views tabs toolbar-through">
      <!-- Your first view, it is also a .tab and should have "active" class to make it visible by default-->
      <div id="view-1" class="view view-main tab active">
        <!-- Pages-->
        <div class="pages">
          <!-- Page, data-page contains page name-->
          <div data-page="index-1" class="page">
            <!-- Scrollable page content-->
            <div class="page-content">
              <div class="content-block-title">分组管理</div>
                <div class="list-block">
                  <ul>
                    <li class="item-content group_add">
                      <div class="item-inner">
                        <div class="item-title">添加分组</div>
                      </div>
                    </li>
                    <li class="item-divider"></li>
                    <?php
					$get_group = $facepp->execute('/info/get_group_list',array(''));
                    $arr_group = json_decode($get_group,true);
                    $group_num = count($arr_group['group']);
                    for($i=0;$i<$group_num;$i++)
                    {
					?>
                      <li class="swipeout">
                      <!-- 被“swipeout-content”包裹起来的普通列表元素 -->
                      <div class="swipeout-content">
                        <!-- 你的列表元素放在这里 -->
                        <div class="item-content">
                          <div class="item-inner" id="group_name"><?php echo $arr_group['group'][$i]['group_name'];?></div>
                        </div>
                      </div>
                      <!-- Swipeout actions right -->
                      <div class="swipeout-actions-right">
                        <!-- Swipeout actions links/buttons -->
                        <a href="#" class="swipeout-close bg-green">Edit</a>
                        <a class="swipeout-close  bg-red group_del" onclick="del_group('<?php echo $arr_group['group'][$i]['group_name'];?>');">Del</a>
                      </div>
                    </li>
                      <?php }?>
                  </ul>
                </div>

              <div class="content-block-title">Face记录</div>
                <div class="list-block cards-list">
                  <ul>
                    <li class="card">
                      <div class="card-content">
                        <div class="list-block media-list">
                          <ul>
                            <li class="item-content pb-standalone">
                              <div class="item-media">
                                <img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="44">
                              </div>
                              <div class="item-inner">
                                <div class="item-title-row">
                                  <div class="item-title">陌生人</div>
                                </div>
                                <div class="item-subtitle">15：20</div>
                              </div>
                            </li>
                             
                            <li class="item-content pb-standalone">
                              <div class="item-media pb-standalone">
                                <img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="44">
                              </div>
                              <div class="item-inner">
                                <div class="item-title-row">
                                  <div class="item-title">朋友</div>
                                </div>
                                <div class="item-subtitle">14：30</div>
                              </div>
                            </li>
                            <li class="item-content pb-standalone">
                              <div class="item-media">
                                <img src="http://ehac-img.stor.sinaapp.com/130649465939176112.jpg" width="44">
                              </div>
                              <div class="item-inner">
                                <div class="item-title-row">
                                  <div class="item-title">朋友</div>
                                </div>
                                <div class="item-subtitle">13：00</div>
                              </div>
                            </li>                          
                          </ul>
                        </div>
                      </div>
                     
                      <div class="card-footer">
                        <span>2015/05/19</span>
                        <span>3 条记录</span>
                      </div>
                    </li>
                  </ul>
                </div>        
            </div>
          </div>
        </div>
      </div>
      <!-- Second view (for second wrap)-->
      <div id="view-2" class="view tab">
        <!-- We can make with view with navigation, let's add Top Navbar-->
        <div class="navbar">
          <div class="navbar-inner">
            <div class="center sliding">Face++</div>
          </div>
        </div>
        <div class="pages navbar-through">
          <div data-page="index-2" class="page">
              <!-- Search bar -->
              <form data-search-list=".list-block-search" data-search-in=".item-inner" class="searchbar searchbar-init">
                <div class="searchbar-input">
                  <input type="search" placeholder="Search"><a href="#" class="searchbar-clear"></a>
                </div><a href="#" class="searchbar-cancel">Cancel</a>
              </form>
             
              <!-- Search bar overlay -->
              <div class="searchbar-overlay"></div>
            <div class="page-content">
                  <div class="list-block">
                  <ul>
                    <li class="item-content">
                      <div class="item-media"><i class="icon icon-f7"></i></div>
                      <div class="item-inner">
                        <div class="item-title">分组管理</div>
                      </div>
                    </li>
                    <li class="item-content">
                      <div class="item-media"><i class="icon icon-f7"></i></div>
                      <div class="item-inner">
                        <div class="item-title">Face++ 记录</div>
                      </div>
                    </li>
                    <li class="item-content">
                      <div class="item-media"><i class="icon icon-f7"></i></div>
                      <div class="item-inner">
                        <div class="item-title">访客管理</div>
                      </div>
                    </li>
                    <li class="item-content">
                      <div class="item-media"><i class="icon icon-f7"></i></div>
                      <div class="item-inner">
                        <div class="item-title">未采集识别</div>
                      </div>
                    </li>                      
                    </ul>
                    </div>
              <div class="list-block media-list list-block-search  searchbar-found">
                <ul>
                    <?php 
                        $personlist = $facepp->execute('/info/get_person_list',array(''));
                        $arr = json_decode($personlist,true); //后面加true转换为数组
                        $b = count($arr['person']);
                        for($j=0;$j<$b;$j++){
                           $get_face_id = $facepp->execute('/person/get_info',array('person_name'=>$arr['person'][$j]['person_name']));
                            		$arr_face = json_decode($get_face_id,true);
                            		$get_img = $facepp->execute('/info/get_face',array('face_id'=>$arr_face['face'][0]['face_id']));
                                    $arr_img = json_decode($get_img,true);
                                    $img_url = $arr_img['face_info'][count($arr_img)-1]['url'];
                            if($arr_face['group'][0]['group_name'] != null){
                        ?> 
                    <li><a href="person/person_info.php?person_id=<?php echo $arr['person'][$j]['person_id'];?>" class="item-link">
                      <div class="item-content">
                        <div class="item-media"><img src="<?php echo $img_url;?>" width="60" height="60"></div>
                        <div class="item-inner"> 
                          <div class="item-title-row">
                            <div class="item-title"><?php echo $arr['person'][$j]['person_name'];?></div>
                            <div class="item-after"><?php echo $arr_face['tag'][0];?></div>
                          </div>
                          <div class="item-subtitle"><?php echo $arr_face['group'][0]['group_name'];?></div>
                        </div>
                      </div></a></li>
                    <?php }}?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="view-3" class="view tab">
        <div class="pages">
          <div data-page="index-3" class="page">
            <div class="page-content">
              <div class="content-block-title">Another plain static view</div>
              <div class="content-block">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel commodo massa, eu adipiscing mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus ultricies dictum neque, non varius tortor fermentum at. Curabitur auctor cursus imperdiet. Nam molestie nisi nec est lacinia volutpat in a purus. Maecenas consectetur condimentum viverra. Donec ultricies nec sem vel condimentum. Phasellus eu tincidunt enim, sit amet convallis orci. Vestibulum quis fringilla dolor.    </p>
                <p>Mauris commodo lacus at nisl lacinia, nec facilisis erat rhoncus. Sed eget pharetra nunc. Aenean vitae vehicula massa, sed sagittis ante. Quisque luctus nec velit dictum convallis. Nulla facilisi. Ut sed erat nisi. Donec non dolor massa. Mauris malesuada dolor velit, in suscipit leo consectetur vitae. Duis tempus ligula non eros pretium condimentum. Cras sed dolor odio.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel commodo massa, eu adipiscing mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus ultricies dictum neque, non varius tortor fermentum at. Curabitur auctor cursus imperdiet. Nam molestie nisi nec est lacinia volutpat in a purus. Maecenas consectetur condimentum viverra. Donec ultricies nec sem vel condimentum. Phasellus eu tincidunt enim, sit amet convallis orci. Vestibulum quis fringilla dolor.    </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="view-4" class="view tab">
        <div class="pages navbar-fixed">
          <div data-page="index-4" class="page">
            <div class="navbar">
              <div class="navbar-inner">
                <div class="center">Settings</div>
              </div>
            </div>
            <div class="page-content">
              <div class="list-block">
                <ul>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-name"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">Name</div>
                        <div class="item-input">
                          <input type="text" placeholder="Your name">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-email"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">E-mail</div>
                        <div class="item-input">
                          <input type="email" placeholder="E-mail">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-url"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">URL</div>
                        <div class="item-input">
                          <input type="url" placeholder="URL">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-password"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">Password</div>
                        <div class="item-input">
                          <input type="password" placeholder="Password">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-tel"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">Phone</div>
                        <div class="item-input">
                          <input type="tel" placeholder="Phone">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-gender"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">Gender</div>
                        <div class="item-input">
                          <select>
                            <option>Male</option>
                            <option>Female</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-calendar"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">Birth date</div>
                        <div class="item-input">
                          <input type="date" placeholder="Birth day" value="2014-04-30">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-toggle"></i></div>
                      <div class="item-inner"> 
                        <div class="item-title label">Switch</div>
                        <div class="item-input">
                          <label class="label-switch">
                            <input type="checkbox">
                            <div class="checkbox"></div>
                          </label>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="item-content">
                      <div class="item-media"><i class="icon icon-form-settings"></i></div>
                      <div class="item-inner">
                        <div class="item-title label">Slider</div>
                        <div class="item-input">
                          <div class="range-slider">
                            <input type="range" min="0" max="100" value="50" step="0.1">
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="content-block">
                <p>Mauris commodo lacus at nisl lacinia, nec facilisis erat rhoncus. Sed eget pharetra nunc. Aenean vitae vehicula massa, sed sagittis ante. Quisque luctus nec velit dictum convallis. Nulla facilisi. Ut sed erat nisi. Donec non dolor massa. Mauris malesuada dolor velit, in suscipit leo consectetur vitae. Duis tempus ligula non eros pretium condimentum. Cras sed dolor odio.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Bottom Tabbar-->
      <div class="toolbar tabbar tabbar-labels">
        <div class="toolbar-inner"><a href="#view-1" class="tab-link active"> <i class="icon tabbar-demo-icon-1"></i><span class="tabbar-label">Information</span></a><a href="#view-2" class="tab-link"><i class="icon tabbar-demo-icon-2"></i><span class="tabbar-label">Inbox</span></a><a href="#view-3" class="tab-link"> <i class="icon tabbar-demo-icon-3"><span class="badge bg-red">4</span></i><span class="tabbar-label">Upload</span></a><a href="#view-4" class="tab-link"> <i class="icon tabbar-demo-icon-4"></i><span class="tabbar-label">Photos</span></a></div>
      </div>
    </div>
    <!-- Path to Framework7 Library JS-->
    <script type="text/javascript" src="../js/framework7.min.js"></script>
    <!-- Path to your app js-->
      <script type="text/javascript" src="js.js"></script>
  </body>
</html>
<script>
    //删除分组
function del_group(group_name) {
    var name = group_name;
     myApp.confirm('删除?', function () {
         //var group_name = document.getElementById("group_del").src;
         var url = encodeURI("action.php?group_name="+name);
          if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function()
          {
            if (xmlhttp.readyState != 4)
            {
              myApp.showIndicator()
            }
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
              myApp.hideIndicator();
              myApp.alert("删除成功！");
            }
          }
          xmlhttp.open("GET",url,true);
          xmlhttp.send();
    });
  
};
</script>