$(document).ready(function () {
  //Подключение к плагину (указываем какую форму нужно проверять)
  $("#form_reg").validate({
    //правила для проверки
    rules: {
      reg_login: {
        //id поля
        required: true, //проверка не пустое ли поле
        rangelength: [5, 15], //проверка мин. макс. длины
        remote: {
          //проверка логина
          type: "post",
          url: "../../pages/reg_aunt/check_login.php"
        }
      },
      reg_pass: {
        required: true,
        rangelength: [7, 20]
      },
      reg_surname: {
        required: true,
        rangelength: [3, 20]
      },
      reg_name: {
        required: true,
        rangelength: [3, 15]
      },
      reg_patronymic: {
        required: true,
        rangelength: [3, 25]
      },
      reg_email: {
        required: true,
        email: true,
        remote: {
          //проверка email
          type: "post",
          url: "../../pages/reg_aunt/check_email.php"
        }
      }
    },

    //выводимые сообщения при нарушении соответствующих правил
    messages: {
      reg_login: {
        required: "Укажите логин!",
        rangelength: "От 5 до 15 символов!",
        remote: "Логин занят!"
      },
      reg_pass: {
        required: "Укажите пароль!",
        rangelength: "От 7 до 20 символов!"
      },
      reg_surname: {
        required: "Укажите фамилию!",
        rangelength: "От 3 до 20 символов!"
      },
      reg_name: {
        required: "Укажите имя!",
        rangelength: "От 3 до 15 символов!"
      },
      reg_patronymic: {
        required: "Укажите отчество!",
        rangelength: "От 3 до 25 символов!"
      },
      reg_email: {
        required: "Укажите свой E-mail",
        email: "Не корректный E-mail",
        remote: " Пользователь с таким E-mail уже существует!"
      }
    },
    submitHandler: function (form) {
      $(form).ajaxSubmit({
        success: function (data) {
          if (data == "true") {
            $("#reg_message")
              .addClass("reg_message_good")
              .fadeIn(400).val('').change()
              .html("Вы успешно зарегистрированы!");
            $('#form_reg')[0].reset();
          } else {
            $("#reg_message")
              .addClass("reg_message_error")
              .fadeIn(400)
              .html(data);
          }
        }
      });
    }
  });
});