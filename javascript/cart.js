loadcart();

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
// проверка данных при оформлении заказа
$('#confirm-button-next').click(function (e) { //нажатие кнопки далее

    var send_order_delivery;
    var send_order_fio;
    var send_order_name;
    var send_order_patronymic;
    var send_order_email;
    var send_order_phone;
    var send_order_address;
    var order_fio = $("#order_fio").val();
    var order_name = $("#order_name").val();
    var order_patronymic = $("#order_patronymic").val();
    var order_email = $("#order_email").val();
    var order_phone = $("#order_phone").val();
    var order_address = $("#order_address").val();

    if (!$(".order_delivery").is(":checked")) { // выбран ли способ доставки не выбран
        $(".label_delivery").css("color", "#E07B7B"); //делаем шрифт красным
        send_order_delivery = '0'; //переменная для определения допущена ли ошибка

    } else { //если же выбран
        $(".label_delivery").css("color", "black"); //делаем шрифт черной
        send_order_delivery = '1'; //переменная для определения не допущена ли ошибка


        // проверка фамилии
        if (order_fio == 3 || order_fio.length > 20) {
            $("#order_fio").css("borderColor", "#FDB6B6"); //делаем рамку красным
            send_order_fio = '0'; //переменная для определения допущена ли ошибка

        } else {
            $("#order_fio").css("borderColor", "#DBDBDB"); //делаем рамку черной
            send_order_fio = '1'; //переменная для определения не допущена ли ошибка
        }

        // проверка имени
        if (order_name == 3 || order_name.length > 15) {
            $("#order_name").css("borderColor", "#FDB6B6"); //делаем рамку красным
            send_order_name = '0'; //переменная для определения допущена ли ошибка

        } else {
            $("#order_name").css("borderColor", "#DBDBDB"); //делаем рамку черной
            send_order_name = '1'; //переменная для определения не допущена ли ошибка
        }

        // проверка отчества
        if (order_patronymic == 6 || order_patronymic.length > 25) {
            $("#order_patronymic").css("borderColor", "#FDB6B6"); //делаем рамку красным
            send_order_patronymic = '0'; //переменная для определения допущена ли ошибка

        } else {
            $("#order_patronymic").css("borderColor", "#DBDBDB"); //делаем рамку черной
            send_order_patronymic = '1'; //переменная для определения не допущена ли ошибка
        }

        //проверка email
        if (isValidEmailAddress(order_email) == false) {
            $("#order_email").css("borderColor", "#FDB6B6"); //делаем рамку красным
            send_order_email = '0'; //переменная для определения допущена ли ошибка
        } else {
            $("#order_email").css("borderColor", "#DBDBDB"); //делаем рамку черной
            send_order_email = '1'; //переменная для определения не допущена ли ошибка
        }

        // проверка номера
        if (order_phone == "" || order_phone.length > 12) {
            $("#order_phone").css("borderColor", "#FDB6B6"); //делаем рамку красным
            send_order_phone = '0'; //переменная для определения допущена ли ошибка
        } else {
            $("#order_phone").css("borderColor", "#DBDBDB"); //делаем рамку черной
            send_order_phone = '1'; //переменная для определения не допущена ли ошибка
        }

        // проверка адреса
        if (order_address == "" || order_address.length > 150) {
            $("#order_address").css("borderColor", "#FDB6B6"); //делаем рамку красным
            send_order_address = '0'; //переменная для определения допущена ли ошибка
        } else {
            $("#order_address").css("borderColor", "#DBDBDB"); //делаем рамку черной
            send_order_address = '1'; //переменная для определения не допущена ли ошибка
        }

    }
    // глобальная проверка поиск 0 если нет 
    if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1") {
        return true; //отправляем форму
    }
    e.preventDefault();
});

$(document).on('click', '.add-card', function () {

    var tid = $(this).attr("tid");

    $.ajax({
        type: "POST",
        url: "../pages/addtocart.php",
        data: "id=" + tid,
        dataType: "html",
        cache: false,
        success: function (data) {
            loadcart();
        }
    });

});

function loadcart() {
    $.ajax({
        type: "POST",
        url: "../pages/loadcart.php",
        dataType: "html",
        dataType: 'json',
        cache: false,
        success: function (data) {

            if (data == "0") {

                $("#block-basket > a").html("Корзина пуста");
                $("#block-basket_header_count > a").html("");
                $("#block-basket_header_prise > a").html("");
            } else {
                $("#block-basket > a").html(data.result1);
                $("#block-basket_header_count > a").html(data.result2);
                $("#block-basket_header_prise > a").html(data.result3);
            }
        }
    });
}

function fun_group_price(intprice) {
    var result_total = String(intprice);
    var lenstr = result_total.length;

    switch (lenstr) {
        case 4: {
            groupprice = result_total.substring(0, 1) + " " + result_total.substring(1, 4);
            break;
        }
        case 5: {
            groupprice = result_total.substring(0, 2) + " " + result_total.substring(2, 5);
            break;
        }
        case 6: {
            groupprice = result_total.substring(0, 3) + " " + result_total.substring(3, 6);
            break;
        }
        case 7: {
            groupprice = result_total.substring(0, 1) + " " + result_total.substring(1, 4) + " " + result_total.substring(4, 7);
            break;
        }
        default: {
            groupprice = result_total;
        }
    }
    return groupprice;
}