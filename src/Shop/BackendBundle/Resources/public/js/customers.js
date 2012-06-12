;(function($) {
    function onDetailsLoaded(data) {
        $c.hideLoading();
        $.fancybox.open(data);
    }

    function onShowDetailsClick(event) {
        event.preventDefault();

        $c.showLoading()
        $.get(this.href, null, onDetailsLoaded, 'html');
    }

    $(document).on('click', '.details', onShowDetailsClick);
})(jQuery);