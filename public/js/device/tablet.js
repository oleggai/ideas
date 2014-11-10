/**
 * Created by олег on 07.08.14.
 */
function tablet() {
    $("#left_vertical_menu").css("display", "inline-block");
    if(!$("#header_menu").find("#hor_menu").length) {
    $("#header_menu").prepend($("#hor_menu").detach());
    }
}

