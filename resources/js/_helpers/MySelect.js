import $ from 'jquery'
import '../_helpers/EventButtonCliked';
import '../_helpers/GenerateChar';


(function ($) {

    $('<style> li[aria-selected]{cursor: pointer;} ul li.mySelect-option:hover{background-color:rgb(199, 206, 211);}ul li.mySelect-option[aria-selected="true"]{background-color: #3c8dbc;color:white}</style>').appendTo('head')
    var Myselect = function (options) {
        var form = $(this).parents('form');
        var data = {};
        var ajax = function (key, URL, _token, callback, _even) {
            $.ajax({
                headers: {
                    'Authorization': 'Bearer ' + _token,
                    'Accept': 'application/json'
                },
                url: URL,
                type: 'POST',
                success: function (_data_, textStatus, jqXHR) {
                    data[key] = []
                    for (var i in _data_) {
                        if (typeof _data_[i] === 'object') {
                            data[key].push(_data_[i])
                        } else if (typeof _data_[i] === 'string')
                            data[key].push(_data_)
                    }
                    if (callback && typeof callback === 'function')
                        callback()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    data[key] = []
                },
                complete: function (jqXHR, textStatus) {
                    if (_even && typeof _even === 'function')
                        _even();
                    if (options && options.completeAjax && typeof options.completeAjax === 'function')
                    options.completeAjax(jqXHR.status, jqXHR.statusText, textStatus);
                }
            });
        };

        var _label = function () {
            $(this).parents('div.form-group').find('label.control-label').each(function () {
                $('<label/>', {
                    'class': '_label'
                }).css({
                    position: 'absolute',
                    background: 'rgb(255, 255, 255)',
                    padding: ' 0.5%',
                    margin: '0px',
                    height: $(this).height,
                    border: '1px solid #c9cbd4',
                    left: $(this).outerCss('parent').left
                }).html($(this).html()).appendTo($(this).parent());
            });
        },
            _label_remove = function () {
                $(this).parents('div.form-group').find('._label').each(function () {
                    $(this).remove();
                })
            },
            InputSelect = function (element) {
                if (element == null)
                    return;
                var $p = $('<span/>').attr({
                    'dir': 'ltr',
                    'data-mySelect-id': $(this).GenerateChars(10)
                }).css({
                    'box-sizing': 'border-box',
                    'display': 'inline-block',
                    'margin': '0',
                    'position': 'relative',
                    'vertical-align': 'middle',
                    //
                    'width': '100%',
                    'border-color': '#3c8dbc',
                    'background-color': '#fff'
                }).mouseover(_label).mouseleave(_label_remove).focusin(_label_remove).click(_label_remove);
                element.css({
                    'border': '0',
                    'clip': 'rect(0 0 0 0)',
                    '-webkit-clip-path': 'inset(50%)',
                    'clip-path': 'inset(50%)',
                    'height': '1px',
                    'overflow': 'hidden',
                    'padding': '0',
                    'position': 'absolute',
                    'width': '1px',
                    'white-space': 'nowrap'
                }).after($p);

                return $p;
            }

        var Resultats = function (resultatsID) {
            var $p_1 = $('<span/>').css({
                'position': 'absolute',
                'box-sizing': 'border-box',
                'display': 'none',
                'margin': '0',
                'vertical-align': 'middle'
            }).attr({
                'data-resultat': resultatsID
            });

            var $p_2 = $('<span/>').attr({
                'dir': 'ltr',
            }).css({
                'border-radius': '0',
                'background-color': 'white',
                'border': '1px solid #aaa',
                'border-radius': '4px',
                'box-sizing': 'border-box',
                'display': 'block',
                'position': 'absolute',
                'left': '0',
                'border-top': 'none',
                'border-top-left-radius': '0',
                'border-top-right-radius': '0',
                'z-index': '1051'
            }).appendTo($p_1);

            var $input_span = $('<span/>').css({
                'display': 'block',
                'padding': '4px'
            });

            $('<input/>').attr({
                'type': 'search',
                'dabindex': '0',
                'autocomplete': 'off',
                'autocorrect': 'off',
                'autocapitalize': 'none',
                'spellcheck': 'false',
                'role': 'textbox',
                'aria-expended': 'false',
                'request': resultatsID
            }).css({
                'border': '1px solid #aaa',
                'padding': '4px',
                'width': '100%',
                'box-sizing': 'border-box'
            }).keyup(function (event) {
                $('ul[data-mySelect-resultat="' + resultatsID + '"]').find('li').each(function () {
                    $(this).css('display', ($(this).html().indexOf(event.target.value)) != -1 ? 'block' : 'none');
                });
            }).appendTo($input_span);

            $input_span.appendTo($p_2);

            var $resultat_parent = $('<span/>').css({
                'display': 'block'
            });
            $resultat_parent.appendTo($p_2);

            var $listeOptions = $('<ul/>').attr({
                'role': 'tree',
                'aria-expended': 'true',
                'aria-hidden': 'false',
                'data-mySelect-resultat': resultatsID
            }).css({
                'max-height': '200px',
                'overflow-y': 'auto',
                //
                'list-style': 'none',
                'margin': '0',
                'padding': '0'
            }).mouseover(function () {
                $('input[request="' + resultatsID + '"]').attr('aria-expended', 'true');
            }).mouseout(function () {
                $('input[request="' + resultatsID + '"]').attr('aria-expended', 'false');
            });
            $listeOptions.appendTo($resultat_parent);

            $p_1.appendTo('body');

            return $p_1;
        };
        var option = function (check_id) {
            var $_ul = $('ul[data-mySelect-resultat="' + check_id + '"]')
            $_ul.html('')
            for (var i = 0; i < data[check_id].length; i++) {
                var $li = $('<li/>').css({
                    '-webkit-user-select': 'none',
                    'padding': '6px 12px',
                    'cursor': 'pointer',
                    //
                    'list-style': 'none',
                    'margin': '0',
                }).attr({
                    'role': 'treeitem',
                    'aria-selected': data[check_id][i].value === $('span[data-id-mySelected="' + check_id + '"]').html() ? 'true' : 'false',
                    'class': 'mySelect-option'
                }).data(data[check_id][i])
                $li.click(function () {
                    if ($('input[data-' + check_id + ']').length)
                        $('input[data-' + check_id + ']').val($(this).html()).removeInputErrer()
                    if ($('select[data-' + check_id + ']').length)
                        $('select[data-' + check_id + ']').val($(this).html()).removeInputErrer()
                    $('span[data-id-mySelected="' + check_id + '"]').html($(this).html()).attr('title', $(this).html());
                    $_ul.find('li').each(function () {
                        $(this).attr('aria-selected', 'false')
                    })
                    $(this).attr('aria-selected', 'true') //
                    //
                    $('span[data-resultat="' + check_id + '"]').css('display', 'none')
                    //
                    if (options && typeof options['selectAction'] === 'function') {
                        options.selectAction.apply(this, [$(this).data(), form])
                    }

                });

                $li.html(data[check_id][i].value).appendTo($_ul)
            }
        };

        var showResultat = function (_this, check_id) {
            if (options && typeof options['callback'] === 'function') {
                data[check_id] = options.callback(data[check_id]);
            }

            if (typeof data[check_id] === 'undefined')
                throw new Error('errer data option {selectDATA:{data}{}');
            //console.log(MySelect.data[check_id])
            option(check_id);

            var $option = $('span[data-resultat="' + check_id + '"]')
            var $d = $option.css({
                'top': parseInt($(_this).offset().top) + parseInt($(_this).outerHeight()), //'219px', //y
                'left': $(_this).offset().left, //'355px', //z
                'display': 'inline-block',
            }).children('span:first').css('width', $(_this).width()).find('input[request="' + check_id + '"]').focus()
            $d.focusout(function () {
                if ($(this).attr('aria-expended') == 'false')
                    $option.css('display', 'none')
                $(this).val('')
                $('ul[data-mySelect-resultat="' + check_id + '"]').find('li').each(function () {
                    $(this).css('display', 'block')
                })
            })
        };

        var InputSelectContent = {
            'next_2': function (attrID) {
                var b = $('<span/>').css({
                    'border': '1px solid #d2d6de',
                    'border-radius': '0',
                    'padding': '3px 0px', //'padding': '3px 12px'
                    'height': '34px',
                    'box-sizing': 'border-box',
                    'cursor': 'pointer',
                    'display': 'block',
                    'height': '28px',
                    'user-select': 'none',
                    '-webkit-user-select': 'none'
                }).attr({
                    'role': 'combobox',
                    'aria-haspopup': 'true',
                    'aria-expanded': 'true',
                    'tabindex': '0'
                });

                $('<span/>').css({
                    'padding-right': '10px',
                    'padding-left': '0',
                    'padding-right': '0',
                    'height': 'auto',
                    'margin-top': '-4px',
                    'color': '#444',
                    'line-height': '28px',
                    'display': 'block',
                    'padding-left': '7px', //'padding-left': '8px'
                    'padding-right': '20px',
                    'overflow': 'hidden',
                    'text-overflow': 'ellipsis',
                    'white-space': 'nowrap',
                    'height': '29px',
                    'font-size': '11px',
                    'font-weight': '500',
                    'font-variant': 'normal'
                }).attr({
                    'role': 'texbox',
                    'aria-readonly': 'true',
                    'title': 'Title',
                    'data-id-mySelected': attrID,
                    'data-selected-value': 'Title'
                }).html('').change(function (event) {
                    console.log(event)
                }).appendTo(b)

                return b
            },
            'next_3': function () {
                var b = $('<span/>').css({
                    'height': '28px',
                    'right': '3px',
                    'height': '26px',
                    'position': 'absolute',
                    'top': '1px',
                    'right': '1px',
                    'width': '20px'
                }).attr({
                    'role': 'presentation'
                })
                $('<b/>').css({
                    'border-color': 'transparent transparent #888 transparent',
                    'border-width': '0 4px 5px 4px',
                    'margin-top': '0',
                    'border-style': 'solid',
                    'height': '0',
                    'left': '50%',
                    'margin-left': '-4px',
                    'margin-top': '-2px',
                    'position': 'absolute',
                    'top': '50%',
                    'width': '0'
                }).attr({
                    'role': 'presentation'
                }).appendTo(b)

                return b
            },
            'next_1': function () {
                return $('<span/>')
            },
            'lastElement': function () {
                return $('<span/>').attr({
                    'class': 'dropdown-wrapper',
                    'aria-hidden': 'true'
                })
            }
        }


        var x = $(this).offset()


        this.each(function () {
            var element = $(this)
            if (element.is('input') || element.is('select')) {
                var parentInput = new InputSelect(element), contentInput = InputSelectContent, check_id = parentInput.attr('data-mySelect-id')
                if (typeof check_id !== 'string')
                    return;
                element.attr('data-' + check_id, '').attr('data-selected', check_id)
                var ch_1 = new contentInput.next_1(), ch_2 = contentInput.next_2(check_id), ch_3 = contentInput.next_3(), ch_4 = contentInput.lastElement(), a = new Resultats(check_id)
                ch_2.appendTo(ch_1);
                ch_3.appendTo(ch_1);
                ch_1.appendTo(parentInput);
                ch_4.appendTo(parentInput);

                parentInput.focusin(function () {
                    var self = this, ev = $(self).InputLoadRequest();
                    data[check_id] = [];
                    if (options && typeof options['selectAJAX'] === 'object') {
                        ajax(check_id, options.selectAJAX.URL, options.selectAJAX.token, function () {
                            showResultat(self, check_id);
                        }, function () {
                            ev.remove();
                        });
                    } else {
                        if (options && typeof options['selectDATA'] === 'object') {
                            for (var _x in options.selectDATA) {
                                if (typeof options.selectDATA[_x] === 'object')
                                    data[check_id].push(options.selectDATA[_x]);
                                else if (typeof options.selectDATA[_x] === 'string')
                                    data[check_id].push(options.selectDATA);
                            }

                        } else if (element.is('select')) {
                            var i__ = [];
                            element.find('option').each(function () {
                                i__.push({ 'value': $(this).html() });
                            })
                            data[check_id] = i__;
                        }
                        showResultat(self, check_id);
                        ev.remove();
                    }

                })
            }
        })
        return options;
    }
    $.fn.extend({ MySelect: Myselect });

})($)
