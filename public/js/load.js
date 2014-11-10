/**
 * Created by олег on 20.08.14.
 */

var url = "/ideas/";
var old_time = null;
var new_time = null;
$(document).ready(function() {
    old_time = new Date();
    old_time = old_time.getTime()/1000;
    setInterval(function() {
        new_time = new Date();
        //alert(time.getTime());
        new_time = new_time.getTime()/1000;
        loadNewTopics(old_time);
        loadNewComments((old_time));
        old_time = new_time;
    }, 5000);
});

function loadNewTopics(time) {
    $.ajax({
        dataType: "json",
        url: url + "ajax/loadNewTopics",
        type: "POST",
        data: {
            "time": time
        },
        success: function(responce) {
           $.each(responce, function(index, value) {
                //alert(value);

               $("#load_ajax ").css("display", "inline-block");
               $("#load_ajax").append('' +
                   '<a href="'+ value +'">' +
                   '<div class="load_div">' +
                   '<p>New Topic</p>' +
                   '</div>' +
                   '</a>');
            });
        }
    });
}

function loadNewComments(time) {
    $.ajax({
        dataType: "json",
        url: url + "ajax/loadNewComments",
        type: "POST",
        data: {
            "time": time
        },
        success: function(responce) {
            $.each(responce, function(index, value) {

                $("#load_ajax ").css("display", "inline-block");
                $("#load_ajax").append('' +
                    '<a href="'+ value +'">' +
                        '<div class="load_div">' +
                             '<p>New Comment</p>' +
                        '</div>' +
                    '</a>');
            });
        }
    });
}