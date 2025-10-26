import SectionPage from '../app-front/SectionPage';
import Myform from '../app-front/helperForm';
const HeureItems = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'];
Vue.component('location-product', {
    mixins: [SectionPage],
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
            accepted: false,
            date_commande: null,
            assurance: [],
            item: null,
            initial_state: true,
            load_request_location: false,
            //item.search_condition? $parseDateToString(item.search_condition.date_recuperation):'',
            min_calendar: new Date(),
            max_calendar: new Date(),
            marge_calculer: 0
        }
    },
    watch: {
        'item': function item(newVal, oldVal) {
            if (+newVal != +oldVal) {
                var _this5 = this;
                $('[name="lieu_recuperation"]').each(function () {
                    $(this).val(newVal.search_condition.lieu_recuperation);
                    _this5.calendarExclude['lieu_recuperation'] = [];
                    _this5.heures['lieu_recuperation'] = HeureItems;
                    _this5.lieu.restriction.map(function (_lieu) {
                        if (_lieu.id == newVal.search_condition.lieu_recuperation) {
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
                    _this5.times_model['lieu_recuperation'] = { HH: '', mm: '' };
                });
                $('[name="lieu_restriction"]').each(function () {
                    $(this).val(newVal.search_condition.lieu_restriction);
                    _this5.calendarExclude['lieu_restriction'] = [];
                    _this5.heures['lieu_restriction'] = HeureItems;
                    _this5.lieu.restriction.map(function (_lieu) {
                        if (_lieu.id == newVal.search_condition.lieu_restriction) {
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
                    _this5.times_model['lieu_restriction'] = { HH: '', mm: '' };
                });
                _this5.lieu_recuperation = newVal.search_condition.date_recuperation;
                _this5.lieu_restriction = newVal.search_condition.date_restriction;
                _this5.times_model.lieu_recuperation = newVal.search_condition.heure_recuperation;
                _this5.times_model.lieu_restriction = newVal.search_condition.heure_restriction;
                _this5.marge_calculer = parseFloat(newVal.tarif_location.marge) * parseFloat(newVal.jours);
            }
        },
        'lieu_recuperation': function lieu_recuperation(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal && _this5.load_request_location == false) {
                _this5.$promise(function () {
                    _this5.checkTarif();
                });
            }
            if (+newVal != +oldVal) {
                if (newVal != '' && _this5.lieu_restriction != '') {
                    if (moment(newVal).isAfter(_this5.lieu_restriction)) {
                        _this5.lieu_restriction = '';
                    }
                }
            }
        },
        'times_model.lieu_recuperation': function times_modelLieu_recuperation(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal && _this5.load_request_location == false) {
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
                    _this5.lieu.restriction.map(function (_lieu) {
                        if (_lieu.id == _this5.item.search_condition.lieu_restriction) {
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
                }
                _this5.$promise(function () {
                    _this5.checkTarif();
                });
            }
        },
        'lieu_restriction': function lieu_restriction(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal && _this5.load_request_location == false) {
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
                    _this5.lieu.restriction.map(function (_lieu) {
                        if (_lieu.id == _this5.item.search_condition.lieu_restriction) {
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
                }
                _this5.$promise(function () {
                    _this5.checkTarif();
                });
            }
        },
        'times_model.lieu_restriction': function times_modelLieu_restriction(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal && _this5.load_request_location == false) {
                _this5.$promise(function () {
                    _this5.checkTarif();
                });
            }
        }
    },
    created() {
        var _this5 = this;
        if (this.mycommande.length > 0 && this.editpannier == 'true') {
            const myCommande = JSON.parse(this.mycommande[0].data);
            for (var _data in myCommande) {
                this[_data] = myCommande[_data];
            }
            _this5.date_commande = _this5.mycommande[0].date_commande;
        }
        /** check min max calendar */
        _this5.saisons.map(function (_saison) {

            var k = 0;
            if (moment(_this5.min_calendar).isAfter(_saison.debut)) {
                _this5.min_calendar = _this5.$parseDate(_saison.debut);
            }

            if (moment(_this5.max_calendar).isBefore(_saison.fin)) {
                _this5.max_calendar = _this5.$parseDate(_saison.fin);
            }
        });
        /** check min max calendar */
    },
    computed: {
        prixTotal() {
            var total_assurance = 0,
                _this5 = this;
            this.assurance.map(function (_assurance) {
                total_assurance = total_assurance + (_assurance.value * ((_this5.item.search_condition.date_recuperation != undefined && _this5.item.search_condition.date_restriction != undefined) ? _this5.$intervalDateDays(_this5.item.search_condition.date_recuperation, _this5.item.search_condition.date_restriction) : 0));
            })
            return this.item.prixTotal + total_assurance;
        }
    },
    mounted() {
        var _this5 = this;
        /** set form */
        if (_this5.mycommande.length > 0 && _this5.editpannier == 'true') {
            $('#reservetion_form').each(function () {
                Myform(this).setForm(_this5.mycommande[0].form);
            });
        }
        _this5.assurance.map(function (_assurance) {
            $(`#${_assurance.assurance}`).each(function () {
                $(this).prop('checked', true);
            })
        })
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
        $('body').click(function () {
            _this5.initial_state = false;
        });

    },
    methods: {
        accepterCondition() {
            this.accepted = true;
            this.$modal.hide("terme-condition");
        },
        setItem(item) {
            this.item = item;
            return this.item != null;
        },
        checkAssurance(event, assurance) {
            this.assurance = this.assurance.filter(_val => _val.assurance != assurance);
            if (event.target.checked) {
                this.assurance = [...this.assurance, { assurance: assurance, value: this.item[assurance] != undefined ? parseFloat(this.item[assurance]) : 0 }];
            }
        },
        selectLieu: function (event, lieu) {
            var _this5 = this;
            _this5.lieu.recuperation.map(function (_val) {
                if (_val.id == $(event.target).val()) {
                    _this5.lieu_recuperation = _val;
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
        checkTarif() {
            var _this5 = this;
            if (_this5.initial_state) return;
            var data = {};
            var isValid = true;
            $('[name="lieu_recuperation"],[name="lieu_restriction"],[name="date_recuperation"],[name="heure_recuperation"],[name="date_restriction"],[name="heure_restriction"]').each(function () {
                if (!Myform(this).isValid()) {
                    isValid = false;
                } else {
                    data[$(this).attr('name')] = $(this).val();
                }
            });

            if (isValid == false) return false;
            _this5.load_request_location = true;
            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/locations/product-prices`, {
                ...data,
                location_id: _this5.item.id
            }).then(function (response) {
                _this5.collection = response.data.data[0] != undefined ? [response.data.data[0]] : _this5.collection;
            }).catch(function (errors) {

            }).finally(() => {
                loading_.remove();
                _this5.load_request_location = false;
            });
        },
        isDate(d) {
            return !isNaN(d.getTime());
        },
        validerCommander(event) {
            var _this5 = this,
                data_form = null,
                _el = event.currentTarget;
            $('#reservetion_form').each(function () {
                data_form = Myform(this).serialized();
            });
            if (data_form == null) {
                _this5.$modal.show('dialog', {
                    title: _this5.$dictionnaire.info_form_incomplete_title,
                    text: _this5.$dictionnaire.info_form_incomplete,
                    buttons: [{
                        title: _this5.$dictionnaire.info_form_incomplete_btn_confirm,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    }],
                    class: 'alert alert-danger',
                });
                return;
            };
            const data = {
                item: _this5.item,
                marge_calculer: _this5.marge_calculer,
                date_commande: _this5.date_commande,
                assurance: _this5.assurance
            };
            const computed = {
                prixTotal: _this5.prixTotal
            };
            _this5.putCommande(
                event,
                'location', {
                data: JSON.stringify(data),
                computed: JSON.stringify(computed),
                form: data_form,
                edit_pannier: _this5.editpannier == 'true',
                date_commande: _this5.date_commande
            },
                function (commande_reponse) {
                    _this5.$modal.show({
                        template: `
                            <div class="card border-success text-center">
                                <div class="card-header bg-success text-uppercase font-weight-bold card-title text-white">
                                    ${_this5.$dictionnaire.commande_produit_succes_title}
                                </div>
                                <div class="card-body pb-5">
                                    <p class="card-text"> ${_this5.$dictionnaire.commande_produit_succes} </p>
                                </div>
                                <div class="card-footer text-muted d-flex align-items-center bg-success">
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click.prevent="achat">${_this5.$dictionnaire.commande_produit_btn_continuer_achat}</button>
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click.prevent="panier">${_this5.$dictionnaire.commande_produit_btn_passer_commande}</button>
                                </div>
                            </div>
                      `,
                        props: ['billeterie', 'location', 'panier', 'achat']
                    }, {
                        panier: function () {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/panier`, { id: $(_el).attr('id-commande') })
                        },
                        achat: function () {
                            _this5.$modal.hide('dialog')
                            window.location.href = `${_this5.urlbase}/locations`;
                        }
                    }, {
                        height: 'auto',
                        clickToClose: false
                    }, {
                        'before-open': e => {

                        },
                        'before-close': e => {

                        }
                    });
                }
            );
        },
        parseDateToString: function (_date) {
            return _date == '' ? '' : moment(_date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    },
    props: [
        'mycommande',
        'editpannier',
        'saisons'
    ]
});