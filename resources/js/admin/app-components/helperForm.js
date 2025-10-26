import './helperJquery';

const Myform = (function($) {
    var _serialized = function() {
        const forms = {},
            form = this;
        var valid = [true];
        if (form.nodeName === 'FORM') {
            const target = form.querySelectorAll("[name]");
            this.removeErreur();
            for (const el in target) {
                if (target.hasOwnProperty(el) && typeof target[el] !== 'undefined') {
                    const element = target[el],
                        isReadOnly = element.getAttribute('readonly') == "readonly";
                    if (isReadOnly) element.readOnly = false;
                    if (!_isValid.apply(target[el])) valid = false;
                    if (element && element.getAttributeNode('type') && element.getAttributeNode('type').value == 'checkbox') {
                        forms[element.getAttributeNode('name').value] = element.checked ? 1 : 0;
                    } else if (element && element.getAttributeNode('type') && element.getAttributeNode('type').value == 'radio') {
                        //console.log(element, element.checked)
                        if (element.checked) {
                            forms[element.getAttributeNode('name').value] = target[el].value;
                        }
                    } else if (element && element.getAttributeNode('name'))
                        forms[element.getAttributeNode('name').value] = target[el].value;
                    //
                    if (isReadOnly) {
                        element.setAttribute('readonly', 'readonly')
                    }
                }
            }
        }
        return valid ? forms : null;
    };

    var _inputValid = function() {
        const element = this,
            isReadOnly = element.getAttribute('readonly') == "readonly";
        if (isReadOnly) element.readOnly = false;
        const validity = _isValid.apply(element)
        if (isReadOnly) {
            element.setAttribute('readonly', 'readonly')
        }
        return validity;
    }

    var _isValid = function() {
        const element = this;
        if (element.validity.valid) {

            /** this is advantage for admin craftable**/
            $(element).parents('div.form-group').each(function() {
                if($(element).prevAll('.form-control-danger').length == 0){
                    $(this).dettachClass('has-danger').attachClass('has-success');
                }
            });

            $(element).each(function() {
                $(this).dettachClass('form-control-danger').attachClass('form-control-success').nextAll('div.form-control-feedback').each(function() {
                    $(this).remove();
                });
            });
            /** this is advantage for admin craftable**/

            $(element).dettachClass('is-invalid').nextAll("i[class*='fa-warning']").each(function() {
                $(this).remove()
            })
            return true;
        } else {

            /** this is advantage for admin craftable**/
            $(element).parents('div.form-group').each(function() {
                $(this).dettachClass('has-success').attachClass('has-danger')
            });

            $(element).each(function() {
                $(this).dettachClass('form-control-success').attachClass('form-control-danger').each(function() {
                    $(this).after($('<div/>').attr({
                        'class': 'form-control-feedback form-text'
                    }).html(element.validationMessage));
                })
            });
            /** this is advantage for admin craftable**/

            if ($(element).parents('div.form-group').length) return;

            $(element).attachClass('is-invalid');
            $(element).nextAll("i[class*='fa-warning']").each(function() {
                $(this).remove()
            })
            $(element).after($('<i/>').attr({
                'id': '#_00',
                'class': 'fa fa-warning d-none',
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
    var _erreur = function() {
        var form = this,
            error = arguments[0] || {},
            i = 0;
        if (typeof form === 'object' && form.nodeName === 'FORM') {
            error = {...(typeof error.data === 'object' && error.error === 422) ? error.data : (typeof error === 'object' ? error : {}) };
            var error_array = {};
            for (const xx in error) {
                const x = String(xx).split('.');
                for (var i = 0; i < x.length; i++) {
                    error_array[x[i]] = error[xx];
                }
            }
            error = {...error_array, ...error };
            //console.log(error)
            for (const x in error) {
                error[x] = typeof error[x] === 'object' ? error[x][0] : error[x];
                var input = $(form).find('input[name="' + x + '"], select[name="' + x + '"], textarea[name="' + x + '"]');
                //console.log(input)
                input.each(function() {
                    var _input = $(this);

                    /** this is advantage for admin craftable**/
                    _input.parents('div.form-group').each(function() {
                        $(this).dettachClass('has-success').attachClass('has-danger')
                    });

                    _input.each(function() {
                        $(this).dettachClass('form-control-success').attachClass('form-control-danger').each(function() {
                            $(this).after($('<div/>').attr({
                                'class': 'form-control-feedback form-text'
                            }).html(error[x]));
                        })
                    });
                    /** this is advantage for admin craftable**/

                    if (_input.parents('div.form-group').length) return;

                    _input.attachClass('is-invalid');
                    if (_input.nextAll("i[class*='fa-warning']").length)
                        _input.nextAll("i[class*='fa-warning']").each(function() {
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

    var _removeErreur = function() {
        const form = this,
            error = arguments[0] || {},
            i = 0;
        if (typeof form === 'object' && form.nodeName === 'FORM') {
            var input = $(form).find('input, select, textarea');
            input.each(function() {
                var _input = $(this);

                /** this is advantage for admin craftable**/
                _input.parents('div.form-group').each(function() {
                    if($(_input).prevAll('.form-control-danger').length == 0){
                        $(this).dettachClass('has-danger').attachClass('has-success');
                    }
                });

                _input.each(function() {
                    $(this).dettachClass('form-control-danger').attachClass('form-control-success').nextAll('div.form-control-feedback').each(function() {
                        $(this).remove();
                    });
                    $(this).prevAll('div.form-control-feedback').each(function() {
                        $(this).remove();
                    });
                });
                /** this is advantage for admin craftable**/

                _input.dettachClass('is-invalid');
                if (_input.nextAll("i[class*='fa-warning']").length)
                    _input.nextAll("i[class*='fa-warning']").each(function() {
                        $(this).remove()
                    });
            })
        }
    };

    var _news = function() {
        const form = this;
        $(form).find('input, select, textarea').each(function() {
            if ($(this).is(':text') || $(this).is('[type="date"]') || $(this).is('[type="email"]') || $(this).is('select') || $(this).is('textarea')) {
                $(this).val('')
            }
            if ($(this).nextAll("i[class*='fa-warning']").length)
                $(this).nextAll("i[class*='fa-warning']").each(function() {
                    $(this).remove()
                })
            if ($(this).is('input[type="checkbox"]')) {
                $(this)[0].checked = false;
                $(this).val($(this)[0].checked ? 1 : 0);
            }

        })

        $(form).find('span[data-id-mySelected]').each(function() {
            if ($(this).is('span')) {
                $(this).attr('title', 'Veuillez selectioner une valeur').html('Sélectionnez ').addTitle()
            }
            if ($(this).nextAll("i[class*='fa-warning']").length)
                $(this).nextAll("i[class*='fa-warning']").each(function() {
                    $(this).remove()
                })

        });
        return this
    };
    var _setForm = function(data) {
        const form = this;
        if (typeof data === 'object' && $(form).is('form')) {
            for (var x in data) {
                var $_input_ = $(form).find('input[name="' + x + '"],select[name="' + x + '"],textarea[name="' + x + '"]')
                data[x] = (typeof data[x] == 'undefined' || data[x] == null) ? '' : data[x];
                //console.log($($_input_).is('input[name="' + x + '"]'))
                $_input_.each(function() {
                    var element = this;
                    if ($(element).is('input[type="radio"]') && $(element).is('input[name="' + x + '"]')) {
                        if ($(element).is('input[value="' + String(data[x]).trim() + '"]')) {
                            $(element).prop('checked', true)
                            element.checked = true;
                        } else {
                            $(element).prop('checked', false)
                        }

                    } else if ($(element).is('input[type="checkbox"]') && $(element).is('input[name="' + x + '"]')) {
                        $($_input_)[0].checked = (data[x] && parseInt('' + data[x] + ''.trim()) === 1) ? true : false;
                        $($_input_)[0].value = '' + data[x] + ''.trim();
                    } else if ($(element).is('select') && $(element).is('select[name="' + x + '"]')) {
                        $(element).val(String(data[x]).trim());
                        if ($(element).hasAttr('data-selected')) {
                            $('[data-id-myselected="' + $(element).attr('data-selected') + '"]').html($(element).val());
                        }
                    } else if ($(element).is('input[type="date"]') && $(element).is('input[name="' + x + '"]')) {
                        const _date = new Date(String(data[x]));
                        $(element).val(`${_date.getFullYear()}-${("0" + (_date.getMonth() + 1)).slice(-2)}-${("0" + _date.getDate()).slice(-2)}`);
                    } else if (!$(element).is('input[type="radio"]') && !$(element).is('input[type="checkbox"]') && !$(element).is('input[type="date"]') && ($(element).is('input[name="' + x + '"]') || $(element).is('textarea[name="' + x + '"]'))) {
                        $(element).val(String(data[x]).trim());
                    }
                })
            }
            if ($(form).hasAttr('data-update') && !$(form).find('input[name="UPDATA"]').length && typeof data[form.attr('data-update')] != 'undefined' && typeof data[form.attr('data-update')] != null) {
                $('<input/>', { name: 'UPDATE', hidden: 'hidden', value: data[form.attr('data-update')] }).appendTo(form)
            }
        }
        return form;
    };

    const getInstance = function() {
        this.serialized = _serialized.bind(this);
        this.isValid = _inputValid.bind(this);
        this.erreur = _erreur.bind(this);
        this.removeErreur = _removeErreur.bind(this);
        this.newForm = _news.bind(this);
        this.setForm = _setForm.bind(this);
        return this
    };

    return function(el) {
        return getInstance.apply(el);
    }

})(jQuery)

export default Myform;