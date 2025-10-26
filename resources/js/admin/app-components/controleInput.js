import './helperJquery';
const ignoredControl = ['input.search-autocomplete', '[data-ctr="email"]', '[name="email"]']

function inputKeyUp(el) {
    if (ignored(el)) return false;
    return $(el).is('textarea') || $(el).is(':input');
    //return $(el).is(':text') || $(el).is('textarea') || $(el).is(':password') || $(el).is(':email') || $(el).is(':input');
}

function inputChange(el) {
    if (ignored(el)) return false;
    return $(el).is('select') || $(el).is(':input') || $(el).is(':checkbox') || $(el).is(':radio') || $(el).is(':file') || $(el).is(':image') || $(el).is('input[type="date"]');
    //return $(el).is('select') || $(el).is(':input') || $(el).is(':checkbox') || $(el).is(':radio') || $(el).is(':file') || $(el).is(':image') || $(el).is('input[type="date"]');
}

function ignored(el) {
    var isIgnored = false;
    ignoredControl.map(elmnt => {
        if ($(el).is(elmnt)) {
            isIgnored = true;
        }
    })
    return isIgnored;
}

function regExpInput() {
    $('[data-ctr="phone"]').each(function() {
        //^(\+?)((\d{3}|\d{2}|\d{1})?)(\s?)\d{2}(\s?)\d{2}(\s?)\d{3}(\s?)\d{2}
        if ($(this).attr('pattern') == undefined) {
            $(this).attr({
                'pattern': '^[+0-9\\s]*$',
                'placeholder': 'xxxxxxxxx'
            });

        }
    });

    $('[data-ctr="code-postal"]').each(function() {
        if ($(this).attr('pattern') == undefined) {
            $(this).attr({
                'pattern': '[0-9]*',
                'placeholder': 'xxxx'
            });

        }
    })

    $('[data-ctr="alph-num"]').each(function() {
        if ($(this).attr('pattern') == undefined) {
            $(this).attr({
                'pattern': '[A-Za-z0-9\\s]*'
            });

        }
    });

    $('[data-ctr="alph"]').each(function() {
        if ($(this).attr('pattern') == undefined) {
            $(this).attr({
                'pattern': '[A-Z\\sa-z]*'
            });

        }
    });

    $('[data-ctr="email"]').each(function() {
        if ($(this).attr('pattern') == undefined) {
            $(this).attr({
                'pattern': '[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$'
            });

        }
    })
}

(function() {
    $('body').keyup(function(event) {
        const el = event.originalEvent.target;
        if ($(el) && inputKeyUp(el)) {
            $(el).removeInputErrer();
            $(el).controleInput();
        }
        regExpInput();
    }).change(function(event) {
        const el = event.originalEvent.target;
        if ($(el) && inputChange(el)) {
            $(el).removeInputErrer();
            $(el).controleInput();
        }
        regExpInput();
    }).click(function() {
        regExpInput();
    })
})(jQuery)