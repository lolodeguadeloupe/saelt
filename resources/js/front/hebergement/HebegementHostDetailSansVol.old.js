import _, { now } from 'lodash';
import SectionPage from '../app-front/SectionPage';
import Myform from '../app-front/helperForm';

Vue.component('hebergement-host-detail-sans-vol', {
    mixins: [SectionPage],
    data: function() {
        return {
            calendarRange: {},
            datepicker: null,
            excludedDate: [],
            colorSelectDate: 'green',
            supplementCkecked: {},
            personneChecked: {},
            chambreChecked: 0,
            prix_chambre_personne: 0,
            prix_supp_personne: 0,
            prix_supp_chambre: 0,
            date_commande: null,
            /** */
            jour_max: 0,
            jour_min: 0,
            nuit_max: 0,
            nuit_min: 0,
            item: null,
            /* */
            nombre_personne_checked: 0,
            /* */
            min_saison: new Date(),
            max_saison: new Date(),
            /** */
            prix_saison: [],
            chambre_disponible: 0,
            chambre_calendar_non_disponible: [],
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
        const all_saison = [];
        _this5.chambresaison.map(function(_saison) {
            var k = 0;
            while (moment(_this5.$plusDays(_saison.debut, k)).isBefore(_saison.fin)) {
                all_saison.push(_this5.$plusDays(_saison.debut, k));
                k++;
            }
        })
        all_saison.sort(function(d1, d2) {
                if (moment(d1).isAfter(d2)) {
                    return 1;
                } else if (moment(d1).isBefore(d2)) {
                    return -1;
                } else {
                    return 0;
                }
            })
            /* init min max saison */
        _this5.min_saison = all_saison.length > 0 ? _this5.$maxDate(new Date(), all_saison[0]) : new Date();
        _this5.max_saison = all_saison.length > 0 ? all_saison[all_saison.length - 1] : new Date();
        /** */
        if (all_saison.length > 0) {
            var l = 1;
            while (l < all_saison.length) {
                if (moment(all_saison[l]).diff(all_saison[l - 1], 'day') > 1) {
                    _this5.excludedDate = [
                        ..._this5.excludedDate,
                        {
                            start: _this5.$plusDays(all_saison[l - 1], 1),
                            end: _this5.$plusDays(all_saison[l], -1)
                        }
                    ];
                }
                l++;
            }
        }
    },
    mounted() {

        var _this5 = this;

        this.datepicker = this.$refs.datepicker;

        $('#my_calendar').each(function() {
            var exclusive = _this5.item.type_chambre.calendar;
            _this5.jour_max = parseInt(_this5.item.jour_max);
            _this5.jour_min = parseInt(_this5.item.jour_min);
            _this5.nuit_max = parseInt(_this5.item.nuit_max);
            _this5.nuit_min = _this5.item.nuit_min == null ? 1 : parseInt(_this5.item.nuit_min);
            _this5.excludedDate = [
                ..._this5.excludedDate,
                ...exclusive.map(function(_date) {
                    return {
                        start: moment(new Date(_date.date)).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).toDate(),
                        end: moment(new Date(_date.date)).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).toDate()
                    }
                })
            ];

            //
        });

        /* set supp chambre */
        var supp_vue = [];
        _this5.item.hebergement.supplement_vue.map(function(_vue) {
            supp_vue = [...supp_vue, _vue];
            _this5.supplementCkecked = {..._this5.supplementCkecked, 'vue_': supp_vue };
        });

        /** set form */
        if (_this5.mycommande.length > 0 && _this5.editpannier == 'true') {
            $('#reservetion_form').each(function() {
                Myform(this).setForm(_this5.mycommande[0].form);
                for (var _old in _this5.mycommande[0].form) {
                    $(`[name="${_old}"]`).each(function() {
                        if ($(this).attr('data-oldValue') != undefined) {
                            $(this).attr('data-oldValue', _this5.mycommande[0].form[_old]);
                        }
                    })
                }
            });
        }
    },
    computed: {
        dateDebutCalendar() {
            var _this5 = this;
            return _this5.calendarRange && _this5.calendarRange.start ? moment(_this5.calendarRange.start).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('DD/MM/YYYY') : 'JJ/MM/YYYY';
        },
        dateEndCalendar() {
            var _this5 = this;
            return _this5.calendarRange && _this5.calendarRange.end ? moment(_this5.calendarRange.end).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('DD/MM/YYYY') : 'JJ/MM/YYYY';
        },
        nombreJourCalendar() {
            var _this5 = this,
                day = _this5.calendarRange && _this5.calendarRange.start && _this5.calendarRange.end ? moment(_this5.calendarRange.end).diff(moment(_this5.calendarRange.start), 'days') - 1 : 0;
            return day > 0 ? day : 0;
        },
        nombreNuitCalendar() {
            var _this5 = this;
            return _this5.calendarRange && _this5.calendarRange.start && _this5.calendarRange.end ? moment(_this5.calendarRange.end).diff(moment(_this5.calendarRange.start), 'days') : 0;
        },
        prixTotal() {
            this.detailSupplement();
            return parseFloat(this.prix_chambre_personne + this.prix_supp_personne + this.$multiplication(this.prix_supp_chambre, this.chambreChecked)).toFixed(2);
        },
        attributes() {
            var _this5 = this;
            return _this5.chambre_calendar_non_disponible.map(_val_cal => ({
                /*dot: _val_cal.color,*/
                dates: _this5.$parseDate(_val_cal.date, false),
                popover: {
                    label: `${_val_cal.desc} (${_val_cal.nb} chambres)`,
                },
            }));
        }

    },
    watch: {
        'personneChecked': function personneChecked(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                /* set prix personne */
                this.checkPrix();
            }
        },
        'calendarRange': function calendarRange(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                /* set prix personne */
                this.checkSaison();
            }
        },
        'supplementCkecked': function supplementCkecked(newVal, oldVal) {
            if (+newVal !== +oldVal) {

            }
        },
        'prix_saison': function prix_saison(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                /* set prix personne */
                this.checkPrix();
            }
        },
        'item': function item(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.chambre_disponible = newVal.type_chambre.nombre_chambre
            }
        }
    },
    methods: {
        setItem(item) {
            if (this.item == null && item != null) {
                this.item = item;
                return true;
            } else if (this.item != null) {
                return true;
            } else
                return false;
        },
        detailSupplement() {
            var _this5 = this;

            _this5.item.hebergement.supplement_activite.map(function(_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function(_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb);
                        }
                    }
                });
                $(`[for="activite_${_arr_supp.id}"]`).each(function() {
                    $(this).attr('data-label', `${_this5.$multiplication(somme, _this5.nombreNuitCalendar)}€`);
                });
            })
            _this5.item.hebergement.supplement_pension.map(function(_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function(_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb);
                        }
                    }
                });
                $(`[for="pension_${_arr_supp.id}"]`).each(function() {
                    $(this).attr('data-label', `${_this5.$multiplication(somme, _this5.nombreNuitCalendar)}€`);
                });
            })

            _this5.item.hebergement.supplement_vue.map(function(_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function(_item_supp_tarif) {
                    somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.chambreChecked);
                });
                $(`[for="vue_${_arr_supp.id}"]`).each(function() {
                    $(this).attr('data-label', `${_this5.$multiplication(somme, _this5.nombreNuitCalendar)}€`);
                });
            })
            _this5.prix_supp_personne = 0;
            for (var supp in _this5.supplementCkecked) {
                var somme_all = 0;
                _this5.supplementCkecked[supp] = _this5.supplementCkecked[supp].map(function(_item_supp) {
                    if (_item_supp.regle_tarif == "1") {
                        var somme = 0;
                        _item_supp.tarif.map(function(_item_supp_tarif) {
                            for (var pers in _this5.personneChecked) {
                                if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                                    somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb);
                                    somme_all = somme_all + somme;
                                    /* unitaire supp personne */
                                    _this5.prix_supp_personne = _this5.prix_supp_personne + parseFloat(_item_supp_tarif.prix_vente);
                                }
                            }
                        });
                        return {
                            ..._item_supp,
                            prix_calculer: somme
                        }
                    } else if (_item_supp.regle_tarif == "2") {
                        var somme = 0;
                        _item_supp.tarif.map(function(_item_supp_tarif) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.chambreChecked);
                            somme_all = somme_all + somme;
                            /* unitaire supp chambre */
                            _this5.prix_supp_chambre = _this5.prix_supp_chambre + parseFloat(_item_supp_tarif.prix_vente);
                        });
                        return {
                            ..._item_supp,
                            prix_calculer: somme
                        }
                    }
                });
                $(`[for="${supp}"]`).each(function() {
                    var _label = this;
                    $(`[name="${supp}"]`).each(function() {
                        $(_label).attr('data-label', `${_this5.$multiplication(somme_all, _this5.nombreNuitCalendar)}€`);
                    })
                });
            }

        },
        checkSupplement(event, prefix, array_id, table) {
            var _this5 = this,
                _item_selected = _this5.supplementCkecked[prefix] != undefined ? _this5.supplementCkecked[prefix] : [];

            array_id.map(function(_val) {
                $(`[name="${prefix}${_val}"]`).each(function() {
                    $(this).prop('checked', event.target.checked);
                    if (event.target.checked && _item_selected.map(_item_selected_val => _item_selected_val.id).indexOf(_val) < 0) {
                        _item_selected = [
                            ..._item_selected,
                            ..._this5.item.hebergement[table].filter(_table_item => _table_item.id == _val).map(_table_item => ({..._table_item, prix_calculer: 0 }))
                        ];
                    } else if (event.target.checked == false) {
                        _item_selected = _item_selected.filter(function(_value) {
                            return _value.id != _val;
                        })
                    }
                });
            });

            $(`[name="${prefix}"]`).each(function() {
                if (_item_selected.length == 0) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            })

            var _temp = {..._this5.supplementCkecked }
            _temp[prefix] = _item_selected;
            _this5.supplementCkecked = {..._temp };

        },
        checkChambre(event, arr_personne_id) {
            var _this5 = this;
            /* is decremente nb chambre */
            if (_this5.$isNumber($(event.target).val()) && parseInt($(event.target).attr('data-oldValue')) > $(event.target).val()) {
                var nb_personne = 0,
                    capacite_max = _this5.item.type_chambre.capacite;
                /* get nombre personne */
                arr_personne_id.map(function(_val_) {
                    $(`[name="personne_${_val_}"]`).each(function() {
                        const _val = $(this).val() != '' ? $(this).val() : 0;
                        nb_personne = nb_personne + parseInt(_val);
                        $(this).dettachClass('form-control-danger');
                    })
                });
                /* if personne  == nb chambre x capacite max */
                /*if (nb_personne > parseInt($(event.target).val()) * capacite_max) {
                    $(event.target).val($(event.target).attr('data-oldValue'));
                }*/

            } else if (_this5.$isNumber($(event.target).val()) && parseInt($(event.target).val()) > parseInt($(event.target).attr('max'))) {
                /* is incremente nb chambre et event.val > nombre chambre */
                $(event.target).val($(event.target).attr('data-oldValue'));
            }
            /* init old value */
            if (_this5.$isNumber($(event.target).val())) {
                $(event.target).attr('data-oldValue', $(event.target).val());
            }
            /* set chambre checked */
            _this5.chambreChecked = parseInt($(event.target).attr('data-oldValue'));
            console.log(parseInt($(event.target).attr('data-oldValue')))
        },
        checkPersonne(event, prefix, array_id, id) {
            var _this5 = this,
                capacite_max = _this5.item.type_chambre.capacite,
                nb_personne = 0;

            $('[name="nb_chambre"]').each(function() {
                    var _this_chambre = this;
                    /* is int nb chambre */
                    $(_this_chambre).val(_this5.$isNumber($(_this_chambre).val()) ? $(_this_chambre).val() : 1);
                })
                /* all personne */
            array_id.map(function(_val_) {
                $(`[name="${prefix}${_val_}"]`).each(function() {
                    const _val = $(this).val() != '' ? $(this).val() : 0;
                    nb_personne = nb_personne + parseInt(_val);
                    $(this).dettachClass('form-control-danger');
                })
            });
            /* increment personne sur plus chammbre */
            if (_this5.chambreChecked * capacite_max < nb_personne) {
                if (parseInt($(event.target).val()) < parseInt($(event.target).attr('data-oldValue'))) {
                    $(event.target).attr('data-oldValue', $(event.target).val());
                } else {
                    _this5.$modal.show({
                        template: _this5.chambre_disponible > 0 ?
                            _this5.chambreChecked == 0 ?
                            `<div class="alert alert-warning d-flex align-items-center mb-0">
                                  <p class="m-auto">Veuillez sélectionner une chambre</p>
                                </div> ` :
                            `<div class="alert alert-warning d-flex align-items-center mb-0">
                                  <p class="m-auto">Le nombre maximum de personnes est atteint ( Capacité max : ${_this5.chambreChecked * capacite_max} pers)</p>
                                </div>` : `<div class="alert alert-warning d-flex align-items-center mb-0">
                                  <p class="m-auto">Aucune chambre n'est disponible</p>
                                </div>`,
                        props: []
                    }, {}, { height: 'auto' }, {
                        'before-open': e => {
                            $(event.target).addClass('border-alert');
                        },
                        'before-close': e => {
                            $(event.target).removeClass('border-alert');
                        }
                    })
                }
                $(event.target).val($(event.target).attr('data-oldValue'));
            } else if (nb_personne >= 0) {
                /* is min personne chambre */
                //$(event.target).val(1);
                _this5.nombre_personne_checked = nb_personne;
            }

            /* init old value */
            if (_this5.$isNumber($(event.target).val())) {
                //:data-tarif="_personne.prix_vente" :data-capacite="item.type_chambre.capacite"
                $(event.target).attr('data-oldValue', $(event.target).val());
                _this5.item.tarif.map(function(_tarif_personne) {
                    if (_tarif_personne.type_personne_id == id) {
                        const _temp = _this5.personneChecked;
                        _temp[`${prefix}${id}`] = {
                            id: id,
                            reference_prix: _tarif_personne.personne.reference_prix,
                            type: _tarif_personne.personne,
                            prix: parseFloat(_tarif_personne.prix_vente),
                            nb: $(event.target).val() != '' ? parseInt($(event.target).val()) : 0
                        };
                        _this5.personneChecked = {
                            ..._temp
                        }
                    }
                })
            }
        },
        checkSaison() {
            var _this5 = this;
            _this5.chambre_calendar_non_disponible = [];
            _this5.colorSelectDate = "green";
            if (!(_this5.calendarRange && _this5.calendarRange.start && _this5.calendarRange.end))
                return;

            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/hebergements/product-prices`, {
                chambre: _this5.chambreChecked,
                debut_saison: _this5.$initTime(_this5.calendarRange.start),
                fin_saison: _this5.$initTime(_this5.calendarRange.end),
                chambre_id: _this5.item.type_chambre_id,
                edit: _this5.mycommande[0] != undefined ? _this5.mycommande[0].edit_pannier : false,
                index_commande: _this5.mycommande[0] != undefined ? _this5.mycommande[0].index_produit : -1
            }).then(function(response) {
                /** produit command added */
                _this5.prix_saison = response.data.saison;
                _this5.chambre_disponible = response.data.chambre_disponible;
                if (parseInt(_this5.chambreChecked) > parseInt(response.data.chambre_disponible)) {
                    _this5.chambreChecked = 0;
                    $('[name="nb_chambre"]').each(function() {
                        $(this).val(0)
                    });
                }
                if (response.data.chambre_disponible == 0) {
                    _this5.chambre_calendar_non_disponible = response.data.info_detail;
                    _this5.colorSelectDate = "red";
                }
                /** */
            }).catch(function(errors) {

            }).finally(() => {
                loading_.remove();
            });
        },
        prix_personne_interval_saison(personne_id) {
            var prix = 0,
                _this5 = this;
            _this5.prix_saison.map(function(_prix_saison) {
                _prix_saison.tarif.tarif.map(function(_prix_saison_personne) {
                    if (_prix_saison_personne.type_personne_id == personne_id) {
                        prix = prix + _this5.$multiplication(_prix_saison_personne.prix_vente, _prix_saison.jours);
                    }
                })
            })
            return prix;
        },
        checkPrix() {
            var _this5 = this;
            var checkedAdulte = {};
            var checkedAutre = [];
            var personne_chambre = null;
            const base_max = _this5.chambreChecked * _this5.item.type_chambre.base_type.nombre;
            for (var p in _this5.personneChecked) {
                if (_this5.personneChecked[p].reference_prix == '1') {
                    checkedAdulte = {
                        ..._this5.personneChecked[p],
                        prix: _this5.prix_personne_interval_saison(_this5.personneChecked[p].id),
                        prefix: p
                    };
                } else {
                    checkedAutre.push({
                        ..._this5.personneChecked[p],
                        prix: _this5.prix_personne_interval_saison(_this5.personneChecked[p].id),
                        prefix: p
                    });
                }
            }
            if (checkedAdulte.nb > 0) {
                checkedAdulte = {
                    ...checkedAdulte,
                    nb: checkedAdulte.nb - 1
                }
                personne_chambre = {
                    prix: checkedAdulte.prix,
                    nb: 1
                };
            }
            if (personne_chambre == null) return;
            var has_personne = true;
            while (has_personne && base_max > personne_chambre.nb && checkedAutre.length > 0) {
                checkedAutre = checkedAutre.map(function(_check_autre) {
                    if (_check_autre.nb > 0 && base_max > personne_chambre.nb) {
                        personne_chambre.nb = personne_chambre.nb + 1;
                        has_personne = _check_autre.nb - 1 > 0;
                        return {
                            ..._check_autre,
                            nb: _check_autre.nb - 1
                        }
                    } else {
                        has_personne = false;
                        return _check_autre;
                    }
                });
            }
            const _reste_checkAutre = base_max - personne_chambre.nb;
            if (_reste_checkAutre > 0) {
                checkedAdulte = {
                    ...checkedAdulte,
                    nb: (checkedAdulte.nb - _reste_checkAutre) <= 0 ? 0 : checkedAdulte.nb - _reste_checkAutre
                }
            }
            /* prix de base type chambre */
            const _prixTotal = checkedAdulte.nb > 0 ? parseFloat(_this5.$multiplication((checkedAdulte.prix / _this5.item.type_chambre.base_type.nombre), checkedAdulte.nb) + personne_chambre.prix).toFixed(2) : personne_chambre.prix;
            $(`[name="${checkedAdulte.prefix}"]`).each(function() {
                $(`[id="${checkedAdulte.prefix}"]`).each(function() {
                    $(this).text(`${_prixTotal}€`);
                });
            })
            _this5.prix_chambre_personne = _prixTotal;
            /* prix de base type chambre */

            checkedAutre = checkedAutre.map(function(_check_autre) {
                if (_check_autre.nb > 0) {
                    const _prixTotal = _this5.$multiplication(_check_autre.prix, _check_autre.nb);
                    $(`[name="${_check_autre.prefix}"]`).each(function() {
                        $(`[id="${_check_autre.prefix}"]`).each(function() {
                            $(this).text(`${_prixTotal}€`);
                        });
                    })
                    _this5.prix_chambre_personne = _this5.prix_chambre_personne + _prixTotal;
                } else {
                    $(`[name="${_check_autre.prefix}"]`).each(function() {
                        $(`[id="${_check_autre.prefix}"]`).each(function() {
                            $(this).text(`${0}€`);
                        });
                    })
                }
            });
        },
        checkPersonneAdulte() {
            var checked = false;
            const msg = `<p>Au moins une (1) personne adulte selectionner </p>`;
            for (var k in this.personneChecked) {
                if (this.personneChecked[k].reference_prix == '1' && this.personneChecked[k].nb > 0) {
                    checked = true;
                }
            }
            return {
                valid: checked,
                msg: checked ? '' : msg
            }
        },
        checkMaxNuit() {
            if (this.nuit_min > 0 && this.nombreNuitCalendar < this.nuit_min) {
                return {
                    valide: false,
                    msg: `<p>Nous n'accéptons pas une réservation inférieur à ${this.nuit_min} nuits (${this.nuit_min} nuits min) </p>`
                }
            } else if (this.nuit_max > 0 && this.nombreNuitCalendar > this.nuit_max) {
                return {
                    valide: false,
                    msg: `<p>vous dépassez le nombre maximum de nuits (${this.nuit_max} nuits max) </p>`
                }
            }
            return {
                valide: true,
                msg: ``
            }
        },
        hasChambre() {
            if (this.chambreChecked <= 0) {
                return {
                    valide: false,
                    msg: this.chambre_disponible > 0 ? `<p>Veuillez sélectionner une chambre </p>` : `Aucune chambre n'est disponible`,
                }
            } else if (this.item.type_chambre.capacite * this.chambreChecked < this.nombre_personne_checked) {
                for (var _pers in this.personneChecked) {
                    $(`[name="personne_${this.personneChecked[_pers].id}"]`).each(function() {
                        $(this).attachClass('form-control-danger').dettachClass('form-control-success');
                    })
                }

                return {
                    valide: false,
                    msg: `<p>Vous dépassez le nombre maximum de personne (Capacité max : ${this.item.type_chambre.capacite * this.chambreChecked} Pers.) </p>`,
                }
            }
            return {
                valide: true,
                msg: ``
            }
        },
        validerCommander(event) {
            var _this5 = this,
                data_form = null,
                _el = event.currentTarget;
            $('#reservetion_form').each(function() {
                data_form = Myform(this).serialized();
            });
            const checkMaxNuit = _this5.checkMaxNuit();
            const checkPersonneAdulte = _this5.checkPersonneAdulte();
            const hasChambre = _this5.hasChambre();
            if (_this5.nombreNuitCalendar == 0 || data_form == null || checkMaxNuit.valide == false || checkPersonneAdulte.valid == false || hasChambre.valide == false) {
                _this5.$modal.show('dialog', {
                    title: _this5.$dictionnaire.info_form_incomplete_title,
                    text: `${checkPersonneAdulte.msg} ${checkMaxNuit.msg} ${hasChambre.msg}`,
                    buttons: [{
                        title: _this5.$dictionnaire.info_form_incomplete_btn_confirm,
                        handler: () => {
                            _this5.$modal.hide('dialog')
                        }
                    }],
                    class: 'alert alert-danger',
                });
                return;
            };
            const data = {
                calendarRange: _this5.calendarRange,
                excludedDate: _this5.excludedDate,
                supplementCkecked: _this5.supplementCkecked,
                personneChecked: _this5.personneChecked,
                chambreChecked: _this5.chambreChecked,
                prix_chambre_personne: _this5.prix_chambre_personne,
                prix_supp_personne: _this5.prix_supp_personne,
                prix_supp_chambre: _this5.prix_supp_chambre,
                date_commande: _this5.date_commande,
                item: this.item
            };
            const computed = {
                dateDebutCalendar: _this5.dateDebutCalendar,
                dateEndCalendar: _this5.dateEndCalendar,
                nombreJourCalendar: _this5.nombreJourCalendar,
                nombreNuitCalendar: _this5.nombreNuitCalendar,
                prixTotal: _this5.prixTotal,
                personneChecked: _this5.personne.map(function(_pers_) {
                    return _this5.personneChecked[`personne_${_pers_.id}`] != undefined ?
                        _this5.personneChecked[`personne_${_pers_.id}`] : {
                            id: _pers_.id,
                            type: _pers_,
                            prix: 0,
                            nb: 0
                        };
                }),
            };
            _this5.putCommande(
                event,
                'hebergement', {
                    data: JSON.stringify(data),
                    computed: JSON.stringify(computed),
                    form: data_form,
                    edit_pannier: _this5.editpannier == 'true',
                    index_commande: _this5.mycommande[0] != undefined ? _this5.mycommande[0].index_produit : -1,
                    date_commande: _this5.date_commande
                },
                function(commande_data) {
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
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click="panier">${_this5.$dictionnaire.commande_produit_btn_passer_commande}</button>
                                </div>
                            </div>
                      `,
                        props: ['panier', 'achat']
                    }, {
                        panier: function() {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/panier`, { id: $(_el).attr('id-commande') })
                        },
                        achat: function() {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/hebergements/hebergement-host`, { id: _this5.item.hebergement.id, customer_search: null });
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
        }
    },
    props: [
        'personne',
        'mycommande',
        'editpannier',
        'chambresaison'
    ]
});