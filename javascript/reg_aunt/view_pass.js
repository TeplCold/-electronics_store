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