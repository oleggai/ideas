/**
 * Created by олег on 22.08.14.
 */

$(document).ready(function() {
    $(document).keypress(function(e) {
        if(e.keyCode == 13) {
            $(".send:focus").trigger("tap");
        }
    });
});