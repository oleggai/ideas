/**
 * Created by олег on 18.08.14.
 */

var url = "/ideas/";

$(document).ready(function() {

    $("#cancel").bind("click", function() {
        cancel();
    });

    $("body").css("overflow", "hidden");
    $("#opacity, #popup").css("display", "block");
    next1();
});

function next1() {
    var coords_first = $("#list a").eq(0).offset();

    $("#popup").offset({top: coords_first.top - 15, left:coords_first.left + $("#list a").eq(0).width() + 30});
    $("#left_vertical_menu").css("position", "absolute");
    $("#list li").eq(0).addClass("z_index");

    //$("#text p").html();

    $("#next").unbind();
    $("#next").bind("click", function() {
        next2();
    })
}

function next2() {

    $("#list li").eq(0).removeClass("z_index");
    $("#list a").eq(0).removeClass("menu-active");
    $("#list a").eq(1).addClass("menu-active");
    var coords_first = $("#list a").eq(1).offset();
    $("#popup").offset({top: coords_first.top - 15 , left:coords_first.left + $("#list a").eq(1).width() + 30});

    $("#left_vertical_menu").css("position", "absolute");
    $("#list li").eq(1).addClass("z_index");

    $("#text p").html(message.message2);
    $("#num_step span").html(num_step.step2);

    $("#next").unbind();
    $("#next").bind("click", function() {
        next3();
    })

}

function next3() {

    $("#list li").eq(1).removeClass("z_index");
    $("#list a").eq(1).removeClass("menu-active");
    $("#list a").eq(2).addClass("menu-active");
    var coords_first = $("#list a").eq(2).offset();
    $("#popup").offset({top: coords_first.top - 15 , left:coords_first.left + $("#list a").eq(2).width() + 30});

    $("#left_vertical_menu").css("position", "absolute");
    $("#list li").eq(2).addClass("z_index");

    $("#text p").html(message.message3);
    $("#num_step span").html(num_step.step3);

    $("#next").unbind();
    $("#next").bind("click", function() {
        next4();
    })
}

function next4() {

    $("#list li").eq(2).removeClass("z_index");
    $("#list a").eq(2).removeClass("menu-active");
    var coords_first = $("#hor_menu").offset();
    $("#popup").offset({top: coords_first.top + 90, left:coords_first.left + 90});

    $("#popup").addClass("popup");

    $("#left_vertical_menu").css("position", "fixed");
    $("#header").css("position", "absolute");

    $("#hor_menu").css("position", "absolute");
    $("#hor_menu").addClass("z_index");

    $("#text p").html(message.message4);
    $("#num_step span").html(num_step.step4);

    $("#next").unbind();
    $("#next").bind("click", function() {
        next5();
    })
}

function next5() {
    $("#header").css("position", "absolute");

    $("#tool").css("position", "relative");
    $("#hor_menu").removeClass("z_index");

    var coords_first = $("#tool div:first-child").offset();
    $("#popup").offset({top: coords_first.top + 60, left:coords_first.left - 260});

    $("#popup").addClass("popup_tool1");

    $("#tool div:first-child").addClass("z_index");

    $("#tool").css({
        "height": "100%",
        "top": 0
    });
    $("#tool div").css({
        "height": "100%",
        "top": 0,
        "position": "relative"
    });
    $("#tool i:first-child").css({
        "top": "50%",
        "left": "30%",
        "position": "absolute"
    });
    $("#tool i:last-child").css({
        "top": "50%",
        "right": "30%",
        "position": "absolute"
    });

    $("#text p").html(message.message5);
    $("#num_step span").html(num_step.step5);

    $("#next").unbind();
    $("#next").bind("click", function() {
        next6();
    })
}

function next6() {
    $("#popup").addClass("popup_tool2");
    $("#tool div:first-child").removeClass("z_index");
    $("#tool div:last-child").addClass("z_index");

    $("#text p").html(message.message6);
    $("#num_step span").html(num_step.step6);

    $("#next").unbind();
    $("#next").bind("click", function() {
        next7();
    })
}

function next7() {
    $("#tool div:last-child").removeClass("z_index");
    var coords_first = $("#button").offset();
    $("#popup").offset({top: coords_first.top - 195, left:coords_first.left - 175});

    $("#popup").addClass("popup_tool3");
    $("#button").addClass("z_index");

    $("#text p").html(message.message7);
    $("#num_step span").html(num_step.step7);

    $("#next").bind("click", function() {
        cancel();
    })
}

function resetStyleTool() {

    $("#tool").css({
        "top": 0
    });
    $("#tool div").css({
        "height": "50%",
        "top": "47%",
        "position": "relative"
    });
    $("#tool i:first-child").css({
        "top": 0,
        "left": 0,
        "position": "relative"
    });
    $("#tool i:last-child").css({
        "top": 0,
        "right": 0,
        "position": "relative"
    });
}

function cancel() {
    $("#opacity").css("display", "none");
    $("#popup").css("display", "none");

    $("#hor_menu").css("position", "relative");
    $("#left_vertical_menu").css("position", "fixed");
    $("#header").css("position", "fixed");
    $("#header").css("z-index", "4000");

    $("#hor_menu").removeClass("z_index");

    $("#header").css("z-index", "4001");
    $("body").css("overflow", "auto");
    resetStyleTool();
}
