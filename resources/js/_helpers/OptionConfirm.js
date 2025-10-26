import $ from 'jquery'
import '../_helpers/GenerateChar'

export const OptionConfirmation = function (title = 'Title', action) {
    var _i_ = ')]/' + $(this).GenerateChars(4), element = $(this)
    var modal = $('<div/>', {
        'class': 'row justify-content-center MyModal'
    }).append(
        $('<div/>', {
            'class': 'panel panel-default',
            'tabmodal': _i_
        }).clone(true)),
        header = $('<div/>', {
            'class': 'panel-heading',
            'style': 'text-align:center;'
        }).html(' ' + title),
        footer = $('<div/>', {
            'class': 'panel-footer text-right'
        }).append(
            $('<button/>', { 'type': 'button', 'class': 'btn btn-info', 'style': 'float:left;' }).click(function () {
                if (typeof action === 'function')
                    action.apply(this, [modal, false])
                modal.remove()
            }).html('Annuler').clone(true)
        ).append(
            $('<button/>', { 'type': 'button', 'class': 'btn btn-primary', 'style': 'background-color: #e3342f80;' }).click(function () {
                if (typeof action === 'function')
                    action.apply(this, [modal, true])
            }).html('Ok').clone(true)
        )

    header.appendTo(modal.children())
    footer.appendTo(modal.children())
    //console.log(modal)
    modal.appendTo('body')
    $('<p/>', {
        'data-modal': _i_
    }).myModal()
}