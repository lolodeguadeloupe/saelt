import AsidePage from '../app-front/AsidePage';
const HeureItems = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
Vue.component('aside-page-transfert', {
    mixins: [AsidePage],
    data: function() {
        return {
            lieu_depart: this.aside.lieu ? this.aside.lieu : [],
            lieu_arrive: this.aside.lieu ? this.aside.lieu : [],
            parcours: 1,
            date_depart: '',
            date_arrive: '',
            min_date_depart: new Date(),
            min_date_arrive: new Date(),
            heure_depart: HeureItems,
            heure_retour: HeureItems,
            times_model: {
                heure_retour: { HH: '', mm: '' },
                heure_depart: { HH: '', mm: '' }
            }
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
            var _this5 = this;
            if (+newVal != +oldVal) {
                if (newVal == '') {
                    $('[name="date_arrive"]').each(function() {
                        $(this).val('');
                    })
                }
                if (moment(this.date_arrive).diff(moment(this.date_depart), 'days') <= 0) {
                    _this5.heure_retour = HeureItems.filter(val => parseInt(_this5.times_model.heure_depart.HH) < parseInt(val));
                } else {
                    _this5.heure_retour = HeureItems;
                }
                _this5.times_model.heure_retour = { HH: '', mm: '' };
            }
        },
        'times_model.heure_depart': function times_modelHeure_depart(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal && newVal.HH != '') {
                if (moment(this.date_arrive).diff(moment(this.date_depart), 'days') <= 0) {
                    _this5.heure_retour = HeureItems.filter(val => parseInt(newVal.HH) < parseInt(val));
                } else {
                    _this5.heure_retour = HeureItems;
                }
            }
        }
    },
    mounted() {
        var _this5 = this;
        console.log(_this5.sessionrequest)
        if (_this5.sessionrequest && _this5.sessionrequest.parcours && _this5.sessionrequest.retour && _this5.sessionrequest.depart && _this5.sessionrequest.date_depart && _this5.sessionrequest.heure_depart) {
            _this5.parcours = _this5.sessionrequest.parcours;
            _this5.lieu_arrive = (_this5.aside.lieu ? _this5.aside.lieu : []).map(function(_val_1) {
                return _val_1.filter(function(_val_2) {
                    return _val_2.id != _this5.sessionrequest.depart;
                })
            });
            _this5.date_depart = _this5.$parseDate(_this5.sessionrequest.date_depart);
            setTimeout(function() {
                $('[name="retour"]').each(function() {
                    $(this).val(_this5.sessionrequest.retour);
                })
            }, 60);
        }
        if (_this5.sessionrequest && _this5.sessionrequest.date_retour && _this5.sessionrequest.heure_retour) {
            setTimeout(function() {
                _this5.date_arrive = _this5.$parseDate(_this5.sessionrequest.date_retour);
            }, 60);
        }
    },
    updated() {
        $('[name="heure_retour"]').each(function() {
            $(this).attr({
                'required': 'required',
                'pattern': "^\\d{2}:\\d{2}"
            });
        })
        $('[name="heure_depart"]').each(function() {
            $(this).attr({
                'required': 'required',
                'pattern': "^\\d{2}:\\d{2}"
            });
        })
    },
    methods: {
        checkParcours: function(event) {
            this.parcours = parseInt(event.target.value);
        },
        selectLieu: function(event) {
            var _this5 = this;
            var all_related = [];
            (_this5.aside.lieu ? _this5.aside.lieu : []).map(function(_val) {
                _val.map(function(_val_) {
                    if( _val_.id == event.target.value){
                        all_related = _val_.related_id;
                    }
                })
            });
            _this5.lieu_arrive = (_this5.aside.lieu ? _this5.aside.lieu : []).map(function(_val_1) {
                return _val_1.filter(function(_val_2) {
                    return all_related.includes(_val_2.id)
                    //return _val_2.id != event.target.value;
                })
            }); 
        },
        parseDateToString: function(_date) {
            return _date == '' ? '' : moment(_date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    },
    props: {

    }
});