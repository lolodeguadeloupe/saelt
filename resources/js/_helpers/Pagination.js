import $ from 'jquery';

(function ($) {

    var _pagination = function (pagination, event) {

        return $('<ul/>',
            {
                'style': 'display: flex; padding-left: 0px;list-style: none; border-radius: .25rem;margin: 0px; float: right;'
            }).append(
                $('<li/>',
                    {
                        'style': 'display:inline;'
                    }
                ).append(

                    $('<a/>',
                        {
                            'class': pagination.link_prev ? 'clicable' : 'disabled',
                            'href': '#',
                            'style': 'position: relative;float: left;padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background: #fafafa;border: 1px solid #b0a7a7;margin-left: 0;border-top-left-radius: 4px;border-bottom-left-radius: 4px;'
                        }
                    ).html(bib_lang['paginate_prec']).clone(true)
                ).click(
                    function () {
                        if (typeof event.pagPrec === 'function' && pagination.link_prev) {
                            event.pagPrec.call(this, pagination.link_prev)
                        }
                    }).clone(true)
            ).append(
                $('<li/>',
                    {
                        'class': 'disabled', 'style': 'display:inline;'
                    }
                ).append(
                    $('<a/>',
                        {
                            'class': pagination.link_next ? 'clicable' : 'disabled',
                            'href': '#',
                            'style': 'position: relative;float: left;padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background: #fafafa;border: 1px solid #b0a7a7;border-top-right-radius: 4px;border-bottom-right-radius: 4px;'
                        }
                    ).html(bib_lang['paginate_suiv']).click(
                        function () {
                            if (typeof event.pagSuiv === 'function' && pagination.link_next) {
                                event.pagSuiv.call(this, pagination.link_next)
                            }
                        }).clone(true)
                ).clone(true)
            )
    };

    $.fn.extend({
        pagination: _pagination
    });
})($)