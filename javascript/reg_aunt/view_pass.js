$('#button-pass-show-hide').click(function () {
    var statuspass = $('#button-pass-show-hide').attr("class"); //помещаем #button-pass-show-hide в переменную 

    if (statuspass == "pass-show") //проверка в каком статусе пароль 
    {
        $('#button-pass-show-hide').attr("class", "pass-hide"); //открывание пароля 

        var $input = $("#auth_pass");
        var change = "text";
        var rep = $("<input placeholder='Пароль' type='" + change + "' />")
            .attr("id", $input.attr("id"))
            .attr("name", $input.attr("name"))
            .attr('class', $input.attr('class'))
            .val($input.val())
            .insertBefore($input);
        $input.remove();
        $input = rep;
    } else {
        $('#button-pass-show-hide').attr("class", "pass-show"); //закрываение паролья 
        var $input = $("#auth_pass");
        var change = "password";
        var rep = $("<input placeholder='Пароль' type='" + change + "' />")
            .attr("id", $input.attr("id"))
            .attr("name", $input.attr("name"))
            .attr('class', $input.attr('class'))
            .val($input.val())
            .insertBefore($input);
        $input.remove();
        $input = rep;
    }
});


$("#button-auth").click(function () { //если нажата кнопка

    var auth_login = $("#auth_login").val(); //помещаем auth_login в переменную
    var auth_pass = $("#auth_pass").val(); //помещаем auth_pass в переменную


    if (auth_login == "" || auth_login.length > 15) {
        $("#auth_login").css("borderColor", "#DF0101");
        send_login = 'no';
    } else {
        $("#auth_login").css("borderColor", "#82FA58");
        send_login = 'yes';
    }


    if (auth_pass == "" || auth_pass.length > 20) {
        $("#auth_pass").css("borderColor", "#DF0101");
        send_pass = 'no';
    } else {
        $("#auth_pass").css("borderColor", "#82FA58");
        send_pass = 'yes';
    }



    if ($("#rememberme").prop('checked')) { //.prop проверить состояние checked
        auth_rememberme = 'yes';
    } else {
        auth_rememberme = 'no';
    }


    if (send_login == 'yes' && send_pass == 'yes') {
        $("#button-auth").hide(); //убрать кнопку
        $(".auth-loading").show(); //загрузчик показать

        $.ajax({ //отправляем данные обработчику 
            type: "POST", //каким методом будем обрабатывать занчения 
            url: "../../pages/reg_aunt/auth.php", //к какому обработчику отправляем данные 
            data: "login=" + auth_login + "&pass=" + auth_pass + "&rememberme=" + auth_rememberme, //указываем какие данные будем отправлять
            dataType: "html", //тип данных 
            cache: false, //чтобы не кэшировать данные 
            success: function (data) { //data - то что ответил обработчик 

                if (data == 'yes_auth') {
                    location.reload();
                } else {
                    $("#message-auth").slideDown(400);
                    $(".auth-loading").hide();
                    $("#button-auth").show();

                }
            }
        });
    }
});

//скрыть показать востановление пароля 
$('#remindpass').click(function () {
    $('#block-remind').fadeIn(300);
});


$('#prev-auth').click(function () {
    $('#block-remind').fadeOut(200);
});

//забыл пароль
$('#button-remind').click(function () {

    var recall_email = $("#remind-email").val();

    if (recall_email == "" || recall_email.length > 100) {
        $("#remind-email").css("borderColor", "#FDB6B6");

    } else {
        $("#remind-email").css("borderColor", "#DBDBDB");

        $("#button-remind").hide();
        $(".auth-loading").show();

        $.ajax({
            type: "POST",
            url: "../../pages/reg_aunt/remind-pass.php",
            data: "email=" + recall_email,
            dataType: "html",
            cache: false,
            success: function (data) {

                if (data == 'yes') {
                    $(".auth-loading").hide();
                    $("#button-remind").show();
                    $('#message-remind').attr("class", "message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);

                    setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 3000);

                } else {
                    $(".auth-loading").hide();
                    $("#button-remind").show();
                    $('#message-remind').attr("class", "message-remind-error").html(data).slideDown(400);

                }
            }
        });
    }
});