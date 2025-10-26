$(function () {
    $(document).ready(function () {
        var arr = ['trans', 'bil'];
        arr.map(function (prefix) {
            $(`#${prefix} .check-parcours`).click(function () {
                if ($(this).hasClass('aller-retour')) {
                    $(`#${prefix} .retour`).show();
                }

                else {
                    $(`#${prefix} .retour`).hide();
                }
            });
        })
    });
});