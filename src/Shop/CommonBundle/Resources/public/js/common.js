;(function($) {
    var $doc = $(document), loadCounter = 0;

    function handleConfirm(event) {
        var message = $(this).data('confirm');
        if(!confirm(message)) {
            event.stopImmediatePropagation();
            return false;
        }
    }

    function openInFancybox(event) {
        event.preventDefault();
        var $target = $(this);

        $.fancybox.open({
            type: $target.attr('href').indexOf('#') != 0 ? 'ajax' : 'inline',
            href: $target.attr('href')
        });
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
    $doc.on('click', '.fancybox', openInFancybox);

    $(function() {
        if(Common.prop('flash:error')) humane.error(Common.prop('flash:error'));
        if(Common.prop('flash:notice')) humane.success(Common.prop('flash:notice'));
    });
})(jQuery);