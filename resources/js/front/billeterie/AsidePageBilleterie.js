import AsidePage from '../app-front/AsidePage';
const HeureItems = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
Vue.component('aside-page-billeterie', {
    mixins: [AsidePage],
    data: function () {
        return {
            port_depart: this.aside.port ? this.aside.port : [],
            port_arrive: this.aside.port ? this.aside.port : [],
            parcours: 1,
            date_depart: '',
            date_arrive: '',
            min_date_depart: new Date(),
            min_date_arrive: new Date()
        }
    },
    watch: {
        'date_depart': function date_depart(newVal, oldVal) {
            if (+newVal != +oldVal) {
                this.min_date_arrive = newVal;
                this.date_arrive = '';
            }
        },
        'date_arrive': function date_arrive(newVal, oldVal) {
            if (+newVal != +oldVal && newVal == '') {
                $('[name="date_arrive"]').each(function () {
                    $(this).val('');
                })
            }
        }
    },
    mounted() {
        var _this5 = this;
        if (_this5.sessionrequest && _this5.sessionrequest.parcours && _this5.sessionrequest.arrive && _this5.sessionrequest.depart && _this5.sessionrequest.date_depart) {
            _this5.parcours = _this5.sessionrequest.parcours;
            _this5.port_arrive = (_this5.aside.port ? _this5.aside.port : []).map(function (_val_1) {
                return _val_1.filter(function (_val_2) {
                    return _val_2.id != _this5.sessionrequest.depart;
                })
            });
            _this5.date_depart = _this5.$parseDate(_this5.sessionrequest.date_depart);
            setTimeout(function () {
                $('[name="arrive"]').each(function () {
                    $(this).val(_this5.sessionrequest.arrive);
                });
            }, 60);
        }
        if (_this5.sessionrequest && _this5.sessionrequest.date_retour) {
            setTimeout(function () {
                _this5.date_arrive = _this5.$parseDate(_this5.sessionrequest.date_retour);
            }, 60);
        }
    },
    methods: {
        checkParcours: function (event) {
            this.parcours = parseInt(event.target.value);
        },
        selectLieu: function (event) {
            var _this5 = this;
            var all_related = [];
            (_this5.aside.port ? _this5.aside.port : []).map(function (_val) {
                _val.map(function (_val_) {
                    if (_val_.id == event.target.value) {
                        all_related = _val_.related_id;
                    }
                })
            });
            _this5.port_arrive = (_this5.aside.port ? _this5.aside.port : []).map(function (_val_1) {
                return _val_1.filter(function (_val_2) {
                    return all_related.includes(_val_2.id)
                    //return _val_2.id != event.target.value;
                })
            });
        },
        parseDateToString: function (_date) {
            return _date == '' ? '' : moment(_date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    },
    props: {

    }
});