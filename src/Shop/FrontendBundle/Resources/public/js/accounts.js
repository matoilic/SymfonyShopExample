;(function($) {
    var $form;

    function onFormSubmit(event) {
        var data;
        event.preventDefault();

        $form = $(this);
        $('#shop_commonbundle_customertype_address_firstName').val($('#shop_commonbundle_customertype_firstName').val());
        $('#shop_commonbundle_customertype_address_lastName').val($('#shop_commonbundle_customertype_lastName').val());
        data = $form.serialize();
        $c.disableForm($form);
        $c.showLoading();
        $.post($form.attr('action'), data, onResponse, 'json');
    }

    function onResponse(data) {
        if(data.success) {
            location.href = data.redirect;
        } else {
            $c.hideLoading();
            $c.enableForm($form);
            humane.error(data.message);
        }
    }


    $(document).on('submit', 'form[name="account"]', onFormSubmit);
})(jQuery);