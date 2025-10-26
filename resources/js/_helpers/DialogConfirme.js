import $ from 'jquery';
import '../_helpers/jqueryHelper';
import form from './FormHelper';

export const ConfirmeDialog = function (title = 'Title', attr, action) {
    var _i_ = ')]/' + $(this).GenerateChars(4), element = $(this), fn = function (t, at, act, form) {
        this.boucle = function () {
            form.remove();
            ConfirmeDialog(t, at, act);
        }
    }
    var modal = $('<div/>', {
        'class': 'row justify-content-center MyModal'
    }).append(
        $('<div/>', {
            'class': 'panel panel-default',
            'tabmodal': _i_
        }).clone(true)),
        header = $('<div/>', {
            'class': 'panel-heading fa-newspaper-o'
        }).html(title).append(
            $('<div/>', {
                'class': 'pull-right box-tools btn-remove'
            }).append(
                $('<button/>', {
                    'type': 'button',
                    'class': 'btn btn-danger btn-sm',
                    'data-dismiss': _i_
                }).html('<i class="fa fa-times"></i>').click(function () {
                    if (typeof action === 'function')
                        action.apply(this, [null, modal, new fn(title, attr, action, modal)])
                }).clone(true)
            ).clone(true)),
        body = $('<div/>', {
            'class': 'panel-body'
        }).append(
            $('<form/>', {
                'id': _i_
            }).html('<div class="table-responsive"></div>').clone(true)
        ),
        footer = $('<div/>', {
            'class': 'panel-footer text-right'
        }).click(function () {
            var _y = body.find('form');
            if (!_y.length) return;
            var obj = form(_y[0]).serialized();
            if (obj) {
                action.apply(this, [obj, modal, new fn(title, attr, action, modal)])
            }
        }).html('<button type="button" class="btn btn-primary">Valider</button>')

    header.appendTo(modal.children())
    body.appendTo(modal.children())
    footer.appendTo(modal.children())
    //console.log(modal)
    modal.appendTo('body')

    var table = $('<table/>', {
        'class': 'table table-striped table-bordered table-hover'
    })
    if (typeof attr === 'object') {
        var l = 0
        while (attr[l]) {
            if (typeof attr[l] === 'object') {
                var atr = {}
                if (typeof attr[l].type === 'string')
                    atr['type'] = attr[l].type
                if (typeof attr[l].pattern === 'string')
                    atr['pattern'] = attr[l].pattern
                if (typeof attr[l].required === 'string')
                    atr['required'] = attr[l].required
                if (typeof attr[l].minlength === 'string')
                    atr['minlength'] = attr[l].minlength
                if (typeof attr[l].maxlength === 'string')
                    atr['maxlength'] = attr[l].maxlength
                if (typeof attr[l].value === 'string')
                    atr['value'] = attr[l].value
                if (typeof attr[l].hidden === 'string')
                    atr['hidden'] = ""
                atr['class'] = 'form-control'
                atr['name'] = attr[l].name.replace(/ /g, "_")
                table.append(
                    $('<tr/>').append(
                        $('<td/>').append(
                            $('<div/>', {
                                'class': 'form-group'
                            }).append(
                                $('<label/>', {
                                    'class': 'col-sm-3 control-label'
                                }).html(attr[l].label).clone(true)
                            ).append(
                                $('<div/>', {
                                    'class': 'col-sm-9'
                                }).append(
                                    $('<input/>', atr).controleInput().keyup(function () {
                                        $(this).removeInputErrer()
                                    }).clone(true)
                                ).clone(true)
                            ).clone(true)
                        ).clone(true)
                    ).clone(true)
                )
            }
            l++
        }
    }
    table.appendTo(body.find('div'))
    $('<p/>', {
        'data-modal': _i_
    }).myModal();
}