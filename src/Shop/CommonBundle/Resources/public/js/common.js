;(function($) {
    var $doc = $(document), loadCounter = 0;

    function handleConfirm(event) {
        var message = $(this).data('confirm');
        if(!confirm(message)) {
            event.stopImmediatePropagation();
            return false;
        }
    }

    var Common = {
        csrfProtection: function(xhr) {
            var token = Common.prop('csrf-token');
            if(token) xhr.setRequestHeader('X-CSRF-Token', token);
        },

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

    if($.tipValidate) $.tipValidate.delay = 5000;

    $.ajaxPrefilter(function(options, originalOptions, xhr) {
        if (!options.crossDomain) {
            Common.csrfProtection(xhr);
        }
    });

    $doc.on('click', '[data-confirm]', handleConfirm);
})(jQuery);