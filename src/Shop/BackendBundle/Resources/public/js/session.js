;(function($) {
    function onFormSubmit(event) {
        event.preventDefault();
        var $target = $(this);

        $c.showLoading();
        $.post($target.attr('action'), $target.serialize(), onResponse, 'json');
    }

    function onResponse(data) {
        if(data.success) {
            location.href = data.redirect;
            return;
        }

        $c.hideLoading();
        humane.error(data.message);
    }

    $(document).on('submit', 'form[name="login"]', onFormSubmit);
})(jQuery);