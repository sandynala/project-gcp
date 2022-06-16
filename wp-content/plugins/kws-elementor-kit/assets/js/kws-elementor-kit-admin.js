jQuery(document).ready(function ($) {

    jQuery('.kws-elementor-kit-notice.is-dismissible .notice-dismiss').on('click', function () {
        $this = jQuery(this).parents('.kws-elementor-kit-notice');
        var $id = $this.attr('id') || '';
        var $time = $this.attr('dismissible-time') || '';
        var $meta = $this.attr('dismissible-meta') || '';

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'kws-elementor-kit-notices',
                id: $id,
                meta: $meta,
                time: $time,
            },
        });

    });

});