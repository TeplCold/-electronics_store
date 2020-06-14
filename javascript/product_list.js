$('#select-sort').click(function (e) {
    var $message = $('#sorting-list');

    if ($message.css('display') != 'block') {
        $message.show();

        var firstClick = true;
        $(document).bind('click.myEvent', function (e) {
            if (!firstClick && $(e.target).closest('#sorting-list').length == 0) {
                $message.hide();
                $(document).unbind('click.myEvent');
            }
            firstClick = false;
        });
    }
    e.preventDefault();
});