// Initialize your app
var myApp = new Framework7();

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
view2.router.loadPage('userinfo.html');
    // Load about page:
view3.router.loadPage('scene.html');
    // Load about page:
view4.router.loadPage('help.html');