import SectionPage from '../app-front/SectionPage';

Vue.component('location', {
    mixins: [SectionPage],
    data: function() {
        return {}
    },
    mounted() {
        var _this5 = this;
        if (_this5.sessionrequest && _this5.sessionrequest.lieu_restriction && _this5.sessionrequest.lieu_recuperation && _this5.sessionrequest.date_recuperation && _this5.sessionrequest.date_restriction) {
            _this5.action_search = true;
        }
    },
    methods: {
        parseDateToString: function(_date) {
            return _date == '' ? '' : moment(_date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        },
    },
    props: [

    ]
});