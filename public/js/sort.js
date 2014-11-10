/**
 * Created by олег on 05.08.14.
 */

    var url = "/ideas/";

// Массив елементов с соответствующим атрибутом
var mass_elem = [];

// Массив массивов
var mass_for_sort = [];
var index = null;
var value = null;

var elem_discussion = null;
var flag_sort = false;
var elem_click = null;

$(document).ready(function() {

    $("#sort_time").bind("click", function() {
        //alert("sort_time");
        elem_click = $(this);
        sortTime();
    });

    $("#sort_star").bind("click", function() {
        //alert("sort_star");
        elem_click = $(this);
        sortStar();
    });

    $("#sort_comment").bind("click", function() {
        //alert("sort_comment");
        elem_click = $(this);
        sortComment();
    });
});

function sortTime() {

    // Делаем массив пустым
    mass_for_sort = [];
    mass_elem = $("[data-time-create-discussion]");

    $.each(mass_elem, function(i, elem) {
        index = $(elem).attr("data-time-create-discussion");
        //alert(index);
        value = $(elem).closest("[data-id-discussion]").attr("data-id-discussion");
        //alert(value);
        // Добавили в конец массива
        mass_for_sort.push([index, value]);
    });
    /*
    alert(mass_for_sort[0][0]);
    alert(mass_for_sort[1][0]);
    alert(mass_for_sort[2][0]);
    */
    sortClickHover();
    sortable();
}

function sortStar() {

    // Делаем массив пустым
    mass_for_sort = [];
    mass_elem = $("[data-star-discussion]");

    $.each(mass_elem, function(i, elem) {
        index = $(elem).attr("data-star-discussion");
        //alert(index);
        value = $(elem).closest("[data-id-discussion]").attr("data-id-discussion");
        //alert(value);
        // Добавили в конец массива
        mass_for_sort.push([index, value]);
    });

    /*
     alert(mass_for_sort[0][0]);
     alert(mass_for_sort[1][0]);
     alert(mass_for_sort[2][0]);
     */
    sortClickHover();
    sortable();
}

function sortComment() {

    // Делаем массив пустым
    mass_for_sort = [];
    mass_elem = $("[data-count-comment]");

    $.each(mass_elem, function(i, elem) {
        index = $(elem).attr("data-count-comment");
        //alert(index);
        value = $(elem).closest("[data-id-discussion]").attr("data-id-discussion");
        //alert(value);
        // Добавили в конец массива
        mass_for_sort.push([index, value]);
    });
    sortClickHover();
    sortable();
}


// Сортировка по соответствующему атрибуту
function sortable() {

    if(flag_sort) {
        mass_for_sort.sort(kSort);
        if($(".chevron", elem_click).hasClass("up_sort")) {
            $(".chevron", elem_click).removeClass("up_sort");
            $(".chevron", elem_click).addClass("down_sort");
        }
        flag_sort = false;
    }
    else {
        mass_for_sort.sort(krSort);
        if($(".chevron", elem_click).hasClass("down_sort")) {
            $(".chevron", elem_click).removeClass("down_sort");
            $(".chevron", elem_click).addClass("up_sort");
        }
        flag_sort = true;
    }
    $.each(mass_for_sort, function(index, value) {
        elem_discussion = $("[data-id-discussion = "+ value[1] +"]");
        $("#div_discussion").prepend($(elem_discussion).detach());
    });
}


// Сотрировка по возростанию
function kSort(a, b) {
    var a1 = a[0];
    var b1 = b[0];
    return a1 - b1;
}

// Сортировка по убыванию
function krSort(a, b) {
    var a1 = a[0];
    var b1 = b[0];
    return b1 - a1;
}

function sortClickHover() {
    $.each($(".div_border_sort"), function(index, elem) {
        $(elem).css({
            "backgroundImage": "url('"+ url +"public/img/background.png')",
            "backgroundRepeat": "repeat-x repeat-y"
        });
    });
    $(".div_border_sort", elem_click).css({
        "backgroundImage": "url('"+ url +"public/img/hover_menu.png')",
        "backgroundRepeat": "repeat-x repeat-y"
    });
}
