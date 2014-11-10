/**
 * Created by олег on 06.08.14.
 */
function mobile() {
    $("#left_vertical_menu").css("display", "none");
    if($("#header_menu").find("#hor_menu").length) {
    $("#div_sort_menu_mobile").append($("#hor_menu").detach());
    }
}
$(document).ready(function() {

    $( "#button_menu").bind("tap", function () {
        var effect = 'slide';
        var options = { direction: 'left' };
        var duration = 400;
        $("#left_vertical_menu").toggle(effect, options, duration);
    });
    $( "#button_menu").bind("tap", function () {
        if(toggle%2 == 0) {
            $(this).animate({"left": "+=195"}, 400);
            toggle += 1;
        }
        else {
            $(this).animate({"left": "-=195"}, 400);
            toggle += 1;
        }
    });

});