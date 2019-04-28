//функция для "липкой" шапки
$(window).scroll(function(){
    var sticky = $('.sticky'),
        scroll = $(window).scrollTop();

    if (scroll >= 145) sticky.addClass('fixed');
    else sticky.removeClass('fixed');
});

//функция для возвращения "наверх"
$(document).ready(function() {
    $().UItoTop({ easingType: 'easeOutQuart' });

});