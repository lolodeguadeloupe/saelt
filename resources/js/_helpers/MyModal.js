import $ from 'jquery';
import '../_helpers/jqueryHelper';
import form from '../_helpers/FormHelper';

export const modal = () => {
    return (function ($) {

        $('<style>.MyModal .panel .panel-heading{font: normal normal normal 14px/1 FontAwesome;}</style>').appendTo($('head'));

        var eventOpened = function () {
            $('.MyModal .panel.max').each(function () {
                $(this).css({
                    'width': window.innerWidth - 100 + 'px'
                });
            });
            $('.MyModal .panel.min').each(function () {
                $(this).css({
                    'width': window.innerWidth - 250 + 'px'
                });
            });
        }, _Modal = function () {
            $(this).click(function () {
                $(this).myModal();
            });
        };
        //$(this).resized(this).add(eventOpened);

        $("input[class*='btn-new']").each(function () {
            var $_is = $(this).next("a[class*='input-btn-new']"), title = $(this).hasAttr('btn-title') ? $(this).attr('btn-title') : 'Créer nouveau'
            if (!$_is.hasClass('input-btn-new')) {
                $(this).after('<a class="btn btn-block-inline btn-social input-btn-new" title="' + title + '"><i class="fa fa-plus-circle"></i></a>')
            }
            var $btn = $(this).next("a[class*='input-btn-new']");
            $btn.attr('data-modal', $(this).attr('box'))
        });

        $('[data-modal]').each(_Modal);
        $('[data-dismiss]').each(function () {
            $(this).click(function () {
                $(this).myModal('hide');
            });
        });

        var myModal = function ($_is = '', callback) {
            //console.log($(this))
            var fadeFram = function (index) {
                return $('<div/>', { 'fadeFram': 'show', 'style': 'position:fixed;top:0;right:0;bottom:0;left:0;z-index:' + index + ';display:block;overflow:hidden;-webkit-overflow-scrolling:touch;outline:0;' }).clone(true);
            }

            var $_bt_event = $(this)
            var $_isModal_index = 0;
            var $_isModal_index_next = 0;
            var $_this = $_is == 'hide'
                ?
                $("[tabmodal='" + $(this).attr('data-dismiss') + "']")
                :
                $("[tabmodal='" + $(this).attr('data-modal') + "']");
            if (!$_this)
                return this;
            try {
                $('[tabmodal]').each(function () {
                    $_isModal_index = parseInt($(this).attr('tabindex')) > $_isModal_index ? parseInt($(this).attr('tabindex')) : $_isModal_index;
                })

            } catch (exception) {

            }

            switch ($_is) {
                case 'hide':
                    if (parseInt($_this.attr('tabindex')) == $_isModal_index) {
                        $_this.removeAttr('tabindex').css({ 'display': 'none', 'opacity': 0 }).prevAll('div[fadeFram]').each(function () {
                            $(this).remove();
                        });
                        if (typeof callback === 'function')
                            callback.call(this, { modal: $_this, is: 'hide' }, null)
                    }

                    break;
                default:
                    if (!$_this.attr('tabindex')) {
                        eventOpened.apply(this);
                        if ($_this.find('form').length) {
                            var _req_form = $_this.find('form')[0]
                            if ($($_bt_event).hasAttr('_form_reponse'))
                                $(_req_form).attr('_form_request', $_bt_event.attr('_form_reponse'))
                            if ($(_req_form).is('form'))
                                form(this).newForm(_req_form)
                            //console.log(_req_form)
                            //console.log(_req_form.hasAttribute('data-request'))

                            $_this.attr('tabindex', $_isModal_index + 1).css(
                                {
                                    'z-index': 1000 + $_isModal_index + 1,
                                    'display': 'block',
                                    'opacity': 1,
                                    'outline-width': window.screen.width
                                }
                            ).parent().prepend(new fadeFram(1000 + $_isModal_index + 1));
                            if (typeof callback === 'function')
                                callback.call(this, { modal: $_this, is: 'show' }, null);
                        } else {
                            $_this.attr('tabindex', $_isModal_index + 1).css(
                                {
                                    'z-index': 1000 + $_isModal_index + 1,
                                    'display': 'block',
                                    'opacity': 1,
                                    'outline-width': window.screen.width
                                }
                            ).parent().prepend(new fadeFram(1000 + $_isModal_index + 1));
                            if (typeof callback === 'function')
                                callback.call(this, { modal: $_this, is: 'show' }, null)
                        }
                    }
                    break;
            }
            return $_this

        }

        $.fn.extend({
            myModal: myModal
        })

        var hideModal = function (is, callback) {
            if (typeof is !== 'string')
                return $(this)
            $('<p/>', {
                'data-dismiss': is
            }).myModal('hide', callback)
            return $(this)
        }

        var showModal = function (is, callback) {
            if (typeof is !== 'string')
                return $(this)
            $('<p/>', {
                'data-modal': is
            }).myModal('show', callback)
            return $(this)
        }

        $.fn.extend({
            hideModal: hideModal,
            showModal: showModal
        });

    })($)
}