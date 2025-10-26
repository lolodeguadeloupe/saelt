import AsidePage from '../app-front/AsidePage';
const HeureItems = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
Vue.component('aside-page-location', {
    mixins: [AsidePage],
    data: function () {
        return {
            heures: {
                lieu_recuperation: HeureItems,
                lieu_restriction: HeureItems
            },
            calendarExclude: {
                lieu_recuperation: [],
                lieu_restriction: []
            },
            lieu_recuperation: '',
            lieu_restriction: '',
            lieu: {
                recuperation: (this.aside && this.aside.agence_location) ? this.aside.agence_location : [],
                restriction: (this.aside && this.aside.agence_location) ? this.aside.agence_location : []
            },
            times_model: {
                lieu_recuperation: { HH: '', mm: '' },
                lieu_restriction: { HH: '', mm: '' }
            },
            /*
            yourData: {
      hh: '03',
      mm: '05',
      ss: '00',
      a: 'am'
    }*/

        }
    },
    watch: {
        'lieu_restriction': function lieu_restriction(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal) {
                if (_this5.$intervalDateDays(newVal, _this5.$parseDate(_this5.lieu_recuperation)) == 0 && _this5.times_model.lieu_recuperation) {
                    _this5.heures['lieu_restriction'] = HeureItems.filter(function (_item_, _index_) {
                        if (typeof _this5.times_model.lieu_recuperation == 'object') {
                            return parseInt(_item_) > parseInt(_this5.times_model.lieu_recuperation.HH);
                        } else {
                            return parseInt(_item_) > parseInt(String(_this5.times_model.lieu_recuperation).split(':')[0]);
                        }
                    });
                    _this5.times_model['lieu_restriction'] = { HH: '', mm: '' };
                } else {
                    $('[name="lieu_restriction"]').each(function () {
                        var _el = this;
                        if (String($(this).val()).trim() == "") {
                            return;
                        }
                        _this5.lieu.restriction.map(function (_lieu) {
                            if (_lieu.id == String($(_el).val()).trim()) {
                                const openTime = String(_lieu.heure_ouverture).split(':')[0];
                                const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                                const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                                const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                                const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                                const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                                //
                                _this5.heures['lieu_restriction'] = HeureItems.filter(function (_item_, _index_) {
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
        'lieu_recuperation': function lieu_recuperation(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal) {
                if (newVal != '' && _this5.lieu_restriction != '') {
                    if (moment(newVal).isAfter(_this5.lieu_restriction)) {
                        _this5.lieu_restriction = '';
                    }
                } else if (newVal != '') {
                    var _temp_day = _this5.$plusDays(newVal, 8);
                    var trouver = false;
                    while (!trouver && _this5.calendarExclude.lieu_restriction[0] != undefined) {
                        if ([..._this5.calendarExclude.lieu_restriction].findIndex(_val => _this5.$intervalDateDays(_temp_day, _val.start) == 0) >= 0) {
                            _temp_day = _this5.$plusDays(_temp_day, 1);
                        } else {
                            trouver = true;
                        }
                    }
                    _this5.lieu_restriction = _temp_day;
                }
            }
        },
        'times_model.lieu_recuperation': function times_modelLieu_recuperation(newVal, oldVal) {
            var _this5 = this;

            if (+newVal != +oldVal) {
                if (_this5.$intervalDateDays(_this5.$parseDate(_this5.lieu_restriction), _this5.$parseDate(_this5.lieu_recuperation)) == 0) {
                    _this5.heures['lieu_restriction'] = HeureItems.filter(function (_item_, _index_) {
                        if (typeof _this5.times_model.lieu_recuperation == 'object') {
                            return parseInt(_item_) > parseInt(_this5.times_model.lieu_recuperation.HH);
                        } else {
                            return parseInt(_item_) > parseInt(String(_this5.times_model.lieu_recuperation).split(':')[0]);
                        }
                    });
                    _this5.times_model['lieu_restriction'] = { HH: '', mm: '' };
                } else {
                    $('[name="lieu_restriction"]').each(function () {
                        var _el = this;
                        if (String($(this).val()).trim() == "") {
                            return;
                        }
                        _this5.lieu.restriction.map(function (_lieu) {
                            if (_lieu.id == String($(_el).val()).trim()) {
                                const openTime = String(_lieu.heure_ouverture).split(':')[0];
                                const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                                const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                                const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                                const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                                const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                                //
                                _this5.heures['lieu_restriction'] = HeureItems.filter(function (_item_, _index_) {
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
        if (_this5.sessionrequest && _this5.sessionrequest.ville_excursion) {
            _this5.lieu.recuperation = _this5.lieu.recuperation.filter(function (_lieu) {
                return _lieu.ville_id == _this5.sessionrequest.ville_excursion;
            });
            _this5.lieu.restriction = _this5.lieu.restriction.filter(function (_lieu) {
                return _lieu.ville_id == _this5.sessionrequest.ville_excursion;
            })
        }
        if (_this5.sessionrequest && _this5.sessionrequest.lieu_restriction && _this5.sessionrequest.lieu_recuperation) {
            //
            _this5.calendarExclude['lieu_recuperation'] = [];
            _this5.heures['lieu_recuperation'] = HeureItems;
            ((_this5.aside && _this5.aside.agence_location) ? _this5.aside.agence_location : []).map(function (_lieu) {
                if (_lieu.id == _this5.sessionrequest.lieu_recuperation) {
                    const openTime = String(_lieu.heure_ouverture).split(':')[0];
                    const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                    const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                    const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                    const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                    const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                    //
                    _this5.heures['lieu_recuperation'] = HeureItems.filter(function (_item_, _index_) {
                        if (indexOT < indexCT) {
                            return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                        } else if (indexOT > indexCT) {
                            return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                        } else
                            return true;
                    })
                    _this5.calendarExclude['lieu_recuperation'] = _lieu.calendar.map(function (_calendar) {
                        return {
                            start: _this5.$parseDate(_calendar.date),
                            end: _this5.$parseDate(_calendar.date)
                        }
                    })
                }
            })
            //
            _this5.calendarExclude['lieu_restriction'] = [];
            _this5.heures['lieu_restriction'] = HeureItems;
            ((_this5.aside && _this5.aside.agence_location) ? _this5.aside.agence_location : []).map(function (_lieu) {
                if (_lieu.id == _this5.sessionrequest.lieu_restriction) {
                    const openTime = String(_lieu.heure_ouverture).split(':')[0];
                    const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                    const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                    const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                    const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                    const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                    //
                    _this5.heures['lieu_restriction'] = HeureItems.filter(function (_item_, _index_) {
                        if (indexOT < indexCT) {
                            return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                        } else if (indexOT > indexCT) {
                            return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                        } else
                            return true;
                    })
                    _this5.calendarExclude['lieu_restriction'] = _lieu.calendar.map(function (_calendar) {
                        return {
                            start: _this5.$parseDate(_calendar.date),
                            end: _this5.$parseDate(_calendar.date)
                        }
                    })
                }
            })
            setTimeout(function () {
                $('[name="lieu_recuperation"]').each(function () {
                    $(this).val(_this5.sessionrequest.lieu_recuperation)
                })
                $('[name="lieu_restriction"]').each(function () {
                    $(this).val(_this5.sessionrequest.lieu_restriction)
                })
            }, 60);
        }
        if (_this5.sessionrequest && _this5.sessionrequest.date_recuperation) {
            _this5.lieu_recuperation = _this5.$parseDate(_this5.sessionrequest.date_recuperation);
        }
        if (_this5.sessionrequest && _this5.sessionrequest.date_restriction) {
            _this5.lieu_restriction = _this5.$parseDate(_this5.sessionrequest.date_restriction);
        }

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
    },
    methods: {
        selectLieu: function (event, lieu) {
            var _this5 = this;
            _this5.lieu.recuperation.map(function (_val) {
                if (_val.id == $(event.target).val()) {
                    _this5.lieu.lieu_recuperation = _val;
                }
            })
            _this5.calendarExclude[$(event.target).attr('name')] = [];
            _this5.heures[$(event.target).attr('name')] = HeureItems;
            lieu.map(function (_lieu) {
                if (_lieu.id == $(event.target).val()) {
                    const openTime = String(_lieu.heure_ouverture).split(':')[0];
                    const halfOT = parseInt(String(_lieu.heure_ouverture).split(':')[1]);
                    const closeTime = String(_lieu.heure_fermeture).split(':')[0];
                    const halfCT = parseInt(String(_lieu.heure_fermeture).split(':')[1]);
                    const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                    const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                    //
                    _this5.heures[$(event.target).attr('name')] = HeureItems.filter(function (_item_, _index_) {
                        if (indexOT < indexCT) {
                            return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                        } else if (indexOT > indexCT) {
                            return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                        } else
                            return true;
                    })
                    _this5.calendarExclude[$(event.target).attr('name')] = _lieu.calendar.map(function (_calendar) {
                        return {
                            start: _this5.$parseDate(_calendar.date),
                            end: _this5.$parseDate(_calendar.date)
                        }
                    })
                }
            })
            _this5.times_model[$(event.target).attr('name')] = { HH: '', mm: '' };

            if ($(event.target).attr('name') == 'lieu_recuperation') {
                $('[name="lieu_restriction"]').each(function () {
                    var _el = this;
                    if (String($(this).val()).trim() != "") {
                        return;
                    }
                    _this5.lieu.restriction.map(function (_val) {
                        if (_val.id == $(event.target).val()) {
                            $(_el).val(_val.id);
                            _this5.calendarExclude['lieu_restriction'] = [];
                            _this5.heures['lieu_restriction'] = HeureItems;
                            const openTime = String(_val.heure_ouverture).split(':')[0];
                            const halfOT = parseInt(String(_val.heure_ouverture).split(':')[1]);
                            const closeTime = String(_val.heure_fermeture).split(':')[0];
                            const halfCT = parseInt(String(_val.heure_fermeture).split(':')[1]);
                            const indexOT = HeureItems.findIndex(_val_ => String(_val_) == String(openTime));
                            const indexCT = HeureItems.findIndex(_val_ => String(_val_) == String(closeTime));
                            //
                            _this5.heures['lieu_restriction'] = HeureItems.filter(function (_item_, _index_) {
                                if (indexOT < indexCT) {
                                    return (halfOT > 0 ? _index_ > indexOT : _index_ >= indexOT) && (halfCT > 0 ? _index_ <= indexCT : _index_ < indexCT);
                                } else if (indexOT > indexCT) {
                                    return (halfOT > 0 ? _index_ >= indexOT : _index_ > indexOT) && (halfCT > 0 ? 0 <= _index_ <= indexCT : 0 <= _index_ < indexCT);
                                } else
                                    return true;
                            })
                            _this5.calendarExclude['lieu_restriction'] = _val.calendar.map(function (_calendar) {
                                return {
                                    start: _this5.$parseDate(_calendar.date),
                                    end: _this5.$parseDate(_calendar.date)
                                }
                            })
                            _this5.times_model['lieu_restriction'] = { HH: '', mm: '' };
                        }
                    })
                })
            }
        },
        parseDateToString: function (_date) {
            return _date == '' ? '' : moment(_date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        },
    },
    props: {

    }
});