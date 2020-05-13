


$(document).ready(function() {
    
    $(document).on("click", ".genreSelector", function(e){
        var genre = {
            genre_id: $(e.target).data("genre")
        }

        var jsonValue = $("#genre").val();
        var value = jsonValue == "" ? [] : JSON.parse(jsonValue);

        if($(e.target).hasClass("selected")){
            value = removeSelectedItem(genre, value, e);
        }else{
            value.push(genre);

            $(e.target).addClass("selected");
        }

        jsonValue = JSON.stringify(value);
        $("#genre").val(jsonValue);
    });

    function removeSelectedItem(item, arr, e){
        for(var i=0; i<arr.length; i++){
            if(arr[i].genre_id == item.genre_id){
                arr.splice(i,1)
                $(e.target).removeClass("selected");
            }
        }

        return arr;
    }
});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgPlaceholder').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on("change", "#posterImage", function(e){
        var fileName = e.target.files[0].name;
        $("#posterCurrentName").val(fileName);
    });