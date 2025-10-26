import $ from 'jquery';

(function ($) {

    $(window).resize(function () {
        var el = $(this);
        el.resized(el).isEvent();
    })

    var trimPoint = function (x) {
        x.trim()
        return x.replace(/^[.]+|[.]+$/gm, '');
    }

    var event_resize = (function () {
        var getInstance = function () {
            var _event = (typeof $('body').data('resize') !== 'undefined') ? $('body').data('resize') || [] : [];
            this.add = function (ev) {
                console.log(ev)
                var _isEvent = [];
                for (const _e_ in _event) {
                    if (typeof _event[_e_] === 'function') {
                        _isEvent.push(_event[_e_]);
                    }
                }
                for (const _e_ in ev) {
                    if (typeof ev[_e_] === 'function') {
                        _isEvent.push(ev[_e_]);
                    }
                };
                $('body').data('resize', _isEvent);
                return this;
            }
            this.isEvent = function () {
                console.log(_event)
                for (const _e_ in _event) {
                    if (typeof _event[_e_] === 'function') {
                        _event[_e_].apply(this);
                    }
                }
                return this;
            }
            return this;
        }
        return function (el) {
            return getInstance.apply(el);
        };
    })()

    var _addTitle = function (cl_css = 'title-info') {
        var el = $(this)
        if ($(this).hasAttr('title-old') && !$(this).hasAttr('title_'))
            return this
        if ($(this).hasAttr('title') || $(this).hasAttr('title_'))
            $(this).off('mouseenter')
        $(this).mouseenter(function (event) {
            var _title_ = $(this).attr('title')
            $(this).attr('title-old', _title_)
            var _sess_ = 'info-title-' + new Date().getTime()
            $(this).removeAttr('title')
            var x = $(this).offset()
            var _this_ = $("<span/ > ").html(_title_).appendTo('body').attr({
                'class': 'title ' + cl_css,
                'sess-actif': _sess_
            })
            _this_.css({
                'visibility': 'visible',
                'z-index': '100000',
                'right': 'unset',
                'top': parseInt(event.pageY) - (parseInt(_this_.height()) / 2) + 'px',
                'left': parseInt(event.pageX) - (parseInt(_this_.width()) + 36) + 'px'
            })
            //console.log(event.clientY,event.pageY,Math.round($(window).scrollTop()))
            $(this).mouseleave(function () {
                try {
                    $("[sess-actif='" + _sess_ + "']").remove()
                } catch (e) {
                }

                $("[sess-actif^='info-title-']").each(function () {
                    $(this).remove()
                })
                if ($(this).hasAttr('title-old')) {
                    $(this).attr('title', $(this).attr('title-old'))
                    $(this).removeAttr('title-old')
                } else if (!$(this).hasAttr('title'))
                    $(this).off('mouseenter')
            })
        }
        )
        return el
    }

    var _hasAttr = function (attribute) {
        //console.log($(this))
        if (typeof $(this)[0] === 'object') {
            //console.log($(this).attr(attribute))
            return (typeof $(this).attr(attribute) === 'string')
        }
        return false
    }

    var _attachClass = function (clss) {
        if ($(this).hasClass(clss))
            return this;
        $(this).addClass(clss);
        return this;
    }

    var _dettachClass = function (clss) {
        if ($(this).hasClass(clss)) {
            $(this).removeClass(clss);
            return this;
        }
        return this;
    }

    var _outerCss = function (returns) {
        if (typeof returns === 'string') {
            if (returns === 'this')
                return {
                    left: parseInt($(this).css('padding-left')) + parseInt($(this).css('margin-left')),
                    right: parseInt($(this).css('padding-right')) + parseInt($(this).css('margin-right')),
                    top: parseInt($(this).css('padding-top')) + parseInt($(this).css('margin-top')),
                    bottom: parseInt($(this).css('padding-bottom')) + parseInt($(this).css('margin-bottom'))
                }
            else if (returns === 'parent') {
                var p = $(this).parent(), left = 0, top = 0, eps_left = parseInt($(this).offset().left) - parseInt(p.offset().left), eps_top = parseInt($(this).offset().top) - parseInt(p.offset().top)
                do {
                    if (p.css('position') == 'absolute' || p.css('position') == 'relative' || p.is('body'))
                        break;
                    eps_top = parseInt($(this).offset().top) - parseInt(p.offset().top)//new enter
                    eps_left = parseInt($(this).offset().left) - parseInt(p.offset().left)//new enter
                    p = p.parent();
                    left = left + parseInt(p.css('padding-left'));
                    top = top + parseInt(p.css('padding-top'));
                } while (p.css('position') != 'absolute' && p.css('position') != 'relative' && !p.is('body'));
                return {
                    /*'left': eps_left < 0 ? eps_left : eps_left + left,
                     'top': eps_top < 0 ? eps_top : eps_top + top*/
                    'left': eps_left, //new enter
                    'top': eps_top//new enter
                }
            } else
                return {
                    left: parseInt($(this).parent().parent().css('padding-left')) + parseInt($(this).parent().css('padding-left')) + parseInt($(this).css('padding-left')) + parseInt($(this).css('margin-left')),
                    right: parseInt($(this).parent().parent().css('padding-right')) + parseInt($(this).parent().css('padding-right')) + parseInt($(this).css('padding-right')) + parseInt($(this).css('margin-right')),
                    top: parseInt($(this).parent().parent().css('padding-top')) + parseInt($(this).parent().css('padding-top')) + parseInt($(this).css('padding-top')) + parseInt($(this).css('margin-top')),
                    bottom: parseInt($(this).parent().parent().css('padding-bottom')) + parseInt($(this).parent().css('padding-bottom')) + parseInt($(this).css('padding-bottom')) + parseInt($(this).css('margin-bottom'))
                }
        }
    }

    var _removeInputErrer = function () {
        if ($(this)[0].validity.valid) {
            $(this).dettachClass('is-invalid');
            if ($(this).nextAll("i[class*='fa-warning']").length)
                $(this).nextAll("i[class*='fa-warning']").remove()
        }
        return $(this)
    }

    var _controleInput = function () {
        var element = $(this), dd = function (val) {

            var i = val.split(' '), resulta = val
            for (var j = 0; j < i.length; j++) {
                resulta = j == 0
                    ?
                    $.trim(i[j]) !== '' ? $.trim(i[j]).substr(0, 1).toUpperCase() + $.trim(i[j]).substr(1) : ''
                    :
                    (resulta !== ''
                        ?
                        resulta += ' ' + ($.trim(i[j]) !== '' ? $.trim(i[j]).substr(0, 1).toUpperCase() + $.trim(i[j]).substr(1) : '')
                        :
                        $.trim(i[j]) !== '' ? $.trim(i[j]).substr(0, 1).toUpperCase() + $.trim(i[j]).substr(1) : '')
            }
            return $.trim(resulta)
        }

        element.each(function () {
            $(this).focusout(function (e) {
                if ($(this).is('input[type="email"]') || $(this).is('input[type="password"]') || $(this).hasAttr('custom')) {
                    $(this).val(trimPoint(e.target.value))
                    return;
                }
                if ($(this).hasClass('upercase'))
                    $(this).val(e.target.value.toUpperCase())
                else
                    $(this).val(dd(trimPoint(e.target.value)))
            })
            $(this).focusin(function () {
                $(this).select()
            })
            if ($(this).is('[type="checkbox"]'))
                $(this).click(function (e) {
                    $(this).val(e.target.checked ? 1 : 0);
                })
            if ($(this).is('input[type="checkbox"]'))
                $(this).val($(this)[0].checked ? 1 : 0);
        })
        return $(this)
    }

    var _newElementListeTable = function (element) {
        console.log(element)
        $('table.table-list').each(function () {
            console.log($(this),'table.table-list')
            $(this).find('tbody tr td').each(function () {
                console.log($(this),'tbody tr td')
                if (element.test($(this).html())) $(this).parent().addClass('new');
            })
        })
    }


    /* constrole erreur event */
    $('input,select').keyup(function (e) {
        $(this).removeInputErrer();
    });

    $('input[type="date"], select,input').change(function (e) {
        $(this).removeInputErrer();
    });
    /* constrole erreur event */

    $.fn.extend({
        addTitle: _addTitle,
        hasAttr: _hasAttr,
        attachClass: _attachClass,
        dettachClass: _dettachClass,
        outerCss: _outerCss,
        removeInputErrer: _removeInputErrer,
        resized: event_resize,
        controleInput: _controleInput,
        newElementListeTable:_newElementListeTable
    })

})($)