import $ from 'jquery';
import './jqueryHelper';

const form = (function ($) {
    var _serialized = function () {
        const forms = {}, form = this;
        if (form.nodeName === 'FORM') {
            const target = form.querySelectorAll("[name]");
            for (const el in target) {
                if (target.hasOwnProperty(el) && typeof target[el] !== 'undefined') {
                    const element = target[el];
                    if (!_isValid.apply(target[el])) break;
                    if (element && element.getAttributeNode('name'))
                        forms[element.getAttributeNode('name').value] = target[el].value;
                }
            }
        }
        return forms;
    };

    var _isValid = function () {
        const element = this;
        if (element.validity.valid) {
            $(element).dettachClass('is-invalid').nextAll("i[class*='fa-warning']").each(function () {
                $(this).remove()
            })
            return true;
        } else {
            $(element).attachClass('is-invalid');
            $(element).nextAll("i[class*='fa-warning']").each(function () {
                $(this).remove()
            })
            $(element).after($('<i/>').attr({
                'id': '#_00',
                'class': 'fa fa-warning',
                'title': element.validationMessage
            }).css({
                'position': 'absolute',
                'top': '9px',
                'right': '16px',
                'color': 'red',
                'z-index': '1'
            }).addTitle('title-warning'));
            return false;
        }
    };
    var _erreur = function () {
        var form = this, error = arguments[0] || {}, i = 0;
        if (typeof form === 'object' && form.nodeName === 'FORM') {
            error = (typeof error.data === 'object' && error.error === 422) ? error.data : (typeof error === 'object' ? error : {});
            for (const x in error) {
                error[x] = typeof error[x] === 'object' ? error[x][0] : error[x];
                var input = $(form).find('input[name="' + x + '"], select[name="' + x + '"], textarea[name="' + x + '"]');
                input.each(function () {
                    var _input = $(this);
                    _input.attachClass('is-invalid');
                    if (_input.nextAll("i[class*='fa-warning']").length)
                        _input.nextAll("i[class*='fa-warning']").each(function () {
                            $(this).remove()
                        })
                    _input.after($('<i/>').attr({
                        'id': '#_00',
                        'class': 'fa fa-warning',
                        'title': error[x]
                    }).css({
                        'position': 'absolute',
                        'top': '9px',
                        'right': '16px',
                        'color': 'red',
                        'z-index': '1'
                    }).addTitle('title-warning'))
                })
            }
        }
    };

    var _removeErreur = function () {
        const form = this, error = arguments[0] || {}, i = 0;
        if (typeof form === 'object' && form.nodeName === 'FORM') {
            var input = $(form).find('input, select, textarea');
            input.each(function () {
                var _input = $(this);
                _input.dettachClass('is-invalid');
                if (_input.nextAll("i[class*='fa-warning']").length)
                    _input.nextAll("i[class*='fa-warning']").each(function () {
                        $(this).remove()
                    });
            })
        }
    };

    var _news = function () {
        const form = this;
        $(form).find('input, select, textarea').each(function () {
            if ($(this).is(':text') || $(this).is('[type="date"]') || $(this).is('[type="email"]') || $(this).is('select') || $(this).is('textarea')) {
                $(this).val('')
            }
            if ($(this).nextAll("i[class*='fa-warning']").length)
                $(this).nextAll("i[class*='fa-warning']").each(function () {
                    $(this).remove()
                })
            if ($(this).is('input[type="checkbox"]')) {
                $(this)[0].checked = false;
                $(this).val($(this)[0].checked ? 1 : 0);
            }

        })

        $(form).find('span[data-id-mySelected]').each(function () {
            if ($(this).is('span')) {
                $(this).attr('title', 'Veuillez selectioner une valeur').html('Sélectionnez ').addTitle()
            }
            if ($(this).nextAll("i[class*='fa-warning']").length)
                $(this).nextAll("i[class*='fa-warning']").each(function () {
                    $(this).remove()
                })

        });
        return this
    };
    var _setForm = function (data) {
        const form = this;
        if (typeof data === 'object' && $(form).is('form')) {
            for (var x in data) {
                var $_input_ = $(form).find('input[name="' + x + '"],select[name="' + x + '"],textarea[name="' + x + '"]')
                //console.log($($_input_).is('input[name="' + x + '"]'))
                if (!$($_input_).is('input[type="checkbox"]') && ($($_input_).is('input[name="' + x + '"]') || $($_input_).is('select[name="' + x + '"]') || $($_input_).is('textarea[name="' + x + '"]'))) {
                    $_input_.val((typeof data[x] !== 'undefined' && data[x] !== null) ? '' + data[x] + ''.trim() : '')
                    if ($_input_.hasAttr('data-selected')) {
                        $('[data-id-myselected="' + $_input_.attr('data-selected') + '"]').html($_input_.val())
                    }
                }
                if ($($_input_).is('input[type="checkbox"]')) {
                    $($_input_)[0].checked = (data[x] && parseInt('' + data[x] + ''.trim()) === 1) ? true : false;
                    $($_input_)[0].value = '' + data[x] + ''.trim();
                }
            }
            if ($(form).hasAttr('data-update') && !$(form).find('input[name="UPDATA"]').length) {
                $('<input/>', { name: 'UPDATE', hidden: 'hidden', value: data[form.attr('data-update')] }).appendTo(form)
            }
        }
        return form;
    };

    const getInstance = function () {
        this.serialized = _serialized.bind(this);
        this.isValid = _isValid.bind(this);
        this.erreur = _erreur.bind(this);
        this.removeErreur = _removeErreur.bind(this);
        this.newForm = _news.bind(this);
        this.setForm = _setForm.bind(this);
        return this
    };

    return function (el) {
        return getInstance.apply(el);
    }

})($)

export default form;