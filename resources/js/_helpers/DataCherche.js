import $ from 'jquery';
import '../_helpers/jqueryHelper'

(function ($) {
    var _data_cherche = function (elmnts, search, format_cherche, propriete) {
        var id = elmnts.hasAttr('data-cherche') ? 'cherche-' + elmnts.attr('data-cherche') : null,
            attr_input = $.extend(true, {}, {
                'type': 'text',
                'class': 'form-control',
                'placeholder': (format_cherche ? format_cherche : 'Recherche ...')
            }, propriete || {}),
            temp = null, css_show = { 'display': 'block', 'opacity': '1' }, css_hide = { 'display': 'none', 'opacity': '0' },
            createInterval_event = function (event_) {
                return setInterval(function () {
                    if ($('div#' + id).hasClass('active-search'))
                        clearInterval(event_);
                    else
                        $('div#' + id).css(css_hide);
                }, 3100)
            },
            block_search = $('<div/>', {
                'style': 'position:absolute;display:none;-webkit-transition: opacity 2s;transition: opacity 2s;opacity:0;',
                'id': id
            }).append(
                $('<div/>', { 'class': 'input-group', 'style': 'background: #fff;width: 200px;padding-left: 8px;' }).append(
                    $('<input/>', attr_input).focusin(
                        function () {
                            $('div#' + id).addClass('active-search')
                            var css_change = css_show;
                        }).focusout(
                            function () {
                                $('div#' + id).removeClass('active-search')
                                temp = createInterval_event(temp)
                            }).controleInput().clone(true)
                ).append(
                    $('<span/>', { 'class': 'input-group-btn' }).append(
                        $('<button/>', { 'class': 'btn btn-default', 'type': 'button' }).append(
                            $('<i/>', { 'class': 'fa fa-search' }).clone(true)).click(
                                function () {
                                    if (typeof search === 'function')
                                        search.apply(this, [$('div#' + id).find('input').val(), $('div#' + id)]);
                                }).clone(true)
                    ).clone(true)
                ).clone(true)
            )
        elmnts.each(function () {
            var _el_this = this, fct___ = function () {
                clearInterval(temp);
                temp = createInterval_event(temp);
                $('div#' + id).css($.extend(true, {}, {
                    'left': (_el_this.offsetWidth + _el_this.offsetLeft) - 200,
                    'top': _el_this.offsetTop
                }, css_show));

                $(this).resized($(this)).add([() => {
                    $('div#' + id).css({
                        'left': (_el_this.offsetWidth + _el_this.offsetLeft) - 200,
                        'top': _el_this.offsetTop
                    });
                }]);
            };
            if (this.addEventListener)
                this.addEventListener("mouseover", function () {
                    fct___()
                });
            else if (this.attachEvent)
                this.attachEvent("mouseover", function () {
                    fct___()
                });

            if (id && $('div#' + id).length === 0) {
                block_search.appendTo('body');
            } else if (id) {
                var val = $('div#' + id).find('input').val();
                $('div#' + id).remove();
                block_search.find('input').val(val);
                block_search.appendTo('body');
            }
        })
        return $(this);
    };
    $.fn.extend({
        dataCherche: _data_cherche
    })
})($)