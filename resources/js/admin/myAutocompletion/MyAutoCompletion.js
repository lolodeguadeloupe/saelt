import '../app-components/helperJquery';
const MyAutocomplete = (function ($) {

    var _container = (function () {
        return $('<div/>').attr({ class: 'autocomplete-container' });
    })(),
        _searchContent = (function () {
            return $('<div/>').attr({ class: 'autocomplete-search-content' });
        })(),
        _searchInput = (function () {
            return $('<input/>').attr({ class: 'search-autocomplete', placeholder: 'Veuillez saisir un mot' });
        })(),
        content_info = function (datas = []) {
            var __container = $('<div/>').addClass('autocomplete-content-list-info');
            var _info_content = $('<ul/>').appendTo(__container);
            datas.map(function (data) {
                $($('<li/>').html(String(data))).appendTo(_info_content);
            });
            return __container;
        },
        _content = (function () {
            return $('<div/>').attr({ class: 'autocomplete-content' });
        })(),
        compile_content = function (options, datas = [], fnSelectItem, active = { key: '', label: '', inputlabel: '', inputkey: '' }, detailInfo = [], formateDetailInfo) {
            var content_ul = $('<ul/>');
            var _forms = options.form;
            var input_label = $(_forms).find('input[name="' + active.inputlabel + '"]');
            var input_key = $(_forms).find('input[name="' + active.inputkey + '"]');
            datas.map(function (data) {
                var isactive = false;
                input_key.each(function () {
                    var _val_key = $(this).val();
                    isactive = (data[active.key] && _val_key == data[active.key]) ? true : false
                })
                var content_li = $('<li/>').attr({
                    class: isactive ? 'active item-autocomplete' : 'item-autocomplete'
                }).on('click', function () {
                    content_ul.children().each(function () {
                        $(this).removeClass('active');
                    })
                    $(this).addClass('active')

                    input_label.each(function () {
                        $(this).val(data[active.label] ? data[active.label] : '')
                        $(this).removeInputErrer();
                    })
                    input_key.each(function () {
                        $(this).val(data[active.key] ? data[active.key] : '')
                        $(this).removeInputErrer();
                    })

                    if (fnSelectItem) {
                        fnSelectItem(data);
                    }
                    $(this).parents('.autocomplete-container').each(function () {
                        $(this).remove();
                    })
                }).html(data[active.label]);

                content_li.appendTo(content_ul);

                var info_content = "";
                if (formateDetailInfo) {
                    info_content = formateDetailInfo(data)
                } else {
                    var __info = [...detailInfo];
                    __info = __info.map(function (_datainfo) {
                        const _obj_info = String(_datainfo).split('.');
                        var _my_info = _datainfo,
                            _objs = data;
                        _obj_info.map((_obj_, index) => {
                            //console.log(_obj_)
                            if (_objs != null)
                                _objs = _objs[_obj_] ? _objs[_obj_] : null;
                        })
                        return _objs != null ? _objs : _my_info;
                    })
                    info_content = content_info(__info);
                }
                if (info_content && info_content.nodeType != 'undefined') {
                    $(info_content).appendTo(content_li);
                }
            });
            return content_ul;
        },

        _myAutocomplete = function (options) {
            var _this888 = this;
            $(this).parents('form').each(function () {
                var _form = this;
                /* */
                $(_this888).on('focusin', function (event) {
                    /* */
                    if (!$(_this888).hasClass('auto-complete-attach')) {
                        $('body').on('click', function (event) {
                            if (!$(event.originalEvent.target).parents('.autocomplete-container').length) {
                                $(_this888).parent().find('.autocomplete-container').each(function () {
                                    if (!$(this).hasClass('focus-autocomplete'))
                                        $(this).remove();
                                });
                            }
                        })
                    }
                    var $searchInputContent = _searchContent.clone(true);
                    var $searchInputUi = _searchInput.clone(true);
                    var $container = _container.clone(true);
                    var $content = _content.clone(true);
                    var btn_new = $('<span/>').attr({ class: 'autocomplete-btn-new' });
                    $searchInputUi.appendTo($searchInputContent);
                    $searchInputContent.appendTo($container);
                    $content.appendTo($container);
                    $container.appendTo($(_this888).parent());
                    $searchInputUi.focus();
                    $(_this888).parent().find('.autocomplete-container').each(function () {
                        $(this).addClass('focus-autocomplete')
                    });
                    $searchInputUi.on('focusout', function () {
                        $(_this888).parent().find('.autocomplete-container').each(function () {
                            $(this).removeClass('focus-autocomplete')
                        });
                    });

                    /* */

                    $searchInputUi.on('keyup', function (event) {
                        if (options.ajax) {
                            let loading = $(_this888).parent().InputLoadRequest();
                            if (loading) {
                                loading.self.css({ 'z-index': '110' });
                            }
                            options.ajax.post(options.attrs.action, { search: event.target.value, ...options.dataRequest })
                                .then(function (response) {
                                    $content.children().each(function () {
                                        $(this).remove();
                                    });
                                    compile_content({
                                        form: _form,
                                    },
                                        response.data.search,
                                        options.fnSelectItem, {
                                        key: options.attrs.autokey,
                                        label: options.attrs.label,
                                        inputkey: options.attrs.inputkey ? options.attrs.inputkey : options.attrs.autokey,
                                        inputlabel: options.attrs.inputlabel ? options.attrs.inputlabel : options.attrs.label
                                    },
                                        options.detailInfo,
                                        options.formateDetailInfo
                                    ).appendTo($content);
                                    btn_new.html(options.dict.btn_new_autocomplete);
                                    btn_new.on('click', function (event) {
                                        //console.log($searchInputUi.val(), $searchInputUi)
                                        /*$(_this888).each(function() {
                                            $(this).focus();
                                            $(this).val($searchInputUi.val())
                                        });
                                        $(_form).find('input[name="' + options.attrs.inputkey + '"]').each(function() {
                                            $(this).val('');
                                        });

                                        $(_form).find('input[name="' + options.attrs.inputlabel + '"]').each(function() {
                                            $(this).val($searchInputUi.val());
                                        });*/

                                        $(_this888).parent().find('.autocomplete-container').each(function () {
                                            $(this).remove();
                                        });
                                        /* */
                                        var _auto_input = options.attrs.label != undefined ? String(options.attrs.label).split('_') : [''];
                                        if (_auto_input.length > 0) {
                                            _auto_input = _auto_input[_auto_input.length - 1]
                                        } else {
                                            _auto_input = '';
                                        }
                                        /** */
                                        const y = document.getElementsByTagName("body")[0];
                                        y.addEventListener("click", bodyClick);

                                        function bodyClick(event) {
                                            if ($(event.target).is(`input[name="${_auto_input}"]`)) {
                                                $(event.target).val($searchInputUi.val());
                                                y.removeEventListener("click", bodyClick);
                                            }
                                        }


                                        if (options.fnBtnNew) {
                                            var __options = {
                                                key: options.attrs.autokey,
                                                label: options.attrs.label,
                                                inputkey: options.attrs.inputkey ? options.attrs.inputkey : options.attrs.autokey,
                                                inputlabel: options.attrs.inputlabel ? options.attrs.inputlabel : options.attrs.label,
                                                form: _form
                                            };
                                            options.fnBtnNew(event, __options);
                                        }
                                    });
                                    if (options.fnBtnNewEnable) {
                                        btn_new.appendTo($content);
                                    }
                                },
                                    function (error) {
                                        if (options.frame)
                                            options.frame.$notify({ type: 'error', title: `${options.frame.$dictionnaire.error}!`, text: error.response.data.message ? error.response.data.message : `${options.frame.$dictionnaire.error_occured}.` });
                                    }).finally(function () {
                                        if (loading) {
                                            loading.remove();
                                        }
                                    });
                        }
                    });
                });
                /*  */


            });
            return this;
        }

    const getInstance = function () {
        this.readed = _myAutocomplete.bind(this);
        return this
    };

    return function (el) {
        return getInstance.apply(el);
    }
})(jQuery)

export default MyAutocomplete;