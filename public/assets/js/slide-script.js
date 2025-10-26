$(function() {
    var input_slide = ['price', 'price-heb', 'price-exc'];
    input_slide.map(function(_id) {
        $(`#${_id}`).each(function() {
            var _this = this;

            var val = String($(this).val()).split(','),
                val_min = 5,
                val_max = 1000,
                data_value = val.length == 2 ? val.map(function(_val_) {
                    return parseInt(_val_)
                }) : [val_min, val_max];

            $(_this).slider({
                id: 'slider-price',
                min: val_min,
                max: val_max,
                step: 5,
                //tooltip: 'always',
                tooltip_split: true,
                value: [...data_value],
                formatter: function(value) {
                    if (!$.isArray(value)) {
                        value = '€ ' + value;
                    } else {
                        $('#price-min').html(value[0]);
                        $('#price-max').html(value[1]);
                    }
                    return value;
                }
            });
        })
    })
});