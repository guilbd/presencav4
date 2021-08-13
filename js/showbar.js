var sandwich = document.getElementById('sandwich');
var menu = document.getElementById('menu-list');
var page = document.getElementById('page');
var studant = document.getElementById('studant');
var admin = document.getElementById('admin');
studant.addEventListener('click',function(){
    var animatemenu = menu.animate([
        {transform:'translate(230px,0)'},
        {transform:'translate(0px,0)'}
    ],500)
    animatemenu.addEventListener('finish',function(){
        menu.style.transform = 'translate(-230px,0)';
    });
    page.src='pg/home.html';
});
admin.addEventListener('click',function(){
    var animatemenu = menu.animate([
        {transform:'translate(230px,0)'},
        {transform:'translate(0px,0)'}
    ],500)
    animatemenu.addEventListener('finish',function(){
        menu.style.transform = 'translate(-230px,0)';
    });
    page.src='pg/admin.html';
});
sandwich.addEventListener('click',openNav);
function openNav(){
    var animatemenu = menu.animate([
        {transform:'translate(0,0)'},
        {transform:'translate(230px,0)'}
    ],500)
    animatemenu.addEventListener('finish',function(){
        menu.style.transform = 'translate(230px,0)'
    });
}
menu.addEventListener('click',function(){
    var animatemenu = menu.animate([
        {transform:'translate(230px,0)'},
        {transform:'translate(0px,0)'}
    ],500)
    animatemenu.addEventListener('finish',function(){
        menu.style.transform = 'translate(-230px,0)';
    });
    
});
