

$(document).on('mousemove', ".starRating", function(e) {

    var objId = "#" + $(e.currentTarget).attr("id");
    var number = $(objId).data('number');
    
    resetStarRating(number);
    var right = GetStarSide(objId, e);

    $(objId).empty();
    if (right == false) {
        $(objId).append('<i class="fas fa-star-half-alt rating-star"></i>');
    } else {
        $(objId).append('<i class="fas fa-star rating-star"></i>');
    }
}).on('mouseout', ".starRating", function(e){
    var starRating = $("#starRating").val();
    var fullStars = Math.floor(starRating / 2);
    var halveStars = starRating - (fullStars * 2);
    var remainingStars = 5 - (fullStars + halveStars);

    $("div.starRating").empty();

    for( var x = 1; x <= fullStars; x++ ){
        $("#starRating" + x).append('<i class="fas fa-star rating-star"></i>')
    }

    for( var x = (fullStars + 1); x <= (fullStars + halveStars); x++ ){
        $("#starRating" + x).append('<i class="fas fa-star-half-alt rating-star"></i>')
    }

    for( var x = (fullStars + halveStars + 1); x <= 5; x++ ){
        $("#starRating" + x).append('<i class="far fa-star rating-star"></i>')
    }

}).on("click", ".starRating", function(e){
    var objId = "#" + $(e.currentTarget).attr("id");
    var fullStars = ($(objId).data('number') - 1) *2;

    var right = GetStarSide(objId, e);
    if (right == false) {
        $("#starRating").val(fullStars + 1);
    } else {
        $("#starRating").val(fullStars + 2);
    }
});

function GetStarSide(objId, e){

    // example use
    var div = document.querySelector(objId);
    var divOffset = offset(div);
    
    var leftOfPage = (e.pageX - divOffset.left);
    var half = $(objId).width() / 2;



    if (leftOfPage < half) {
        return false;
    } else {
        return true;
    }
}

function resetStarRating(number){
    for(var i = 1; i < number; i++){
        $("#starRating" + i).empty();
        $("#starRating" + i).append('<i class="fas fa-star rating-star"></i>');
    }
    
    for(var i = 5; i > number; i--){
        $("#starRating" + i).empty();
        $("#starRating" + i).append('<i class="far fa-star rating-star"></i>');
    }
}

function offset(el) {
    var rect = el.getBoundingClientRect(),
    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    return { left: rect.left + scrollLeft }
}
