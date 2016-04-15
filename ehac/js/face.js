// Initialize your app
var myApp = new Framework7({
    modalTitle: 'ToDo7',
	 animateNavBackIcon:true,
	smartSelectBackOnSelect:true,
	swipeBackPage:true,
	smartSelectSearchbar: true,
	swipeBackPageThreshold:40,
	swipePanel: 'right',
});

// Export selectors engine
var $$ = Dom7;
//添加分组
$$('.add-fenzu').on('click', function () {
    myApp.prompt('请输入分组名称！', function (value) {
        var url = encodeURI("/ehac/face/action.php?group_name="+value);
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
        text: '添加分组[' + value + ']成功！',
        buttons: [
          {
            text: '确定',
            onClick: function() {
                window.location.assign("/ehac/face/face.php")
            }
          },
        ]
      })
    });
});
//删除照片
//- Two groups
$$('.del-photo').on('click', function () {
    var buttons1 = [
        {
            text: '删除',
            bold: true
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
//添加face
$$('.add-face').on('click', function () {
    myApp.modal({
    title:  '添加 Face',
    text: '<div class="list-block">'+
  			'<ul>'+
    			'<li>'+
                   '<div class="item-content">'+
                    '<div class="item-inner">'+
                      '<div class="item-input">'+
                        '<input type="file" placeholder="Your name">'+
                      '</div>'+
                    '</div>'+
                  '</div>'+
                '</li>'+
              '</ul>'+
            '</div>',
    buttons: [
      {
        text: '添加',
        bold: true
      },
    ]
  })
});
//- person-info
$$('.person-edit').on('click', function () {
    var buttons1 = [
        {
            text: 'Person Info',
            label: true
        },
        {
            text: '更新姓名',
            bold: true
        },{
            text: '删除',
            bold: true
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
     domCache: true //enable inline pages

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
view3.router.loadPage('scene.html');
    // Load about page:
view4.router.loadPage('help.html');

//页面回掉
$$(document).on('pageInit', function (e) {
    var page = e.detail.page;
    // Code for About page
    if (page.name === 'person_info') {
        $$('.confirm-ok').on('click', function () {
            myApp.confirm('Are you sure?', function () {
                myApp.alert('You clicked Ok button');
            });
        });
    }
    // Code for Services page
    if (page.name === 'services') {
        myApp.alert('Here comes our services!');
    }
});
          
               