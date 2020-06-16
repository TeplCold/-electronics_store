$(document).ready(function () {

    $('.delete').click(function () {

        var rel = $(this).attr("rel");

        $.confirm({
            'message': 'После удаления восстановление будет невозможно!Вы уверенны что хотите удалить этот товар?',
            'buttons': {
                'Да': {
                    'class': 'blue',
                    'action': function () {
                        location.href = rel;
                    }
                },
                'Нет': {
                    'class': 'gray',
                    'action': function () {}
                }
            }
        });

    });


    $('.delete2').click(function () {

        var rel = $(this).attr("rel");

        $.confirm({
            'message': 'После удаления восстановление будет невозможно!Вы уверенны что хотите удалить этот отзыв?',
            'buttons': {
                'Да': {
                    'class': 'blue',
                    'action': function () {
                        location.href = rel;
                    }
                },
                'Нет': {
                    'class': 'gray',
                    'action': function () {}
                }
            }
        });
    });


    $('.delete3').click(function () {

        var rel = $(this).attr("rel");

        $.confirm({
            'message': 'После удаления восстановление будет невозможно!Вы уверенны что хотите удалить этого пользователя?',
            'buttons': {
                'Да': {
                    'class': 'blue',
                    'action': function () {
                        location.href = rel;
                    }
                },
                'Нет': {
                    'class': 'gray',
                    'action': function () {}
                }
            }
        });

    });

    $('.delete4').click(function () {

        var rel = $(this).attr("rel");

        $.confirm({
            'message': 'После удаления восстановление будет невозможно!Вы уверенны что хотите удалить этого заказ?',
            'buttons': {
                'Да': {
                    'class': 'blue',
                    'action': function () {
                        location.href = rel;
                    }
                },
                'Нет': {
                    'class': 'gray',
                    'action': function () {}
                }
            }
        });

    });

    var count_input = 1;
    //добавление
    $("#add-input").click(function () {
        count_input++;
        $('<div id="addimage' + count_input + '" class="addimage"><input type="hidden" name="MAX_FILE_SIZE" value="200000000"/><input type="file" name="galleryimg[]" /><a class="delete-input" rel="' + count_input + '" >Удалить</a></div>').fadeIn(300).appendTo('#objects'); //appendTo - вставить в #objects 
    });
    //удаление
    $('.delete-input').live('click', function () {
        var rel = $(this).attr("rel");
        $("#addimage" + rel).fadeOut(300, function () {
            $("#addimage" + rel).remove();
        });

    });

    $('#select-links').click(function () {
        $("#list-links,#list-links-sort").slideToggle(200);
    });


    $('.h3click').click(function () {
        $(this).next().slideToggle(400);
    });


    //удаление картинок из галереи картинок
    $('.del-img').click(function () {
        var img_id = $(this).attr("img_id");
        var title_img = $("#del" + img_id + " > img").attr("title");
        $.ajax({
            type: "POST",
            url: "../admin_control_panel/actions/delete-gallery.php",
            data: "id=" + img_id + "&title=" + title_img,
            dataType: "html",
            cache: false,
            success: function (data) {
                if (data == "delete") {
                    $("#del" + img_id).fadeOut(300);
                }
            }
        });
    });

    $('.delete-cat_category').click(function () {
        var selectid = $("#cat_category option:selected").val();
        if (!selectid) {
            $("#cat_category").css("borderColor", "#F5A4A4");
        } else {
            $.ajax({
                type: "POST",
                url: "actions/delete-category.php",
                data: "id=" + selectid,
                dataType: "html",
                cache: false,
                success: function (data) {
                    if (data == "delete") {
                        $("#cat_category option:selected").remove();
                    }
                }
            });
        }
    });

    $('.delete-cat_brand').click(function () {
        var selectid = $("#cat_brand option:selected").val();
        if (!selectid) {
            $("#cat_brand").css("borderColor", "#F5A4A4");
        } else {
            $.ajax({
                type: "POST",
                url: "actions/delete-brand.php",
                data: "id=" + selectid,
                dataType: "html",
                cache: false,
                success: function (data) {
                    if (data == "delete") {
                        $("#cat_brand option:selected").remove();
                    }
                }
            });
        }
    });

    $('.block-clients').click(function () {

        $(this).find('ul').slideToggle(300);

    });

    $(document).ready(function () {
        $('#form_category').change(function () {
            $.ajax({
                type: "POST",
                url: 'add_product.php',
                data: {
                    "param": $(this).val()
                }
            });

            $('#mydiv').html($(this).val());

        });
    });


});