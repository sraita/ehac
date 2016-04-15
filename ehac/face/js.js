// Initialize your app
var myApp = new Framework7();

// Export selectors engine
var $$ = Dom7;
//ajax基础函数

//添加分组
$$('.group_add').on('click', function () {
	myApp.prompt('请输入新的名字', function (value) {
		var url = encodeURI("group/add.php?group_name="+value);
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
				myApp.showIndicator();
			}
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				myApp.hideIndicator();
				myApp.alert("添加成功！");
			}
		}
		xmlhttp.open("GET",url,true);
		xmlhttp.send(); 
	});
                    
});
//分组操作
$$(".group_action").on('click', function () {
                    var buttons1 = [
                {
                    text: 'Group Info',
                    label: true
                },
                {
                    text: '更改分组名',
                    onClick: function () {
                        myApp.prompt('请输入新的名字', function (value) {
                            var name = document.getElementById("person_name").innerHTML;
                            var url = encodeURI("/ehac/face/action.php?person_name="+name+"&name="+value);
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
                            myApp.alert('姓名已更改为：' + value + '！');
                        });
                    }
                },
                {
                    text: '删除',
                    onClick: function () {
                         myApp.confirm('删除?', function () {
                          var group_name = document.getElementById("group_name").innerHTML;
                          var url = encodeURI("group/del.php?group_name="+group_name);
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
                            var url = encodeURI("/ehac/face/action.php?person_name="+name+"&name="+value);
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
                            myApp.alert('姓名已更改为：' + value + '！');
                        });
                    }
                },
                {
                    text: '删除',
                    onClick: function () {
                        myApp.confirm('要删除吗?', function () {
                            myApp.alert('删除成功！');
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
                    '<div class="list-block">'+
                       '<form enctype="multipart/form-data" action="imgupload.php" method="post">'+
                        '<ul>'+
                        '<li>'+
                          '<div class="item-content">'+
                            '<div class="item-inner">'+
                              '<div class="item-title label">Face</div>'+
                              '<div class="item-input">'+
                              '<input type="file" name="myfile" style="width:98%">'+
                              '</div>'+
                            '</div>'+
                          '</div>'+
                        '</li>'+
                        '</ul>'+
                        '<div class="content-block-title">仅支持jpg,png格式，小于2M</div>'+
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

var xmlhttp;
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
     var data1 = xmlhttp.responseText
     var carHTML = Template7.templates.carTemplate(data1);
     document.getElementById('grouplist').innerHTML = Template7.templates.carTemplate(data12);   
    }
  }