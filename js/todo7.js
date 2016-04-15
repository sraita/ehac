// Initialize your app
var myApp = new Framework7({
    modalTitle: 'ToDo7',
	 animateNavBackIcon:true,
	smartSelectBackOnSelect:true,
	swipeBackPage:true,
	smartSelectSearchbar: true,
	swipeBackPageThreshold:40,
});

// Export selectors engine
var $$ = Dom7;
// Add views
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
$$('.popup .add-task').on('click', function () {
    var title = $$('.popup input[name="title"]').val().trim();
    if (title.length === 0) {
        return;
    }
    var color = $$('.popup .color.selected').attr('data-color');
    todoData.push({
        title: title,
        color: color,
        checked: '',
        id: (new Date()).getTime()
    });
    localStorage.td7Data = JSON.stringify(todoData);
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
$$('.todo-items-list').on('delete', '.swipeout', function () {
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
 
                