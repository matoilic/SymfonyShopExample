;(function($) {
    var $doc = $(document);

    function onCartResponse(data) {
        $c.hideLoading();
        $('#cart').replaceWith(data.html);
        $c.openCart();
    }

    function onAddToCartClick(event) {
        event.preventDefault();
        var $target = $(this), quantity;

        quantity = $('#' + $target.attr('id') + '-quantity').val();

        $c.showLoading();
        $.post($target.data('cart'), 'quantity=' + quantity, onCartResponse, 'json');
    }

    function onRemoveFromCartClick() {
        $('#cart').find('.remove').attr('disabled', true);

        $c.showLoading();
        $.post($(this).data('href'), {}, onCartResponse, 'json');
    }

    $doc.on('click', '[data-cart]', onAddToCartClick);
    $doc.on('click', '#cart .remove', onRemoveFromCartClick);
})(jQuery);