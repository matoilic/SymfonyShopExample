;(function($) {
    var $doc = $(document);

    function onFormSubmit(event) {
        event.preventDefault();
        var $form = $(this), data;

        if(!$('#shop_frontendbundle_checkouttype_termsAccepted').attr('checked')) {
            humane.error($('#shop_frontendbundle_checkouttype_termsAccepted').attr('title'));
            return;
        }

        data = $form.serialize();

        $c.showLoading();
        $c.disableForm($form);
        $.post($form.attr('action'), data, onResponse, 'json');
    }

    function onResponse(data) {
        if(data.success) {
            location.href = data.redirect;
        } else {
            $('form[name="checkout"]').replaceWith(data.html);
            $c.hideLoading();
            humane.error(data.message);
        }
    }

    $doc.on('click', '#shop_frontendbundle_checkouttype_differentShippingAddress', function() {
        $('#shippingAddress').toggle();
    });
    $doc.on('submit', 'form[name="checkout"]', onFormSubmit);

    $(function() {
        if($('#shippingAddress').attr('checked')) $('#shippingAddress').show();
        if(!$('#shop_frontendbundle_checkouttype_shipment_e').attr('checked')) $('#shop_frontendbundle_checkouttype_shipment_p').attr('checked', true);
        if(!$('#shop_frontendbundle_checkouttype_payment_c').attr('checked')) $('#shop_frontendbundle_checkouttype_payment_i').attr('checked', true);
    });
})(jQuery);