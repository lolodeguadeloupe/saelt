import $ from 'jquery';
import '../_helpers/jqueryHelper';
import '../_helpers/jquery.slimscroll'

export const updateMonJS = function () {
    /******* *******/
    $('.slimScrollNavLink').slimscroll({
        alwaysVisible: true,
        'height': window.innerHeight
    });
    /* ******************* */
    $('<style>.active-link{color: aqua !important;}</style>').appendTo($('head'));

    $('.navigation-link li.treeview').each(function () { 
        $(this).on("click", function (e) {
            $('ul.myTree-menu').each(function () {
                $(this).removeClass('dropped')
                $(this).parent().find('.fa.pull-right').addClass('fa-angle-left').removeClass('fa-chevron-down')
            })
            $(this).children('ul.myTree-menu').addClass('dropped');
            $(this).find('.fa.pull-right').addClass('fa-chevron-down').removeClass('fa-angle-left')
            //e.stopPropagation();
            //e.preventDefault();///fa-level-down
        });
    })
    /* **************** */
    $('.navigation-link a[href!="#"]').each(function () {
        $(this).click(function () {
            console.log($(this).length)
            $('.active-link').each(function () {
                $(this).removeClass('active-link');
            });
            $(this).addClass('active-link');
            $(this).parents('li.treeview').children('a').addClass('active-link');
        });
    });
    $('.navigation-link [href]').each(function () {
        if ($(this).hasClass('active-link'))
            $(this).removeClass('active-link')
    });
    var active = $('[href="' + window.location.pathname + '"]')
    active.each(function () {
        $(this).addClass('active-link');
        $(this).parents('li.treeview').children('a').addClass('active-link');
    });
    /**** *********************** */
    // label 
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
    }, _label_remove = function () {
        $(this).parents('div.form-group').find('._label').each(function () {
            $(this).remove();
        })
    };
    $('.form-group input').mouseover(_label).mouseleave(_label_remove).focusin(_label_remove).click(_label_remove);

    var verticalAlin = function () {
        $('.vertical-align').each(function () {
            console.log(this)
            if ($(this).parent().height() - $(this).height())
                $(this).css({
                    'margin-top': ($(this).parent().height() - $(this).height()) / 2,
                    'margin-bottom': ($(this).parent().height() - $(this).height()) / 2
                });
        });
    }
    verticalAlin();



}
