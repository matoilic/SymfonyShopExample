;(function($) {
    var $doc = $(document), $form, _recordContainer, _dataAttribute, _formName, _callbacks;

    function emptyCallback() { }

    function init(recordContainer, entity, callbacks) {
        _recordContainer = recordContainer;
        _dataAttribute =  'data-' + entity;
        _formName = entity;

        _callbacks = $.extend({
            onFormOpen: $.noop,
            onFormClose: $.noop
        }, callbacks || {});

        $doc.on('click', '.create', onCreateRecordClick);
        $doc.on('click', _recordContainer + ' .edit', onEditRecordClick);
        $doc.on('click', _recordContainer + ' .delete', onDeleteRecordClick);
    }

    function loadForm(url) {
        $c.showLoading();
        $.get(url, {}, onFormLoaded, 'html');
    }

    function onCreateRecordClick(event) {
        event.preventDefault();
        loadForm($(this).data('href'));
    }

    function onDeleteRecordClick(event) {
        var $target = $(this);
        event.preventDefault();

        $target.hide();
        $c.showLoading();
        $.get($target.attr('href'), {}, onRecordDeleted, 'json');
    }

    function onEditRecordClick(event) {
        event.preventDefault();
        loadForm(this.href);
    }

    function onFormLoaded(data) {
        $c.hideLoading();
        $.fancybox.open(data, {
            beforeClose: function() { _callbacks.onFormClose.call($form[0]); }
        });
        setupForm(onFormSubmit);
        _callbacks.onFormOpen.call($form[0]);
    }

    function onFormSubmit(event) {
        event.preventDefault();
        var data = $form.serialize();

        $c.showLoading();
        $form.append('<input type="hidden" name="' + $c.prop('csrf-field') + '" value="' + $c.prop('csrf-token') + '">');
        $form.ajaxSubmit({
            success: onRecordCreatedOrUpdated,
            iframe: true,
            dataType: 'json'
        });
        //$c.disableForm($form);
        //$.post($form.attr('action'), data, onRecordCreatedOrUpdated, 'json');
    }

    function onRecordCreatedOrUpdated(data) {
        if(data.success) {
            var $row = $(data.html);

            if(data.recordId) {
                $('[' + _dataAttribute + '="' + data.recordId +'"]').replaceWith($row);
            } else {
                $(_recordContainer).append($row);
            }

            $.fancybox.close();
            humane.success(data.message);
            $row.effect('highlight', {});
        } else {
            $form.replaceWith(data.html);
            setupForm( onFormSubmit);
        }

        $c.hideLoading();
    }

    function onRecordDeleted(data) {
        $c.hideLoading();
        var $record = $('[' + _dataAttribute + '="' + data.recordId +'"]');

        if(data.success) {
            humane.success(data.message);
            $record.effect('fade', {}, 1500, function() {
                $(this).remove();
            });
        } else {
            humane.error(data.message);
            $record.find('.delete').show();
        }
    }

    function setupForm(callback) {
        $doc.off('submit', 'form[name="' + _formName + '"]');
        $doc.on('submit', 'form[name="' + _formName + '"]', callback);
        $form = $('form[name="' + _formName + '"]').tipValidate().localize();
    }

    Common.initCRUD = init;
})(jQuery);