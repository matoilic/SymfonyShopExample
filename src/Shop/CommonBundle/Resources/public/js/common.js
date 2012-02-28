;(function($) {
    var $doc = $(document);

    function handleConfirm(event) {
        var message = $(this).data('confirm');
        if(!confirm(message)) {
            event.stopImmediatePropagation();
            return false;
        }
    }

    var Common = {
        disableForm: function(form) {
            $(form).find('input,textarea,select').attr('disabled', true);
        },

        enableForm: function(form) {
            $(form).find('input,textarea,select').attr('disabled', false);
        },

        hideLoading: function() {
            if(loadCounter == 0) return;

            loadCounter--;

            if(loadCounter == 0) $.fancybox.hideLoading();
        },

        prop: function(name) {
            return $('meta[name="' + name + '"]').attr('content');
        },

        showLoading: function() {
            if(loadCounter == 0) {
                $.fancybox.showLoading();
            }

            loadCounter++;
        }
    }

    window.Common = window.$c = Common;

    $doc.on('click', '[data-confirm]', handleConfirm);
})(jQuery);