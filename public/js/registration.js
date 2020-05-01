$(document).ready(function(){

    $(document).on("click", "#pwShow", function(e){
        
        var checked = $(e.target).prop("checked");
        var x = $("#password");

        if (checked == true) {
            x.prop("type", "text");
        } else {
            x.prop("type", "password");
        }
    });

    $(document).on("click", ".preferenceSelector", function(e){
        var preference = {
            genre_id: $(e.target).data("genre")
        }

        var jsonValue = $("#preference").val();
        var value = jsonValue == "" ? [] : JSON.parse(jsonValue);

        if($(e.target).hasClass("selected")){
            value = removeSelectedItem(preference, value, e);
        }else{
            value.push(preference);

            $(e.target).addClass("selected");
        }

        jsonValue = JSON.stringify(value);
        $("#preference").val(jsonValue);
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