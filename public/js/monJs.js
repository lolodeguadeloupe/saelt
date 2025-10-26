$(document).ready(function () {

    (function ($) {

        function childrenNav() {
            $('.children-nav ._-nav').each(function () {
                $(this).children('.parent').each(function () {
                    $(this).removeClass('active').removeClass('open');
                    $(this).children('li').each(function () {
                        $(this).removeClass('active');
                    })
                })
            })
            var active = $('[href*="' + window.location.pathname + '"]')
            active.each(function () {
                $(this).click(function (event) {
                    event.preventDefault();
                })
                $(this).parent().each(function () {
                    $(this).addClass('active');
                    $(this).parents('li.parent').each(function () {
                        $(this).addClass('active').addClass('open')
                    });
                })

            });

            $('.children-nav').each(function () {
                $(this).mouseenter(function () {
                    $(this).addClass('nav-hover-open');
                });
                $(this).mouseleave(function () {
                    $(this).removeClass('nav-hover-open');
                });
            })
        }

        childrenNav();

        function parentNav() {

            var active = $('[href*="' + window.location.pathname + '"]')
            active.each(function () {
                $(this).addClass('active');
                $(this).parent().each(function () {
                    $(this).parents('.nav-item').each(function () {
                        $(this).addClass('menu-open');
                        $(this).children('a').each(function () {
                            $(this).addClass('active')
                            $(this).click(function (event) {
                                event.preventDefault();
                            })
                        })
                    })
                })

            });
        }
        parentNav();

        $('.children-nav ._-nav .parent').each(function () {
            $(this).click(function () {
                $(this).toggleClass('open')
            });
        })

        //

        $('body').on('click', function (event) {
            if ($(event.target).is($('span.icon-upload-form'))) {
                $(this).find('input:file').each(function () {
                    this.click()
                });
            }
        })

        // tooltip
        $('[data-toggle="tooltip"]').tooltip({html:true});
    })(jQuery)
})