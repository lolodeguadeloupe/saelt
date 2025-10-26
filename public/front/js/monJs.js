$(document).ready(function () {

    (function ($) {

        $('a').each(function () {
            $(this).click(function () {
                var el = this;
                if (typeof $(el).attr('href') != 'undefined' && $(el).attr('href') != '#' && typeof $(el).attr('data-toggle') != 'undefined') {
                    window.location = $(el).attr('href');
                }
            })
        })

    })(jQuery)
})