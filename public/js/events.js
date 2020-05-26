

$(document).ready(function(){
    var active_filter = 0;
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", "#sort", function(){
        //alert("test1");
        var sort_val = $("#sort_item option:selected").val();
        var sort_dir = $("#sort_dir option:selected").val();
        var genre = active_filter;
        console.log("val: " + sort_val);
        console.log("dir: " + sort_dir);
        //*
        $.ajax({
            type: "POST",
            url: "/Events/sorting",
            data: {
                order_item: sort_val,
                order_dir: sort_dir,
                genre: genre
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Request: " + XMLHttpRequest.toString() + "\n\nStatus: " + textStatus + "\n\nError: " + errorThrown);
            },
            success: function (result) {
                BuildNewScreen(result);
            }
        });
        //*/
    });

    $(document).on("click", "#filter", function(){
        //alert("test2");
        var genre = $("#filter_item option:selected").val();
        
        $.ajax({
            type: "POST",
            url: "/Events/filter",
            data: {
                "genre": genre
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Request: " + XMLHttpRequest.toString() + "\n\nStatus: " + textStatus + "\n\nError: " + errorThrown);
            },
            success: function (result) {
                active_filter = genre;
                BuildNewScreen(result);
            }
        });
    });

    $(document).on("click", "#search", function(){
        var search_val = $("#SearchBar").val();
        if(search_val != ""){
            $.ajax({
                type: "POST",
                url: "/Events/search",
                data: {
                    "name": search_val,
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Request: " + XMLHttpRequest.toString() + "\n\nStatus: " + textStatus + "\n\nError: " + errorThrown);
                },
                success: function (result) {
                    BuildNewScreen(result);
                }
            });
        }else{
            ResetFilters();
        }
    });

    function BuildNewScreen(data){
        var html = "";

        $.each(JSON.parse(data), function(key, val){
            html += '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">'
            html += '<a href="Event/' + val.id + '" class="card">'
            html += '<div class="card-header">'

            var poster = JSON.parse(val.poster);

            html += '<img src="' + imageDirectory + '/' + poster.name + '" alt="">'
            html += '</div><div class="card-footer">'
            html += '<h3>' + val.name + '</h3>'
            html += '<p>'

            $.each(val.genre, function(subkey, eventGenre){
                html += '<div class="genre-tag">' + eventGenre.genre.name + '</div>'
            });
            
            html += '</p></div></a></div>'
        });
        
        $("#event_container").html(html);
    }
    
    function ResetFilters(){
        $.ajax({
            type: "GET",
            url: "/Events/reset",
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Request: " + XMLHttpRequest.toString() + "\n\nStatus: " + textStatus + "\n\nError: " + errorThrown);
            },
            success: function (result) {
                BuildNewScreen(result);
            }
        });
    }
});

