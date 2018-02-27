(function ($) {
    "use strict";
    var utm_source = location.host;
    $(document).ready(function() {
        // Get promotion from api
        $('.promotion').each(function(){
            var $this = $(this);
            $.ajax({
                url: zindo_accesstrade_banners_ajax.ajaxurl,
                data: {
                    'action':'zindo_masoffer_auto_banner_ajax_get_promotions',
                    'widget_id': $this.data('widget-id'),
                    'widget_name': $this.data('widget-name'),
                },
                dataType: 'json',
            })
            .done(function(data) {
                data = data.data;
                var html = display_promotion(data);
                $this.html(html);
            })             
        });

    });

    function display_promotion (data) {
        var rand_data = data[Math.floor(Math.random() * data.length)];
        var url_promotion = rand_data.aff_link + '&utm_source=' + utm_source;
        var image = rand_data.image;
        var html = '<a target="_blank" href="'+ url_promotion +'"><img width="100%" src="'+ image +'"></a>';
        return html;
    }
})(jQuery);
