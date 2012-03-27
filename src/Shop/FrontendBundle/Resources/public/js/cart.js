;(function($) {
    var $doc = $(document);

    function onCartResponse(data) {
        //TODO implement
        $c.hideLoading();
    }

    function onAddToCartClick(event) {
        event.preventDefault();
        var $target = $(this), quantity;

        quantity = $('#' + $target.attr('id') + '-quantity').val();

        $c.showLoading();
        $.post($target.data('cart'), 'quantity=' + quantity, onCartResponse, 'json');
    }

    $doc.on('click', '[data-cart]', onAddToCartClick);
})(jQuery);