<?php
$person_id=$_GET['person_id'];
?>
<!-- Navbar -->
        <div class="navbar">
          <!-- Home page navbar -->
         <div class="navbar-inner" data-page="person_info">
             <div class="left">
                <!-- Right link contains only icon - additional "icon-only" class-->
                <a href="#" popup-data="history" class="link back"><i class="icon icon-back"></i>取消</a>
              </div>
              <div class="right">添加Face</div>
         </div>
      </div>
<!-- Pages -->
<div class="pages">
<!-- page -->
	<div class="page" data-page="add-face">
		<div class="page-content">
         	<div class="list-block">
              <ul>
                  <form enctype="multipart/form-data" action="face/action.php?person_id=<?php echo $person_id;?>" method="post"> 
                    <!-- Text inputs -->
                    <li>
                      <div class="item-content">
                        <div class="item-inner">
                          <div class="item-title label">Face</div>
                          <div class="item-input">
                              <input type="file" name="myfile" style="width:98%">
                          </div>
                        </div>
                      </div>
                    </li>
                    <div class="content-block-title"></div>
                   <input type="submit" class="button active" value="添加Face">
                  </form>
            </ul>
		</div>
	</div>
</div>
