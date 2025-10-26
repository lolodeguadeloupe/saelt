'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

import './helperJquery';
import './eventClick';
import Myform from './helperForm';
import './controleInput';

/** */
var _moment = require('moment');
var _moment2 = _interopRequireDefault(_moment);
require('moment-timezone');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

const HeureItems = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
const input_not_state = ['ile', 'ville', 'lieu_recuperation', 'lieu_restriction', 'parcours', 'depart', 'arrive', 'personne_', 'retour'];

export default {
    data: function data() {
        return {
            heures: {
                lieu_recuperation_location: HeureItems,
                lieu_restriction_location: HeureItems,
            },
            calendarExclude: {
                lieu_recuperation_location: [],
                lieu_restriction_location: []
            },
            lieu_recuperation_location: '',
            lieu_restriction_location: '',
            times_model: {
                lieu_recuperation_location: { HH: '', mm: '' },
                lieu_restriction_location: { HH: '', mm: '' },
                heure_retour_trans: { HH: '', mm: '' },
                heure_depart_trans: { HH: '', mm: '' }
            },
            /** */
            ville: this.aside.ville ? this.aside.ville : [],
            date_debut: '',
            /* billet */
            port_depart: this.aside.port ? this.aside.port : [],
            port_arrive: this.aside.port ? this.aside.port : [],
            parcours_billet: 1,
            date_depart_billet: '',
            date_arrive_billet: '',
            min_date_depart_billet: new Date(),
            min_date_arrive_billet: new Date(),
            /* transfert */
            heure_retour_trans: HeureItems,
            heure_depart_trans: HeureItems,
            parcours_trans: 1,
            lieu_depart_trans: this.aside.lieu ? this.aside.lieu : [],
            lieu_arrive_trans: this.aside.lieu ? this.aside.lieu : [],
            date_depart_trans: '',
            date_arrive_trans: '',
            min_date_depart_trans: new Date(),
            min_date_arrive_trans: new Date(),

            //
            session_form_input: {},
            //
            action_search: false
        };
    },
    beforeUpdate() {
        var _this5 = this;
        $('.form_customer_search').each(function () {
            var _data = Myform(this).serialized();
            _this5.session_form_input = _data ? _data : _this5.session_form_input;
        });
    },
    updated() {
        var _this5 = this;
        $('.form_customer_search').each(function () {
            var _temp = _this5.session_form_input ? _this5.session_form_input : {};
            for (var k in _temp) {
                if (input_not_state.findIndex((_val) => String(k).substr(0, String(_val).length).includes(_val, 0)) < 0) {
                    delete _temp[k];
                }
            }
            Myform(this).setForm(_temp);
        });
    },
    watch: {
        'date_depart_billet': function date_depart_billet(newVal, oldVal) {
            if (+newVal != +oldVal) {
                this.min_date_arrive_billet = newVal;
                this.date_arrive_billet = '';
            }
        },
        'date_arrive_billet': function date_arrive_billet(newVal, oldVal) {
            if (+newVal != +oldVal && newVal == '') {
                $('[id="date-arrive-bil"]').each(function () {
                    $(this).val('');
                })
            }
        },
        'date_depart_trans': function date_depart_trans(newVal, oldVal) {
            if (+newVal != +oldVal) {
                this.min_date_arrive_trans = newVal;
                this.date_arrive_trans = '';
            }
        },
        'date_arrive_trans': function date_arrive_trans(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal) {
                if (newVal == '') {
                    $('[id="date-arrive-trans"]').each(function () {
                        $(this).val('');
                    })
                }
                if (moment(this.date_arrive_trans).diff(moment(this.date_depart_trans), 'days') <= 0) {
                    _this5.heure_retour_trans = HeureItems.filter(val => parseInt(_this5.times_model.heure_depart_trans.HH) < parseInt(val));
                } else {
                    _this5.heure_retour_trans = HeureItems;
                }
                _this5.times_model.heure_retour_trans = { HH: '', mm: '' };
            }
        },
        'times_model.heure_depart_trans': function times_modelHeure_depart_trans(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal && newVal.HH != '') {
                if (moment(this.date_arrive_trans).diff(moment(this.date_depart_trans), 'days') <= 0) {
                    _this5.heure_retour_trans = HeureItems.filter(val => parseInt(newVal.HH) < parseInt(val));
                } else {
                    _this5.heure_retour_trans = HeureItems;
                }
            }
        },
        /** */
        'lieu_restriction_location': function lieu_restriction_location(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal) {
                if (_this5.$intervalDateDays(newVal, _this5.$parseDate(_this5.lieu_recuperation_location)) == 0 && _this5.times_model.lieu_recuperation_location) {
                    _this5.heures['lieu_restriction_location'] = HeureItems.filter(function (_item_, _index_) {
                        if (typeof _this5.times_model.lieu_recuperation_location == 'object') {
                            return parseInt(_item_) > parseInt(_this5.times_model.lieu_recuperation_location.HH);
                        } else {
                            return parseInt(_item_) > parseInt(String(_this5.times_model.lieu_recuperation_location).split(':')[0]);
                        }
                    });
                    _this5.times_model['lieu_restriction_location'] = { HH: '', mm: '' };
                } else {
                    $('[name="lieu_restriction"]').each(function () {
                        var _el = this;
                        if (String($(this).val()).trim() == "") {
                            return;
                        }
                        _this5.aside.agence_location.map(function (_lieu) {
                            if (_lieu.id == String($(_el).val()).trim()) {
                                const openTime = String(_lieu.heure_ouverture).split(':')[0];
                                const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                                const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                                const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                                const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                                const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                                //
                                _this5.heures['lieu_restriction_location'] = HeureItems.filter(function (_item_, _index_) {
                                    if (indexOT < indexCT) {
                                        return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                                    } else if (indexOT > indexCT) {
                                        return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                                    } else
                                        return true;
                                })
                            }
                        })
                    });
                }
            }
        },
        'lieu_recuperation_location': function lieu_recuperation_location(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal) {
                if (newVal != '' && _this5.lieu_restriction_location != '') {
                    if (moment(newVal).isAfter(_this5.lieu_restriction_location)) {
                        _this5.lieu_restriction_location = '';
                    } else if (newVal != '') {
                        var _temp_day = _this5.$plusDays(newVal, 8);
                        var trouver = false;
                        while (!trouver && _this5.calendarExclude.lieu_recuperation_location[0] != undefined) {
                            if ([..._this5.calendarExclude.lieu_recuperation_location].findIndex(_val => _this5.$intervalDateDays(_temp_day, _val.start) == 0) >= 0) {
                                _temp_day = _this5.$plusDays(_temp_day, 1);
                            } else {
                                trouver = true;
                            }
                        }
                        _this5.lieu_restriction_location = _temp_day;
                    }
                }
            }
        },
        'times_model.lieu_recuperation_location': function times_modelLieu_recuperation_location(newVal, oldVal) {
            var _this5 = this;

            if (+newVal != +oldVal) {
                if (_this5.$intervalDateDays(_this5.$parseDate(_this5.lieu_restriction_location), _this5.$parseDate(_this5.lieu_recuperation_location)) == 0) {
                    _this5.heures['lieu_restriction_location'] = HeureItems.filter(function (_item_, _index_) {
                        if (typeof _this5.times_model.lieu_recuperation_location == 'object') {
                            return parseInt(_item_) > parseInt(_this5.times_model.lieu_recuperation_location.HH);
                        } else {
                            return parseInt(_item_) > parseInt(String(_this5.times_model.lieu_recuperation_location).split(':')[0]);
                        }
                    });
                    _this5.times_model['lieu_restriction_location'] = { HH: '', mm: '' };
                } else {
                    $('[name="lieu_restriction"]').each(function () {
                        var _el = this;
                        if (String($(this).val()).trim() == "") {
                            return;
                        }
                        _this5.aside.agence_location.map(function (_lieu) {
                            if (_lieu.id == String($(_el).val()).trim()) {
                                const openTime = String(_lieu.heure_ouverture).split(':')[0];
                                const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                                const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                                const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                                const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                                const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                                //
                                _this5.heures['lieu_restriction_location'] = HeureItems.filter(function (_item_, _index_) {
                                    if (indexOT < indexCT) {
                                        return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                                    } else if (indexOT > indexCT) {
                                        return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                                    } else
                                        return true;
                                })
                            }
                        })
                    });
                }
            }
        },
    },
    mounted() {
        var _this5 = this;
        /** */
        $('.form_customer_search').each(function () {
            var _data = {};
            var el = this
            if (_this5.sessionrequest && _this5.sessionrequest.customer_search) {
                for (const key in _this5.sessionrequest.customer_search) {
                    _data[key] = _this5.sessionrequest.customer_search[key];
                }
            }
            setTimeout(function () {
                Myform(el).setForm({ ..._data });
            }, 60);
        });
        $('[name="heure_restriction"]').each(function () {
            $(this).attr({
                'required': 'required',
                'pattern': "^\\d{2}:\\d{2}"
            });
        })
        $('[name="heure_recuperation"]').each(function () {
            $(this).attr({
                'required': 'required',
                'pattern': "^\\d{2}:\\d{2}"
            });
        })
        $('[name="heure_retour"]').each(function () {
            $(this).attr({
                'required': 'required',
                'pattern': "^\\d{2}:\\d{2}"
            });
        })
        $('[name="heure_depart"]').each(function () {
            $(this).attr({
                'required': 'required',
                'pattern': "^\\d{2}:\\d{2}"
            });
        });

    },
    methods: {
        hasProduitStatus() {
            var has = false;
            for (var k in this.aside.produit) {
                if (this.aside.produit[k].status == 1) {
                    has = true;
                }
            }
            return has;
        },
        changeIle: function (event) {
            var _this5 = this;
            $(event.target).each(function () {
                var el_val = $(this).val();
                var ile = _this5.aside.ile.filter(function (val) {
                    return String(el_val).split(',').indexOf(String(val.id)) >= 0
                });
                if (ile.length == 1) {
                    _this5.ville = _this5.aside.ville.filter(val => ile[0].pays_id == val.pays_id);
                } else {
                    _this5.ville = _this5.aside.ville;
                }
            })
        },
        searchDataHome: function (event) {
            event.preventDefault();
            var _this5 = this;
            const data = Myform(event.target).serialized();
            if (data == null) return;
            let loading_ = $(event.target).InputLoadRequest();
            let loading = _this5.$loading();
            axios.post(`${_this5.urlbase}/put-request`, {
                ...data,
                customer_search: data
            }).then(function (response) {
                window.location = `${$(event.target).attr('action')}?key_=${response.data.key}`;
            }).catch(function (errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        searchData: function (event) {
            var _this5 = this;
            const data = Myform(event.target).serialized();
            if (data != null) {
                _this5.$parent.$emit('loadData', data);
                _this5.action_search = true;
            }
        },
        managerRequest: function managerRequest(event, url, data = {}) {
            var _this5 = this;
            event.preventDefault();
            let loading_ = $(event.target).InputLoadRequest();
            let loading = _this5.$loading();
            axios.post(`${_this5.urlbase}/put-request`, {
                ...data
            }).then(function (response) {
                window.location = `${url}?key_=${response.data.key}`;
            }).catch(function (errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        selectLieuLocation: function (event, lieu) {
            var _this5 = this;
            _this5.calendarExclude[`${$(event.target).attr('name')}_location`] = [];
            _this5.heures[`${$(event.target).attr('name')}_location`] = HeureItems;
            lieu.map(function (_lieu) {
                if (_lieu.id == $(event.target).val()) {
                    const openTime = String(_lieu.heure_ouverture).split(':')[0];
                    const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                    const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                    const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                    const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                    const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                    //
                    _this5.heures[`${$(event.target).attr('name')}_location`] = HeureItems.filter(function (_item_, _index_) {
                        if (indexOT < indexCT) {
                            return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                        } else if (indexOT > indexCT) {
                            return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                        } else
                            return true;
                    })
                    _this5.calendarExclude[`${$(event.target).attr('name')}_location`] = _lieu.calendar.map(function (_calendar) {
                        return {
                            start: _this5.$parseDate(_calendar.date),
                            end: _this5.$parseDate(_calendar.date)
                        }
                    })
                }
            })
            _this5.times_model[`${$(event.target).attr('name')}_location`] = { HH: '', mm: '' };

            if ($(event.target).attr('name') == 'lieu_recuperation') {
                $('[name="lieu_restriction"]').each(function () {
                    var _el = this;
                    if (String($(this).val()).trim() != "") {
                        return;
                    }
                    lieu.map(function (_val) {
                        if (_val.id == $(event.target).val()) {
                            $(_el).val(_val.id);
                            _this5.calendarExclude['lieu_restriction_location'] = [];
                            _this5.heures['lieu_restriction_location'] = HeureItems;
                            const openTime = String(_val.heure_ouverture).split(':')[0];
                            const halfOT = parseInt(String(_val.heure_ouverture).split(':')[1]);
                            const closeTime = String(_val.heure_fermeture).split(':')[0];
                            const halfCT = parseInt(String(_val.heure_fermeture).split(':')[1]);
                            const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                            const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                            //
                            _this5.heures['lieu_restriction_location'] = HeureItems.filter(function (_item_, _index_) {
                                if (indexOT < indexCT) {
                                    return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                                } else if (indexOT > indexCT) {
                                    return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                                } else
                                    return true;
                            })
                            _this5.calendarExclude['lieu_restriction_location'] = _val.calendar.map(function (_calendar) {
                                return {
                                    start: _this5.$parseDate(_calendar.date),
                                    end: _this5.$parseDate(_calendar.date)
                                }
                            })
                            _this5.times_model['lieu_restriction_location'] = { HH: '', mm: '' };
                        }
                    })
                })
            }
        },
        checkParcoursBillet: function (event) {
            this.parcours_billet = parseInt(event.target.value);
        },
        checkParcoursTrans: function (event) {
            this.parcours_trans = parseInt(event.target.value);
        },
        selectPort: function (event) {
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
                });
            });
        },
        selectLieuTrans: function (event) {
            var _this5 = this;
            var all_related = [];
            (_this5.aside.lieu ? _this5.aside.lieu : []).map(function (_val) {
                _val.map(function (_val_) {
                    if (_val_.id == event.target.value) {
                        all_related = _val_.related_id;
                    }
                })
            });
            _this5.lieu_arrive_trans = (_this5.aside.lieu ? _this5.aside.lieu : []).map(function (_val_1) {
                return _val_1.filter(function (_val_2) {
                    return all_related.includes(_val_2.id)
                    //return _val_2.id != event.target.value;
                });
            });
        },
        parseDateToString: function (_date) {
            return _date == '' ? '' : moment(_date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    },
    props: {
        'url': {
            type: String,
            required: false
        },
        'urlbase': {
            type: String,
            required: false
        },
        'urlasset': {
            type: String,
            required: false
        },
        'aside': {
            type: Object,
            default: function _default() {
                return null;
            }
        },
        'sessionrequest': {
            type: Object,
            default: function _default() {
                return null;
            }
        },
        'keysessionrequest': {
            type: String,
            default: function _default() {
                return '';
            }
        },
        'data': {
            type: Object,
            default: function _default() {
                return null;
            }
        },
    },
    filters: {
        date: function date(date) {
            var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'YYYY-MM-DD';

            var date = (0, _moment2.default)(date);
            return date.isValid() ? date.format(format) : "";
        },
        datetime: function datetime(_datetime) {
            var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'YYYY-MM-DD HH:mm:ss';

            var date = (0, _moment2.default)(_datetime);
            return date.isValid() ? date.format(format) : "";
        },
        time: function time(_time) {
            var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'HH:mm:ss';

            // '2000-01-01' is here just because momentjs needs a date
            var date = (0, _moment2.default)('2000-01-01 ' + _time);
            return date.isValid() ? date.format(format) : "";
        }
    },
};