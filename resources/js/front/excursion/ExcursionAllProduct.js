import SectionPage from '../app-front/SectionPage';

Vue.component('excursion-all-product', {
    mixins: [SectionPage],
    data: function() {
        return {}
    },
    methods: {
        availability: function($string) {
            var _this5 = this;
            if ($string == null || String($string).trim() == '') {
                return [];
            }
            return String($string).split(',').map(val => _this5.$dictionnaire.week_list[val]);
        }
    },
    props: [

    ]
});