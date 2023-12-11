(function($) {
    "use strict";
    var $window = $(window);
    var $body = $('body');
    window.azh = $.extend({}, window.azh);
    var parse_query_string = function (a) {
        if (a == "") {
            return {};
        }
        var b = {};
        for (var i = 0; i < a.length; ++i) {
            var p = a[i].split('=');
            if (p.length != 2) {
                continue;
            }
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    };
    $.QueryString = parse_query_string(window.location.search.substr(1).split('&'));
    if ('azh' in $.QueryString && $.QueryString['azh'] == 'customize') {
        $window.on('azh-customization-after-init', function(event, data) {
            var $wrapper = data.wrapper;
        });
    }
})(window.jQuery);