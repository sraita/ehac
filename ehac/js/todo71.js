// Initialize your app
var myApp = new Framework7({
    modalTitle: 'ToDo7',
	animateNavBackIcon:true,
	smartSelectBackOnSelect:true,
	swipeBackPage:true,
	smartSelectSearchbar: true,
	swipeBackPageThreshold:40,
	swipePanel: 'right',
	precompileTemplates: true,
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
view2.router.loadPage('userinfo.php');
    // Load about page:
view3.router.loadPage('scene.html');
    // Load about page:
view4.router.loadPage('help.html');

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
 
