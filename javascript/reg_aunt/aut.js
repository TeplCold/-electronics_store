$("#button-auth").click(function () { //если нажата кнопка
    var auth_login = $("#auth_login").val(); //помещаем auth_login в переменную
    var auth_pass = $("#auth_pass").val(); //помещаем auth_pass в переменную

    if (auth_login.length < 5 || auth_login.length > 15) { //если поле пустое или >15
        $("#auth_login").css("borderColor", "#DF0101"); //красим рамку в красный цвет 
        send_login = 'no'; //помещаем no в send_login
    } else { //если все нормально
        $("#auth_login").css("borderColor", "#82FA58"); //красим рамку в стандарнтый цвет
        send_login = 'yes'; //помещаем yes в send_login
    }

    if (auth_pass.length < 7 || auth_pass.length > 20) { //если поле пустое или >20
        $("#auth_pass").css("borderColor", "#DF0101"); //красим рамку в красный цвет 
        send_pass = 'no'; //помещаем no в send_pass
    } else { //если все нормально
        $("#auth_pass").css("borderColor", "#82FA58"); //красим рамку в стандарнтый цвет
        send_pass = 'yes'; //помещаем yes в send_pass
    }

    if ($("#rememberme").prop('checked')) { //.prop проверить состояние checked
        auth_rememberme = 'yes'; //если нажал помещаем yes в auth_rememberme
    } else { //если не нажат 
        auth_rememberme = 'no'; //помещаем no в auth_rememberme 
    }

    if (send_login == 'yes' && send_pass == 'yes') { //если все введено корректно то
        $("#button-auth").hide(); //убрать кнопку
        $(".auth-loading").show(); //загрузчик показать

        $.ajax({ //отправляем данные обработчику 
            type: "POST", //каким методом будем обрабатывать занчения 
            url: "../../pages/reg_aunt/auth.php", //к какому обработчику отправляем данные 
            data: "login=" + auth_login + "&pass=" + auth_pass + "&rememberme=" + auth_rememberme, //указываем какие данные будем отправлять
            dataType: "html", //тип данных 
            cache: false, //чтобы не кэшировать данные 
            success: function (data) { //data - то что ответил обработчик 

                if (data == 'yes_auth') { //если ответил yes_auth - авторизирован
                    location.reload() //обновить страницу 
                } else { //если не авторизирован
                    $("#message-auth").slideDown(400); //показать сообщение
                    $(".auth-loading").hide(); //убрать загрузчик 
                    $("#button-auth").show(); //убрать кнопку
                }
            }
        });
    }
});