;(function($) {
    function localize(form) {
        var locale = $('html').attr('lang');
        showLocale(locale, form);
        $(form).on('click', '[data-switch]', onLocaleClick);
    }

    function onLocaleClick(event) {
        event.preventDefault();
        var $target = $(this);

        showLocale($target.data('switch'), $target.closest('form'));
    }

    function showLocale(locale, form) {
        var $form = $(form);

        $form.find('[data-switch].active').removeClass('active');
        $form.find('[data-switch="' + locale + '"]').addClass('active');

        $form.find('[data-lang]').each(function(i, element) {
            var $element = $(element);
            if($element.data('lang') != locale) {
                $element.closest('p').hide();
            } else {
                $element.closest('p').show();
            }
        });
    }

    $.fn.localize = function() {
        this.filter('form').each(function(i, element) {
            localize(element);
        });

        return this;
    };
})(jQuery);