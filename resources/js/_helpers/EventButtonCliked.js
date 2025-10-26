import $ from "jquery";
import "../_helpers/jqueryHelper";

function generateChars(length) {
    var chars = '';
    for (var i = 0; i < length; i++) {
        var randomChar = Math.floor(Math.random() * 36);
        chars += randomChar.toString(36);
    }

    return chars;
};

(function () {
    var InputLoadRequest = function (option) {
        var _l = 'load-' + generateChars(4), self = $(this);
        if (!self.length) return null;
        $('<i/>').attr({
            'class': 'fa fa-spinner',
            //'loading': _l
        }).css({
            'position': 'relative', //'position': 'absolute',
            //'top': '69%',
            //'left': '50%',
            //'margin-left': '-15px',
            'margin-top': (((parseInt($(this).outerHeight()) - 22) / 2) < 0 ? 0 : ((parseInt($(this).outerHeight()) - 22) / 2)) + 'px', //'margin-top': '-15px',
            'color': 'rgb(36, 216, 83)',
            'font-size': '22px',
            '-webkit-animation': 'fa-spin 2s infinite linear',
            'animation': 'fa-spin 2s infinite linear'
        }
        ).appendTo($('<div/>').attr({
            'loading': _l
        }).css({
            'position': 'absolute',
            'text-align': 'center',
            'margin-top': (-1 * parseInt(self.outerHeight())) - 2 + 'px',
            //'top': parseInt($(this).offset().top),
            'left': (option && option.left) ? option.left : (function () {
                return self.outerCss('parent').left
            })(),
            'width': self.outerWidth(),
            'height': parseInt(self.outerHeight()) + 2,
            'background-color': 'rgba(134, 139, 144, 0)' /*'#868b90bd'*/,
            'z-index': 999
        }).appendTo(self.parent()))

        $(this).resized($(this)).add([function () {
            $('div[loading="' + _l + '"]').each(function () {
                $(this).css({
                    'position': 'absolute',
                    'text-align': 'center',
                    'margin-top': (-1 * parseInt(self.outerHeight())) - 2 + 'px',
                    //'top': parseInt($(this).offset().top),
                    'left': (function () {
                        return self.outerCss('parent').left
                    })(),
                    'width': self.outerWidth(),
                    'height': parseInt(self.outerHeight()) + 2, 
                    'background-color': 'rgba(134, 139, 144, 0)' /*'#868b90bd'*/, 
                    'z-index': 999
                })
            });
        }]);

        return {
            self: $('div[loading="' + _l + '"]'),
            remove: function () {
                $('div[loading="' + _l + '"]').remove()
            }
        }
    }
    $.fn.extend({ InputLoadRequest: InputLoadRequest });
})()