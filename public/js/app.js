$(document).ready(function(){
    var documentHeight = $(document).height();
    console.log("documentHeight " + documentHeight);
    var navbarHeight = $('.navbar').outerHeight();
    console.log("navbarHeight " + navbarHeight);
    var bodyheight = documentHeight - navbarHeight;
    console.log("bodyheight " + bodyheight);

    $('main .container').css("min-height", bodyheight);
});