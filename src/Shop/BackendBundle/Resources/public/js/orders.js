;(function($) {
    var $doc = $(document);

    function onDetailsLoaded(data) {
        $c.hideLoading();
        $.fancybox.open(data);
    }

    function onMarkerResponse(data) {
        $('[data-order=' + data.order + ']').replaceWith(data.html);
        $c.hideLoading();
    }

    function onMarkPaidClick() {
        var $target = $(this), status;
        status = $(this).attr('checked') ? 1 : 0;

        $c.showLoading();
        $.post($target.data('paid'), 'status=' + status, onMarkerResponse, 'json');
    }

    function onMarkShippedClick() {
        var $target = $(this), status;
        status = $(this).attr('checked') ? 1 : 0;

        $c.showLoading();
        $.post($target.data('shipped'), 'status=' + status, onMarkerResponse, 'json');
    }

    function onShowDetailsClick(event) {
        event.preventDefault();

        $c.showLoading();
        $.get(this.href, null, onDetailsLoaded, 'html');
    }

    $doc.on('click', '.details', onShowDetailsClick);
    $doc.on('click', '[data-shipped]', onMarkShippedClick);
    $doc.on('click', '[data-paid]', onMarkPaidClick);
})(jQuery);