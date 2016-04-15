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
var view1 = myApp.addView('#view-1');
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
    // Load about page:
view3.router.loadPage('scene.html');
    // Load about page:
view4.router.loadPage('help.html');

$$(document).on('pageInit', function (e) {
    var page = e.detail.page;
    // Code for About page
    // Code for Services page
    if (page.name === 'automate') {
       var pickerDescribe = myApp.picker({
    input: '#automate',
    rotateEffect: true,
    cols: [
        {
            textAlign: 'left',
            values: ('-10℃ -5℃ 0℃ 5℃ 10℃ 15℃ 20℃ 25℃').split(' ')
        },
        { values:('-').split('')},
        {
            values: ('15℃ 20℃ 25℃ 30℃ 35℃ 40℃ 45℃ 50℃').split(' ')
        },
    ]
}); 
myPicker.open(); 
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


// Add Task
$$('.popup .add-task').on('click', function JSON_test(o){
    var devicename = $$('.popup input[name="devicename"]').val().trim();
    if (devicename.length === 0) {
        return;
    }
    var color = $$('.popup .color.selected').attr('data-color');
    todoData.push({
        devicename: devicename,
        color: color,
        checked: '',
        id: (new Date()).getTime()
    });
    localStorage.td7Data = JSON.stringify(todoData);
	document.getElementById('txt_json').value=json_string; 
     alert("点击确定后将提交表单"); 
     o.submit(); 
    buildTodoListHtml();
    myApp.closeModal('.popup');
});

// Build Todo HTML using Template7 template engine
var todoItemTemplateSource = $$('#todo-item-template').html();
var todoItemTemplate = Template7.compile(todoItemTemplateSource);
function buildTodoListHtml() {
    var renderedList = todoItemTemplate(todoData);
    $$('.todo-items-list').html(renderedList);
}
// Build HTML on App load
buildTodoListHtml();

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
//延时计划

//定时任务
//设备信息
// Delete item
$$('.card').on('delete', '.swipeout', function () {
    var id = $$(this).attr('data-id') * 1;
    var index;
    for (var i = 0; i < todoData.length; i++) {
        if (todoData[i].id === id) index = i;
    }
    if (typeof(index) !== 'undefined') {
        todoData.splice(index, 1);
        localStorage.td7Data = JSON.stringify(todoData);
    }
});

// Update app when manifest updated 
// http://www.html5rocks.com/en/tutorials/appcache/beginner/
// Check if a new cache is available on page load.
window.addEventListener('load', function (e) {
    window.applicationCache.addEventListener('updateready', function (e) {
        if (window.applicationCache.status === window.applicationCache.UPDATEREADY) {
            // Browser downloaded a new app cache.
            myApp.confirm('A new version of ToDo7 is available. Do you want to load it right now?', function () {
                window.location.reload();
            });
        } else {
            // Manifest didn't changed. Nothing new to server.
        }
    }, false);
}, false);

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
});               