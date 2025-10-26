import $ from 'jquery';
(function ($) {
    
    var generateChars = function (length) {
        var chars = '';
        for (var i = 0; i < length; i++) {
            var randomChar = Math.floor(Math.random() * 36);
            chars += randomChar.toString(36);
        }

        return chars;
    }
    $.fn.extend({ GenerateChars: generateChars });
})($);