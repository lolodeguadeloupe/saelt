$(function () {
    $(document).scroll(function () {
        var nav = $(".navbar.fixed-top");
        nav.toggleClass('scrolled', $(this).scrollTop() > nav.height());
    });
});

$(function () {
    var tab_ref = String(window.location.href).split('#');
    if (tab_ref.length == 2) {
        if (tab_ref[1] == '') return;
        $(`[href="#${tab_ref[1]}"]`).each(function () {
            $(this).parents('ul').each(function () {
                $(this).find($('[role="tab"]')).each(function () {
                    $(this).removeClass('active');
                    $(this).attr('aria-selected', 'false');
                    //
                    $(`${$(this).attr('href')}`).each(function () {
                        $(this).removeClass('show active');
                    })
                })
            })

            if ($(this).attr('role') != undefined && $(this).attr('role') == 'tab') {
                $(this).addClass('active');
                $(this).attr('aria-selected', 'true');
            }
            $(`#${tab_ref[1]}`).each(function () {
                $(this).addClass('show active');
            })
        })
    } else {
        var has_active = false;
        $('[data-toggle="tab"]').each(function () {
            if (has_active == false) {
                has_active = $(this).hasClass('active');
            }
        })
        if ($('[data-toggle="tab"]')[0] != undefined && has_active == false) {
            $($('[data-toggle="tab"]')[0]).each(function () {
                $(this).addClass('active');
                console.log(`${$(this).attr('href')}`)
                $(`${$(this).attr('href')}`).each(function () {
                    $(this).addClass('show active');
                })
            });
        }
    }
});