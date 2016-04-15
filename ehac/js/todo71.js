// Initialize your app
var myApp = new Framework7({
    modalTitle: '智能家居云端',
    smartSelectInPopup:true,
	animateNavBackIcon:true,
	smartSelectBackOnSelect:true,
	swipeBackPage:true,
	smartSelectSearchbar: true,
	swipeBackPageThreshold:40,
	swipePanel: 'right',
	precompileTemplates: true,
    externalLinks:'.unlink',
});

// Export selectors engine
var $$ = Dom7;
// Add views
// Add main view
var mainView = myApp.addView('.view-main', {
    // Enable Dynamic Navbar for this view
    dynamicNavbar: true,
});
// Add another view, which is in right panel
var rightView = myApp.addView('.view-right', {
    // Enable Dynamic Navbar for this view
    dynamicNavbar: true
});

/* ===== Color themes ===== */
myApp.onPageInit('color-themes', function (page) {
    var themes = 'theme-white theme-black theme-yellow theme-red theme-blue theme-green theme-pink theme-lightblue theme-orange theme-gray';
    var layouts = 'layout-dark layout-white';
    $$(page.container).find('.ks-color-theme').click(function () {
        $$('body').removeClass(themes).addClass('theme-' + $$(this).attr('data-theme'));
    });
    $$(page.container).find('.ks-layout-theme').click(function () {
        $$('body').removeClass(layouts).addClass('layout-' + $$(this).attr('data-theme'));
    });
});
var view1 = myApp.addView('#view-1', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
});
var view2 = myApp.addView('#view-2', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
     domCache: true //enable inline pages

});
var view3 = myApp.addView('#view-3', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
     domCache: true ,//enable inline pages

});
var view4 = myApp.addView('#view-4', {
    // Because we use fixed-through navbar we can enable dynamic navbar
    dynamicNavbar: true,
     domCache: true ,//enable inline pages

});
var rightView = myApp.addView('.view-right', {
    // Enable Dynamic Navbar for this view
    dynamicNavbar: true
});


    // Load about page:
view2.router.loadPage('userinfo.php');
$$(document).on('pageInit', function (e) {
    var page = e.detail.page;
    // Code for Updevice page
    if (page.name === 'updevice') {
    $$('.button-saveupdevice').on('click', function () {
        myApp.modal({
                title:  '',
                text: '修改成功！',
                buttons: [
                  {
                    text: '确定',
                      onClick: function() {
                      window.location.assign("/index.php")
                    }
                  },
                ]
              })
    });
    }
    // Code for Services page
    if (page.name === 'automate') {
       var pickerDescribe = myApp.picker({
    input: '#automate',
    rotateEffect: true,
    cols: [
        {
            textAlign: 'left',
            values: ('10℃ 11℃ 12℃ 13℃ 14℃ 15℃ 16℃ 17℃ 18℃ 19℃ 20℃ 21℃ 22℃ 23℃ 24℃ 25℃').split(' ')
        },
        { values:('-').split('')},
        {
            values: ('15℃ 16℃ 17℃ 18℃ 19℃ 20℃ 21℃ 22℃ 23℃ 24℃ 25℃ 26℃ 27℃ 28℃ 29℃ 30℃').split(' ')
        },
    ]
}); 
myPicker.open(); 
    }  
 //page person_info                               
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
        //删除Face
        $$('.del-face').on('click', function () {
            myApp.confirm('删除Face?', function () {
                myApp.alert('Face删除成功！');
            });
        });
    }
});
        
var mySwiper1 = myApp.swiper('.swiper-1', {
  pagination:'.swiper-1 .swiper-pagination',
  spaceBetween: 100
});  

/*=== 有视频 ===*/
var myPhotoBrowserPopupDark = myApp.photoBrowser({
    photos : [
        
        {
            url: 'http://lorempixel.com/1024/1024/sports/2/',
        caption: '2015/3/20 22:15:44'
        },
        {
            url: 'http://lorempixel.com/1024/1024/sports/3/',
        caption: '2015/3/20 22:20:23'
        },
        {
        html: '<iframe src="http://i7.imgs.letv.com/player/swfPlayer.swf?id=22245668&autoplay=0" frameborder="0" allowfullscreen></iframe>',
            caption: '视频监控'
        },
    ],
    theme: 'dark',
    type: 'standalone'
});
$$('.pb-standalone-video').on('click', function () {
    myPhotoBrowserPopupDark.open();
});
        
var todoData = localStorage.td7Data ? JSON.parse(localStorage.td7Data) : [];

$$('.popup').on('open', function () {
    $$('body').addClass('with-popup');
});
$$('.popup').on('opened', function () {
    $$(this).find('input[name="title"]').focus();
});
$$('.popup').on('close', function () {
    $$('body').removeClass('with-popup');
    $$(this).find('input[name="title"]').blur().val('');
});

// Popup colors
$$('.popup .color').on('click', function () {
    $$('.popup .color.selected').removeClass('selected');
    $$(this).addClass('selected');
});

// Mark checked
$$('.todo-items-list').on('change', 'input', function () {
    var input = $$(this);
    var item = input.parents('li');
    var checked = input[0].checked;
    var id = item.attr('data-id') * 1;
    for (var i = 0; i < todoData.length; i++) {
        if (todoData[i].id === id) todoData[i].checked = checked ? 'checked' : '';
    }
    localStorage.td7Data = JSON.stringify(todoData);
});

//时间选择器
var today = new Date();
 
/* ===== Color themes ===== */
myApp.onPageInit('color-themes', function (page) {
    var themes = 'theme-white theme-black theme-yellow theme-red theme-blue theme-green theme-pink theme-lightblue theme-orange theme-gray';
    var layouts = 'layout-dark layout-white';
    $$(page.container).find('.ks-color-theme').click(function () {
        $$('body').removeClass(themes).addClass('theme-' + $$(this).attr('data-theme'));
    });
    $$(page.container).find('.ks-layout-theme').click(function () {
        $$('body').removeClass(layouts).addClass('layout-' + $$(this).attr('data-theme'));
    });
	$$('.page.ks-color-theme').on('click', function () {
    $$('.page.ks-color-theme.selected').removeClass('selected');
    $$(this).addClass('selected');
	});
});  
/* ===== qrcode ===== */
$$('.open-slider-modal').on('click', function () {
  var modal = myApp.modal({
    title: '分享到：',
    text: '智能家居云端管理系统',
    afterText:  '<div class="swiper-container" style="width: auto; margin:5px -15px -15px">'+
                  '<div class="swiper-pagination"></div>'+
                  '<div class="swiper-wrapper">'+
                    '<div class="swiper-slide"><img src="..." height="150" style="display:block"></div>' +
                    '<div class="swiper-slide"><img src="..." height="150" style="display:block"></div>'+
                  '</div>'+
                '</div>',
    buttons: [
      {
        text: '微信'
      },
      {
        text: '朋友圈'
      },
      {
        text: '微博'
      },
      {
        text: 'QQ空间',
        bold: true,
        onClick: function () {
          myApp.alert('Thanks! I know you like it!')
        }
      },
    ]
  })
  myApp.swiper($$(modal).find('.swiper-container'), {pagination: '.swiper-pagination'});
});
//添加分组
$$('.group_add').on('click', function () {
	myApp.prompt('请输入新的名字', function (value) {
		var url = encodeURI("face/group/add.php?group_name="+value);
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
//添加Person
function addPerson()
{
var person_name = document.getElementById("addperson_person_name").value;
var x=document.getElementById("addperson_group_name");
var group_name = x.options[x.selectedIndex].text;
var url = encodeURI("face/person/action.php?person_name="+person_name+"&group_name="+group_name);

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
    text: '设备添加成功！',
    buttons: [
      {
        text: '确定',
        onClick: function() {
            window.location.assign("/ehac/index.php")
        }
      },
    ]
  })
 }
