$('#button-send-review').click(function () {

    var star = document.querySelector('input[name = rating]:checked').value;
    var name = $("#name_review").val();
    var good = $("#good_review").val();
    var bad = $("#bad_review").val();
    var comment = $("#comment_review").val();
    var iid = $("#button-send-review").attr("iid");

    if (star != "") {
        star_review = '1';
    } else {
        star_review = '0';
    }

    if (name != "") {
        name_review = '1';
        $("#name_review").css("borderColor", "#DBDBDB");
    } else {
        name_review = '0';
        $("#name_review").css("borderColor", "#FDB6B6");
    }

    if (good != "") {
        good_review = '1';
        $("#good_review").css("borderColor", "#DBDBDB");
    } else {
        good_review = '0';
        $("#good_review").css("borderColor", "#FDB6B6");
    }

    if (bad != "") {
        bad_review = '1';
        $("#bad_review").css("borderColor", "#DBDBDB");
    } else {
        bad_review = '0';
        $("#bad_review").css("borderColor", "#FDB6B6");
    }

    if (comment != "") {
        comment_review = '1';
        $("#comment_review").css("borderColor", "#DBDBDB");
    } else {
        comment_review = '0';
        $("#comment_review").css("borderColor", "#FDB6B6");
    }

    // глобальная проверка и отправка отзыва
    if (star_review == '1' && name_review == '1' && good_review == '1' && bad_review == '1' && comment_review == '1') {
        $("#button-send-review").hide();
        $("#reload-img").show();

        $.ajax({
            type: "POST",
            url: "../pages/add_review.php",
            data: "id=" + iid + "&name=" + name + "&star=" + star + "&good=" + good + "&bad=" + bad + "&comment=" + comment,
            dataType: "html",
            cache: false,
            success: function (data) {
                if (data == true) {
                    $(".modal").fadeOut(1000);
                    location.reload();

                }
            }
        });
    }
});