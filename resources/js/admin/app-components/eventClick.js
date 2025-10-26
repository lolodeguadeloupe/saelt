import './helperJquery';

function generateChars(length) {
    var chars = '';
    for (var i = 0; i < length; i++) {
        var randomChar = Math.floor(Math.random() * 36);
        chars += randomChar.toString(36);
    }

    return chars;
};

(function($) {
    var InputLoadRequest = function(option) {
        var _l = 'load-' + generateChars(4),
            self = $(this);
        if (!self.length || $(self).find('div[loading]').length > 0) return null;
        if (self.css('position') != 'absolute') self.css({ 'position': 'relative' })
        $('<style>.fa.' + _l + 'spinner::before{font-size:' + (parseInt(self.outerHeight()) > 150 ? 100 : parseInt(self.outerHeight())) + 'px}</style>').appendTo(
            $('<i/>').attr({
                'class': 'fa fa-spinner ' + _l + 'spinner',
                //'loading': _l
            }).css({
                'margin': 'auto',
                'color': 'rgb(36, 216, 83)',
                'font-size': '22px',
                '-webkit-animation': 'fa-spin 2s infinite linear',
                'animation': 'fa-spin 2s infinite linear'
            }).appendTo($('<div/>').attr({
                'loading': _l
            }).css({
                'position': 'absolute',
                'top': 0,
                'left': 0,
                'display': 'flex',
                'align-items': 'center',
                'width': '100%',
                'height': '100%',
                'background-color': 'rgba(134, 139, 144, 0)' /*'#868b90bd'*/ ,
                'z-index': self.attr('z-index') ? parseInt(self.attr('z-index')) + 12 : 12
            }).click(function(event) {
                event.stopPropagation();
            }).appendTo(self))
        )

        return {
            self: $('div[loading="' + _l + '"]'),
            remove: function() {
                $('div[loading="' + _l + '"]').remove();
            }
        }
    }
    $.fn.extend({ InputLoadRequest: InputLoadRequest });
})(jQuery)