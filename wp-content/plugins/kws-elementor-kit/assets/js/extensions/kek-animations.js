(function ($, elementor) {

    'use strict';

    var extensionAnimations = function ($scope, $) {

        var $animations = $scope.find('.kek-in-animation');

        if (!$animations.length) {
            return;
        }

        var itemQueue = [];
        var delay = ($animations.data('in-animation-delay')) ? $animations.data('in-animation-delay') : 200;
        var queueTimer;

        function processItemQueue() {
            if (queueTimer) return // We're already processing the queue

            queueTimer = window.setInterval(function () {
                if (itemQueue.length) {
                    jQuery(itemQueue.shift()).addClass('is-inview');
                    processItemQueue();
                } else {
                    window.clearInterval(queueTimer)
                    queueTimer = null
                }
            }, delay)
        }

        elementorFrontend.waypoint(jQuery('.kek-in-animation .kek-item'), function () {
            itemQueue.push($(this));
            processItemQueue();
        }, {
            offset: '90%'
        });

    };

    jQuery(window).on('elementor/frontend/init', function () {

        var $widgets = [ 'alex-grid', 'alice-grid', 'pluto-grid', 'neptune-grid', 'buzz-list', 'classic-list', 'venus-grid', 'cygnus-list', 'featured-list', 'andromeda-list', 'jupiter-grid', 'kalon-grid', 'maple-grid', 'ramble-grid', 'recent-comments', 'canis-list', 'tiny-list', 'welsh-list', 'wixer-grid' ];

        $.each($widgets, function(index, value) {
            elementorFrontend.hooks.addAction('frontend/element_ready/kek-' + value +'.default', extensionAnimations);
        });
    });

}(jQuery, window.elementorFrontend));


