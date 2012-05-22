;(function($) {
    var $doc = $(document);

    function onLoginResponse(data) {
        if(data.success) {
            //TODO
            //$.get(data.profileUrl, {}, onProfileResponse, 'json');
            location.href = data.redirect;
        } else {
            var $form = $('form[name="login"]');
            $c.enableForm($form);
            $c.hideLoading();
            humane.error(data.message);
        }
    }

    function onLoginSubmit(event) {
        event.preventDefault();
        var $form = $(this), data;
        data = $form.serialize();

        $c.showLoading();
        $c.disableForm($form);
        $.post($form.attr('action'), data, onLoginResponse, 'json');
    }

    function onLogoutClick(event) {
        event.preventDefault();
        var $target = $(this);

        $.get($target.attr('href'), {}, onLogoutResponse, 'json');
    }

    function onProfileResponse(data) {
        $('#login').html(data.profile);
        $('#meta').find('.login').hide().end().find('.account').show();
        $p.hideLoading();
    }

    $doc.on('click', '#logout', onLogoutClick);
    $doc.on('submit', 'form[name="login"]', onLoginSubmit);
})(jQuery);