<?php
require_once '../facepp_sdk.php';
$facepp = new Facepp();
?>
<!-- Popup Face++ 添加Person -->
<div class="popup popup-face-person">
      <div class="view view-popup navbar-fixed">
        <div class="navbar">
          <div class="navbar-inner">
            <div class="left"><a href="#" class="link back">取消</a></div>
            <div class="center sliding">添加Person</div>
            <div class="right"></div>
          </div>
        </div>
        <div class="pages">
          <div class="page" data-page="add_person">
            <div class="page-content">
              <div class="list-block">
                <ul>
                  <li>
                    <div class="item-content">
                      <div class="item-inner"> 
                        <div class="item-title label">Name：</div>
                        <div class="item-input">
                          <input type="text" id="addperson_person_name">
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                  <!-- Additional "smart-select" class -->
                  <a href="#" class="item-link smart-select" data-open-in="popup">
                    <!-- select -->
                    <select id="addperson_group_name">
                    <?php
					$get_group = $facepp->execute('/info/get_group_list',array(''));
                    $arr_group = json_decode($get_group,true);
                    $group_num = count($arr_group['group']);
                    for($i=0;$i<$group_num;$i++)
                    {
					?>
                        <option><?php echo $arr_group['group'][$i]['group_name'];?></option>
                    <?php }?>
                    </select>
                    <div class="item-content">
                      <div class="item-inner">
                        <!-- Select label -->
                        <div class="item-title">Group：</div>
                        <!-- Selected value, not required -->
                        <div class="item-after"></div>
                      </div>
                    </div>
                  </a>
                </li>
                </ul>
              </div>
              <div class="content-block"><a href="#" class="button link " onclick="addPerson()">确认添加</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>