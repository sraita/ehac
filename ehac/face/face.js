// Initialize your app
var myApp = new Framework7();

// Export selectors engine
var $$ = Dom7;

// Add views
var view1 = myApp.addView('#view-1');
var view2 = myApp.addView('#view-2', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true
});
var view3 = myApp.addView('#view-3');
var view4 = myApp.addView('#view-4');
//页面回掉
$$(document).on('pageInit', function (e) {
    var page = e.detail.page;
    // Code for About page
    if (page.name === 'person_info') {
        //更新Person信息
             $$('.person-edit').on('click', function () {
                    var buttons1 = [
                {
                    text: 'Person Info',
                    label: true
                },
                {
                    text: '更改姓名',
                    onClick: function () {
                        myApp.prompt('请输入新的名字', function (value) {
                            var name = document.getElementById("person_name").innerHTML;
                            var url = encodeURI("ehac/face/action.php?q="+1+"&person_name="+name+"&name="+value);
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
                              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                {
                                document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                                }
                              }
                            xmlhttp.open("GET",url,true);
                            xmlhttp.send();
                             myApp.modal({
                            title:  '',
                            text: '姓名已更改为：' + value + '！',
                            buttons: [
                              {
                                text: '确定',
                                onClick: function() {
                                    window.location.assign("/ehac/face/index.php")
                                }
                              },
                            ]
                          })
                        });
                    }
                },
                {
                    text: '删除',
                    onClick: function () {
                        myApp.confirm('要删除吗?', function () {
                            var name = document.getElementById("person_name").innerHTML;
                            var url = encodeURI("ehac/face/action.php?person_del_name="+name);
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
                              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                {
                                document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                                }
                              }
                            xmlhttp.open("GET",url,true);
                            xmlhttp.send();
                             myApp.modal({
                            title:  '',
                            text: '姓名已更改为：' + value + '！',
                            buttons: [
                              {
                                text: '确定',
                                onClick: function() {
                                    window.location.assign("/ehac/face/index.php")
                                }
                              },
                            ]
                          })
                        });
                    }
             
                }
            ];
            var buttons2 = [
                {
                    text: '取消',
                    color: 'red'
                }
            ];
            var groups = [buttons1, buttons2];
    myApp.actions(groups);
        });
        //添加Face
             $$('.add-face').on('click', function () {
                var name = document.getElementById("person_name").innerHTML;
                var popupHTML = '<div class="popup">'+
                    '<div class="navbar">'+
                     '<div class="navbar-inner" data-page="person_info">'+
                         '<div class="left">'+
                            '<a href="#" class="link close-popup"><i class="icon icon-back"></i>返回</a>'+
                          '</div>'+
                          '<div class="right">Face++</div>'+
                     '</div>'+
                    '</div>'+
                    '<div class="content-block">'+
                      '<form enctype="multipart/form-data" action="imgupload.php?person_name=" method="post">'+
                      	'<div class="fileInput left">'+
                    		'<input type="file" name="myfile" id="upfile" class="upfile" onchange="document.getElementById('upfileResult').innerHTML=this.value"/>'+
                            '<input class="upFileBtn" type="button" value="上传图片" onclick="document.getElementById('upfile').click()" />'+   
                    	'</div>'+
                        '<span class="tip left" id="upfileResult">图片大小不超过2M,大小90*90,支持jpg、png、bmp等格式。</span>'+
                        '<input type="submit" value="添加Face" class="button"/>'+
                      '</form>'+
                    '</div>'+
                  '</div>'
              myApp.popup(popupHTML);
        });
        //删除Face
        $$('.del-face').on('click', function () {
            myApp.confirm('删除Face?', function () {
                myApp.alert('Face删除成功！');
            });
        });
    }
    // Code for Services page
    if (page.name === 'services') {
        myApp.alert('Here comes our services!');
    }
});