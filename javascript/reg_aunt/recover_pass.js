//забыл пароль
$('#button-remind').click(function () {

    var recall_email = $("#remind-email").val();

    if (recall_email == "" || recall_email.length > 100) {
        $("#remind-email").css("borderColor", "#FDB6B6");

    } else {
        $("#remind-email").css("borderColor", "#DBDBDB");

        $("#button-remind").hide();
        $(".a-loading").show();

        $.ajax({
            type: "POST",
            url: "../../pages/reg_aunt/remind-pass.php",
            data: "email=" + recall_email,
            dataType: "html",
            cache: false,
            success: function (data) {

                if (data == 'yes') {
                    $(".a-loading").hide();
                    $("#button-remind").show();
                    $('#message-remind').attr("class", "message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);



                } else {
                    $(".a-loading").hide();
                    $("#button-remind").show();
                    $('#message-remind').attr("class", "message-remind-error").html(data).slideDown(400);

                }
            }
        });
    }
});