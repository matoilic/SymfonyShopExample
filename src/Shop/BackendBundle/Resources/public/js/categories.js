;(function($, $c) {
    var $doc = $(document), $form;

    function loadForm(url) {
        $c.showLoading();
        $.get(url, {}, onFormLoaded, 'html');
    }

    function onCategoryCreatedOrUpdated(data) {
        if(data.success) {
            var $row = $(data.html);

            if(data.categoryId) {
                $('[data-category="' + data.categoryId +'"]').replaceWith($row);
            } else {
                $('#categories').append($row);
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

    function onCategoryDeleted(data) {
        $c.hideLoading();
        var $category = $('[data-category="' + data.categoryId +'"]');

        if(data.success) {
            humane.success(data.message);
            $category.effect('fade', {}, 1500, function() {
                $(this).remove();
            });
        } else {
            humane.error(data.message);
            $category.find('.delete').show();
        }
    }

    function onCreateCategoryClick(event) {
        event.preventDefault();
        loadForm($(this).data('href'));
    }

    function onDeleteCategoryClick(event) {
        var $target = $(this);
        event.preventDefault();

        $target.hide();
        $c.showLoading();
        $.get($target.attr('href'), {}, onCategoryDeleted, 'json');
    }

    function onEditCategoryClick(event) {
        event.preventDefault();
        loadForm(this.href);
    }

    function onFormLoaded(data) {
        $c.hideLoading();
        $.fancybox.open(data);
        setupForm(onFormSubmit);
    }

    function onFormSubmit(event) {
        event.preventDefault();
        var data = $form.serialize();

        $c.disableForm($form);
        $c.showLoading();
        $.post($form.attr('action'), data, onCategoryCreatedOrUpdated, 'json');
    }

    function setupForm(callback) {
        $doc.off('submit', 'form[name="category"]');
        $doc.on('submit', 'form[name="category"]', callback);
        $form = $('form[name="category"]').tipValidate();
    }

    $doc.on('click', '.create', onCreateCategoryClick);
    $doc.on('click', '#categories .edit', onEditCategoryClick);
    $doc.on('click', '#categories .delete', onDeleteCategoryClick);
})(jQuery, Common);