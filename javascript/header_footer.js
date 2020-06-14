$('#auth-user-info').click(function (e) {
    var $message = $('#block-user');

    if ($message.css('display') != 'block') {
        $message.show();

        var firstClick = true;
        $(document).bind('click.myEvent', function (e) {
            if (!firstClick && $(e.target).closest('#block-user').length == 0) {
                $message.hide();
                $(document).unbind('click.myEvent');
            }
            firstClick = false;
        });
    }
    e.preventDefault();
});

$('#logout').click(function () {
    $.ajax({
        type: "POST",
        url: "../pages/reg_aunt/logout.php",
        dataType: "html",
        cache: false,
        success: function (data) {
            if (data == 'logout') {
                location.reload();
            }
        }
    });
});