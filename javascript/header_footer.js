$('#auth-user-info').toggle(
    function () {
        $("#block-user").fadeIn(200);
    },
    function () {
        $("#block-user").fadeOut(200);
    }
);

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