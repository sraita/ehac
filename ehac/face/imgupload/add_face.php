<?php
$person_id=$_GET['person_id'];
?>
<!-- Navbar -->
        <div class="navbar">
          <!-- Home page navbar -->
         <div class="navbar-inner" data-page="add_face">
             <div class="left">
                <!-- Right link contains only icon - additional "icon-only" class-->
                <a href="#" popup-data="history" class="link back"><i class="icon icon-back"></i>取消</a>
              </div>
             <div class="right">Add Face</div>
         </div>
      </div>
<!-- Pages -->
<div class="pages">
<!-- page -->
	<div class="page" data-page="add_face">
		<div class="page-content demo">
            <form id="upload_form" enctype="multipart/form-data" method="post" action="./face/imgupload/upload.php" onSubmit="return checkForm()">
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />
                    <input type="hidden" id="person_id" name="person_id" value="<?php echo $person_id;?>"/>
                <div class="list-block">
                  <ul>
                    <!-- Text inputs -->
                    <li>
                      <div class="item-content">
                        <div class="item-inner">
                          <div class="item-title label">Face</div>
                          <div class="item-input">
                              <input type="file"  name="image_file" id="image_file" onChange="fileSelectHandler()" />
                          </div>
                        </div>
                      </div>
                    </li>
                    </ul>
                </div>

                <div class="card facebook-card step2">
                  <div class="card-content">
                    <div class="facebook-name error"></div>
                    <div class="card-content-inner">
                        <img id="preview"/>
                    </div>
                  </div>
                  <div class="card-footer info">
                    <input type="text" id="filesize" name="filesize" />
                    <input type="text" id="filetype" name="filetype" />
                    <input type="text" id="filedim" name="filedim" />
					<input type="text" id="w" name="w" />
					<input type="text" id="h" name="h" />
                  </div>
                </div>  
                <input type="submit" class="button" value="添加" /> 
                <div class="content-block-title">Labels and inputs</div>
            </form>
            
		</div>
	</div>
</div>