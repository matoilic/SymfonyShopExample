;(function($) {
    var $next = null, $doc = $(document);

    function onAnyClick(event) {
        if($(event.target).closest('#meta').length == 0) {
            $('#meta').find('.active').removeClass('active');
            $doc.off('click', '*', onAnyClick);
        }
    }

    function onLinkClick(event) {
        event.preventDefault();
        var $targetContainer = $($(this).attr('href')), $active = $('#meta').find('.active');

        if($active.length == 0) {
            $targetContainer.addClass('active');
            $doc.on('click', '*', onAnyClick);
            return;
        }

        if($targetContainer.hasClass('active')) {
            $targetContainer.removeClass('active');
            $doc.off('click', '*', onAnyClick);
            $next = null;
            return;
        }

        $active.removeClass('active');
        $next = $targetContainer;
    }

    function onTransitionEnded() {
        if($next != null) {
            $next.addClass('active');
            $next = null;
        }
    }

    $(function() {
        $doc.on('click', '#meta a', onLinkClick);

        //use "native" JavaScript since jquery does not yet support transition events
        var meta = document.getElementById('meta');
        meta.addEventListener('webkitTransitionEnd', onTransitionEnded);
        meta.addEventListener('transitionend', onTransitionEnded);
        meta.addEventListener('oTransitionEnd', onTransitionEnded);
    });
})(jQuery);