$(document).ready(function(){
    var documentHeight = $(document).height();
    var navbarHeight = $('.navbar').outerHeight();
    var bodyheight = documentHeight - navbarHeight;

    $('main .container').css("min-height", bodyheight);
});