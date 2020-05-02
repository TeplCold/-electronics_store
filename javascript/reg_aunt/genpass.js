$("#genpass").click(function () {
  $.ajax({
    type: "POST", //метод передачи
    url: "../../pages/reg_aunt/genpass.php", //куда передавать значение
    dataType: "html", //тип данных
    cache: false, //чтобы браузер не кэшировал и не сохранял данные
    success: function (data) {
      //функция проверки что нам ответил обработчик
      $("#reg_pass").val(data); //указывает куда нужно поместить пароль
    }
  });
});