/**
 * Created by олег on 19.08.14.
 */


$(document).ready(function() {
    search_flag = 2;
    //var coords_search = {};
    //set_coords_search = true;
    $("#i_search").bind("click", function() {
        /*
        coords_search = $(this).offset();
        if(set_coords_search) {

            //$("#search").offset({top: coords_search.top + 30, left: coords_search.left - 180});
           // set_coords_search = false;
        }*/
        if(search_flag % 2 == 0) {
            $("#search").css("display", "inline-block");
            search_flag++;
        }
        else {
            $("#search").css("display", "none");
            search_flag++;
        }
    });

    $("#search_button").bind("click", function() {
        var value = $("#search_text").val();
        search(value);
    });

    $("#search_text").focus(function() {

        $(this).keyup(function() {
           // alert($(this).val());
            if($(this).val() == "") {
                $(".discussion_product").css("display", "inline-block");
                return;
            }
        });
    });
    /*$("#search_text").blur(function() {
        search($(this).val());
    });
    */

    $("#search_cancel").bind("click", function() {
        search_flag = 2;
        $("#search").css("display", "none");
    });

});

function search(value) {
    var value = $.trim(value);
    var name_discussion = null;
    var description     = null;

    if(value == "") {
        $(".discussion_product").css("display", "inline-block");
        return;
    }
    $(".discussion_product").css("display", "inline-block");

    $.each($(".discussion_product"), function(index, elem) {
        name_discussion = $(".name_discussion span", $(elem)).html();
        description = $(".description p", $(elem)).html();
        //alert(name_discussion);
       //alert(description);
        if((name_discussion.indexOf(value) == -1) && (description.indexOf(value) == -1)) {
            $(elem).css("display", "none");
        }
    });

}