;(function($) {
    var $next = null, $doc = $(document);

    function closeElement($element) {
        $element.css({minHeight: 0, maxHeight: 0}).addClass('closing');
    }

    function onAnyClick(event) {
        if($(event.target).closest('#meta').length == 0) {
            closeElement($('#meta').find('.active'));
            $doc.off('click', '*', onAnyClick);
        }
    }

    function onMetaLinkClick(event) {
        event.preventDefault();
        var $targetContainer = $($(this).attr('href')), $active = $('#meta').find('.active');

        if($active.length == 0) {
            $targetContainer.addClass('active');
            $doc.on('click', '*', onAnyClick);
            return;
        }

        if($targetContainer.hasClass('active')) {
            closeElement($targetContainer);
            $doc.off('click', '*', onAnyClick);
            $next = null;
            return;
        }

        closeElement($active);
        $next = $targetContainer;
    }

    function onTransitionEnded() {
        var $target = $(this);

        if($target.hasClass('closing')) {
            $target.removeClass('active closing').css({minHeight: '', maxHeight: ''});
        }

        if($next != null) {
            $next.addClass('active');
            $next = null;
        }
    }

    $c.openCart = function() {
        var $cartLink = $('#meta').find('.cart');
        if(!$cartLink.hasClass('active')) {
            $cartLink.click();
        }
    }


    $doc.on('click', '#meta nav a', onMetaLinkClick);
    $doc.on('transitionEnd transitionend webkitTransitionEnd oTransitionEnd msTransitionEnd', '#meta > *', onTransitionEnded);
})(jQuery);