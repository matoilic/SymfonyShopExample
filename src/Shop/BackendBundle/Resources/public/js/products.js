;(function($) {
    var calendarInitialized = false;

    function onFormClose() {
        $('.kalendae').remove();
    }

    function onFormOpen() {
        $('input.date').kalendae({
            weekStart: 1,
            format: 'DD.MM.YYYY'
        });
    }

    $c.initCRUD('#products', 'product', {
        onFormOpen: onFormOpen,
        onFormClose: onFormClose
    });
})(jQuery);