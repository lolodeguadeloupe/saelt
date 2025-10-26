import SectionPage from '../app-front/SectionPage';
import Myform from '../app-front/helperForm';

Vue.component('hebergement-host-detail-avec-vol', {
    mixins: [SectionPage],
    data: function () {
        return {
            calendarRange: {},
            datepicker: null,
            excludedDate: [],
            colorSelectDate: 'green',
            supplementCkecked: {},
            personneChecked: {},
            chambreChecked: 0,
            marge_calculer: 0,
            prix_chambre_personne: 0,
            prix_supp_personne: 0,
            prix_supp_chambre: 0,
            date_commande: null,
            item: null,
            //
            selectCalendarDate: {},
            /** */
            prix_saison: [],
            prix_base_type: [],
            base_type_chambre: 0,
            /** */
            chambre_disponible: 0,
            /** chambre_à_proposer */
            chambre_ajuster: [],
            /** */
            chambre_calendar_non_disponible: [],
            nb_personne_adulte_checked: 0,
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
    },
    mounted() {
        var _this5 = this;
        $('#my_calendar').each(function () {
            const jour_voyage = moment(_this5.$parseDate(_this5.item.vol.arrive, true)).diff(moment(_this5.$parseDate(_this5.item.vol.depart, true)), 'day');
            const vol_depart = _this5.$parseDate(_this5.item.vol.depart, true);
            const vol_arrive = _this5.$parseDate(_this5.item.vol.arrive, true);
            //
            _this5.selectCalendarDate = {
                start: vol_depart,
                end: _this5.$plusDays(vol_depart, _this5.item.vol.nombre_nuit),
                days: moment(_this5.$plusDays(vol_depart, _this5.item.vol.nombre_nuit)).diff(moment(vol_depart), 'days')
            }
            //
            _this5.calendarRange = [{
                highlight: {
                    start: { fillMode: 'outline' },
                    base: { fillMode: 'light' },
                    end: { fillMode: 'outline' },
                },
                dates: { start: vol_depart, end: _this5.$plusDays(vol_depart, _this5.item.vol.nombre_nuit) },
            },]

        });
        /* set supp chambre */

        var supp_vue = [];
        _this5.item.hebergement.supplement_vue.map(function (_vue) {
            supp_vue = [...supp_vue, _vue];
            _this5.supplementCkecked = { ..._this5.supplementCkecked, 'vue_': supp_vue };
        });

        /** set form */
        if (_this5.mycommande.length > 0 && _this5.editpannier == 'true') {
            $('#reservetion_form').each(function () {
                Myform(this).setForm(_this5.mycommande[0].form);
            });
        }
    },
    computed: {
        dateDebutCalendar() {
            var _this5 = this;
            return _this5.selectCalendarDate && _this5.selectCalendarDate.start ? moment(_this5.selectCalendarDate.start).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('DD/MM/YYYY') : 'JJ/MM/YYYY';
        },
        dateEndCalendar() {
            var _this5 = this;
            return _this5.selectCalendarDate && _this5.selectCalendarDate.end ? moment(_this5.selectCalendarDate.end).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('DD/MM/YYYY') : 'JJ/MM/YYYY';
        },
        nombreJourCalendar() {
            var _this5 = this;
            return _this5.selectCalendarDate && _this5.selectCalendarDate.start && _this5.selectCalendarDate.end ? moment(_this5.selectCalendarDate.end).diff(moment(_this5.selectCalendarDate.start), 'days') + 1 : 0;
        },
        nombreNuitCalendar() {
            var _this5 = this;
            return _this5.selectCalendarDate && _this5.selectCalendarDate.start && _this5.selectCalendarDate.end ? moment(_this5.selectCalendarDate.end).diff(moment(_this5.selectCalendarDate.start), 'days') : 0;
        },
        prixTotal() {
            this.calculeSupplement();
            return parseFloat(this.prix_chambre_personne + this.prix_supp_personne + this.prix_supp_chambre).toFixed(2);
        },
        nombre_personne_checked() {
            var nb_personne = 0, _this5 = this;
            for (var _pers in _this5.personneChecked) {
                nb_personne = nb_personne + parseInt(_this5.personneChecked[_pers].nb);
            }
            return nb_personne;
        }
    },
    watch: {
        'prix_saison': function prix_saison(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                /* set prix personne */
                this.calculerTarif();
            }
        },
        'personneChecked': function personneChecked(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                /* proposer chambre */
                this.ajusterChambre(newVal);
            }
        },
        'chambreChecked': function (newVal, oldVal) {
            if (+newVal !== +oldVal && newVal != undefined) {
                /* set prix personne */
                this.checkPrixSaisonBase(newVal);
            }
        },
        'chambre_disponible': function chambre_disponible(newVal, oldVal) {
            if (+newVal != +oldVal && newVal != undefined) {
                this.ajusterChambre(this.personneChecked);
            }
        },
        'chambre_ajuster': function chambre_ajuster() {
            $('[name="nb_chambre"]').each(function () {
                $(this).val('');
            });
            this.chambreChecked = 0;
        },
        'item': function item(newVal, oldVal) {
            if (+newVal !== +oldVal && newVal != null) {
                this.chambre_disponible = newVal.chambre_dispo;
                this.prix_saison = [...newVal.tarif]
                console.log(newVal.tarif_base)
                this.prix_base_type = [...newVal.tarif_base];
                this.base_type_chambre = newVal.base_type.nombre;
            }
        },
        'prix_base_type': function prix_base_type(newVal, oldVal) {
            if (+newVal !== +oldVal && newVal != undefined && this.nombre_personne_checked > 0 && this.chambreChecked > 0) {
                this.checkPrixSaisonBase(this.chambreChecked);
            }
        }
    },
    methods: {
        checkPrixSaisonBase(chambre_checked) {
            var _this5 = this;
            var _temp_saison_base = [];
            _this5.prix_base_type.map(function (_val) {
                if ((_val.nombre_base * parseInt(chambre_checked)) >= _this5.nombre_personne_checked) {
                    _temp_saison_base = [..._temp_saison_base, {
                        nombre_base: _val.nombre_base,
                        saison: _val.saison
                    }];
                }
            });

            /** */
            if (_temp_saison_base[0] == undefined) {
                _this5.prix_base_type.map(function (_val) {
                    if ((_this5.item.type_chambre.capacite * parseInt(chambre_checked)) >= _this5.nombre_personne_checked) {
                        _temp_saison_base = [..._temp_saison_base, {
                            max_nuit: _val.max_nuit,
                            min_nuit: _val.min_nuit,
                            nombre_base: _val.nombre_base,
                            saison: _val.saison
                        }];
                    }
                });
            }
            console.log(_temp_saison_base, '_temp_saison_base')
            /** */
            const order_base = _temp_saison_base.sort(function compare(a, b) {
                if (parseInt(a.nombre_base) < parseInt(b.nombre_base))
                    return -1;
                if (parseInt(a.nombre_base) > parseInt(b.nombre_base))
                    return 1;
                return 0;
            });
            console.log(order_base, 'order_base')
            const index = order_base.findIndex(function (_val) {
                return (_val.nombre_base * parseInt(chambre_checked)) == _this5.nombre_personne_checked;
            });
            console.log(index, 'index')
            if (index >= 0) {
                _this5.prix_saison = [
                    ...order_base[index].saison.tarif
                ];
                /** */
                _this5.base_type_chambre = order_base[0].nombre_base;
                /** */
            } else if (order_base[0] != undefined) {
                _this5.prix_saison = [
                    ...order_base[0].saison.tarif
                ];
                /** */
                _this5.base_type_chambre = order_base[0].nombre_base;
                /** */
            } else {
                _this5.prix_saison = [
                    ..._this5.item.tarif
                ];
                /** */
                _this5.base_type_chambre = _this5.item.base_type.nombre;
                /** */
            }
        },
        ajusterChambre(personneChecked) {
            var nb_adulte = 0, nb_personne = 0, capacite_max = this.item.type_chambre.capacite;
            for (var k in personneChecked) {
                if (personneChecked[k].reference_prix == '1') {
                    nb_adulte = nb_adulte + (personneChecked[k].nb != undefined ? personneChecked[k].nb : 0);
                }
                nb_personne = nb_personne + (personneChecked[k].nb != undefined ? personneChecked[k].nb : 0);
            }
            var min = parseInt(nb_personne / parseInt(capacite_max));
            if (nb_personne % parseInt(capacite_max) == 0) {
                min = min == 0 ? 1 : min;
            } else {
                min = min + 1;
            }
            min = min > nb_adulte ? nb_adulte : min;

            if (parseInt(this.chambre_disponible) >= min) {
                const has_chambre = nb_adulte < parseInt(this.chambre_disponible) ? nb_adulte : parseInt(this.chambre_disponible);
                this.chambre_ajuster = this.$while(has_chambre, min);
            } else {
                this.chambre_ajuster = [];
            }

        },
        setItem(item) {
            if (this.item == null && item != null) {
                this.item = item;
                return true;
            } else if (this.item != null) {
                return true;
            } else
                return false;
        },
        checkSupplement(event, prefix, array_id, table) {
            var _this5 = this,
                _item_selected = _this5.supplementCkecked[prefix] != undefined ? _this5.supplementCkecked[prefix] : [];

            array_id.map(function (_val) {
                $(`[name="${prefix}${_val}"]`).each(function () {
                    $(this).prop('checked', event.target.checked);
                    if (event.target.checked && _item_selected.map(_item_selected_val => _item_selected_val.id).indexOf(_val) < 0) {
                        _item_selected = [
                            ..._item_selected,
                            ..._this5.item.hebergement[table].filter(_table_item => _table_item.id == _val).map(_table_item => ({ ..._table_item, prix_calculer: 0 }))
                        ];
                    } else if (event.target.checked == false) {
                        _item_selected = _item_selected.filter(function (_value) {
                            return _value.id != _val;
                        })
                    }
                });
            });

            $(`[name="${prefix}"]`).each(function () {
                if (_item_selected.length == 0) {
                    $(this).prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                }
            })

            var _temp = { ..._this5.supplementCkecked }
            _temp[prefix] = _item_selected;
            _this5.supplementCkecked = { ..._temp };

        },
        checkPersonne(event, prefix, array_id, id) {
            var _this5 = this,
                capacite_max = _this5.item.type_chambre.capacite;
            _this5.prix_saison.map(function (_tarif_personne) {
                if (_tarif_personne.type_personne_id == id) {
                    const _temp = _this5.personneChecked;
                    _temp[`${prefix}${id}`] = {
                        id: id,
                        reference_prix: _tarif_personne.personne.reference_prix,
                        type: _tarif_personne.personne,
                        prix: 0,
                        nb: _this5.$isNumber($(event.target).val()) ? parseInt($(event.target).val()) : 0
                    };
                    _this5.personneChecked = {
                        ..._temp
                    }
                }
            });
            for (var _pers in _this5.personneChecked) {
                $(`[name="personne_${_this5.personneChecked[_pers].id}"]`).each(function () {
                    $(this).dettachClass('form-control-danger').attachClass('form-control-success');
                });
                $('[name="nb_chambre"]').each(function () {
                    $(this).attachClass('form-control-danger');
                });
            }
        },
        checkChambre(event, arr_personne_id) {
            var _this5 = this;
            /* set chambre checked */
            _this5.chambreChecked = _this5.$isNumber($(event.target).val()) ? parseInt($(event.target).val()) : 0;
            $(event.target).each(function () {
                $(this).dettachClass('form-control-danger');
            });
        },
        calculerTarif() {
            var _this5 = this;
            _this5.prix_chambre_personne = 0;
            _this5.marge_calculer = 0;
            var checkedAdulte = {};
            var checkedAutre = [];
            var personne_chambre = 0;
            var total_personne = 0;
            var prix_vente_unitaire_chambre_adulte = 0;
            var prix_marge_unitaire_chambre_adulte = 0;
            var nb_jours = 0;
            /** */
            for (var pers in _this5.personneChecked) {
                _this5.personneChecked[pers].prix = 0;
                total_personne = total_personne + parseInt(_this5.personneChecked[pers].nb != undefined ? _this5.personneChecked[pers].nb : 0);
            }
            /** */
            const base_max = _this5.chambreChecked * _this5.base_type_chambre;
            const personneChecked = _this5.personneChecked;
            for (var p in _this5.personneChecked) {

                if (personneChecked[p].reference_prix == '1') {
                    checkedAdulte = {
                        ...personneChecked[p],
                        marge: 0,
                        prix: 0,
                        prefix: p
                    };
                    /** */
                    _this5.prix_saison.map(function (_item_personne_tarif) {
                        if (personneChecked[p].id == _item_personne_tarif.type_personne_id) {
                            checkedAdulte = {
                                ...checkedAdulte,
                                marge: checkedAdulte.marge + (_item_personne_tarif.marge * (checkedAdulte.nb == 0 ? 0 : 1) * _this5.chambreChecked * _this5.nombreNuitCalendar),
                                prix: checkedAdulte.prix + (_item_personne_tarif.prix_vente * (checkedAdulte.nb == 0 ? 0 : 1) * _this5.chambreChecked * _this5.nombreNuitCalendar)
                            };
                            prix_vente_unitaire_chambre_adulte = prix_vente_unitaire_chambre_adulte + (_item_personne_tarif.prix_vente * (checkedAdulte.nb == 0 ? 0 : 1) * _this5.nombreNuitCalendar);
                            prix_marge_unitaire_chambre_adulte = prix_marge_unitaire_chambre_adulte + (_item_personne_tarif.marge * (checkedAdulte.nb == 0 ? 0 : 1) * _this5.nombreNuitCalendar);
                            nb_jours = nb_jours + _this5.nombreNuitCalendar;
                        }
                    });
                    /** */
                } else {
                    checkedAutre.push({
                        ...personneChecked[p],
                        marge: 0,
                        prix: 0,
                        prefix: p
                    });
                }
            }
            _this5.nb_personne_adulte_checked = checkedAdulte.nb ? checkedAdulte.nb : 0;
            var has_personne_adulte = true;
            while (checkedAdulte.nb != undefined && has_personne_adulte && base_max > personne_chambre && checkedAdulte.nb > 0) {
                checkedAdulte = {
                    ...checkedAdulte,
                    nb: checkedAdulte.nb - 1
                };
                personne_chambre++;
            }

            var has_personne_autre = true;
            while (has_personne_autre && base_max > personne_chambre && checkedAutre.length > 0) {
                checkedAutre = checkedAutre.map(function (_check_autre) {
                    if (base_max <= personne_chambre) {
                        return _check_autre;
                    }
                    if (_check_autre.nb > 0) {
                        personne_chambre++;
                        has_personne_autre = _check_autre.nb - 1 > 0;
                        return {
                            ..._check_autre,
                            nb: _check_autre.nb - 1
                        }
                    } else {
                        has_personne_autre = false;
                        return _check_autre;
                    }
                });
            }


            checkedAutre = checkedAutre.map(function (_check_autre) {

                _this5.prix_saison.map(function (_item_personne_tarif) {
                    if (_check_autre.id == _item_personne_tarif.type_personne_id) {
                        _check_autre = {
                            ..._check_autre,
                            marge: _check_autre.marge + ((_item_personne_tarif.marge_supp ? _item_personne_tarif.marge_supp : _item_personne_tarif.marge) * _check_autre.nb * _this5.chambreChecked * _this5.nombreNuitCalendar),
                            prix: _check_autre.prix + ((_item_personne_tarif.prix_vente_supp ? _item_personne_tarif.prix_vente_supp : _item_personne_tarif.prix_vente) * _check_autre.nb * _this5.chambreChecked * _this5.nombreNuitCalendar)
                        };
                    }
                });
                /** */
                $(`[id="${_check_autre.prefix}"]`).each(function () {
                    $(this).text(`${parseFloat(_check_autre.prix).toFixed(2)}€`);
                });
                /** */
                _this5.marge_calculer = _this5.marge_calculer + _check_autre.marge;
                _this5.prix_chambre_personne = _this5.prix_chambre_personne + _check_autre.prix;
                return _check_autre
            });


            /**calculer le supplement par saison adulte checked */
            /** calcule chambre supplementaire */
            const personne_base = _this5.base_type_chambre;
            const personne_base_max = _this5.item.type_chambre.capacite;
            const cout_supplementaire = _this5.item.type_chambre.cout_supplementaire ? parseFloat(_this5.item.type_chambre.cout_supplementaire) : 0;
            /** */
            checkedAdulte = _this5.nombreChambreCompleted(nb_jours, total_personne, personne_base, personne_base_max, cout_supplementaire, checkedAdulte, prix_vente_unitaire_chambre_adulte, prix_marge_unitaire_chambre_adulte);
            /** prix chambre pour base max */
            _this5.prix_saison.map(function (_item_personne_tarif) {
                if (checkedAdulte.id == _item_personne_tarif.type_personne_id) {
                    checkedAdulte = {
                        ...checkedAdulte,
                        marge: checkedAdulte.marge + ((_item_personne_tarif.marge_supp != null ? _item_personne_tarif.marge_supp : _item_personne_tarif.marge) * checkedAdulte.nb * _this5.chambreChecked * _this5.nombreNuitCalendar),
                        prix: checkedAdulte.prix + ((_item_personne_tarif.prix_vente_supp != null ? _item_personne_tarif.prix_vente_supp : _item_personne_tarif.prix_vente) * checkedAdulte.nb * _this5.chambreChecked * _this5.nombreNuitCalendar)
                    };
                }
            });
            /** calcule chambre supplementaire */
            /*if (personne_chambre > 0 && personne_chambre < parseInt(_this5.item.base_type.nombre) && _this5.item.type_chambre.cout_supplementaire && parseFloat(_this5.item.type_chambre.cout_supplementaire) > 0) {
                checkedAdulte = {
                    ...checkedAdulte,
                    prix: ((checkedAdulte.prix * personne_chambre) / parseInt(_this5.item.base_type.nombre)) + (parseFloat(_this5.item.type_chambre.cout_supplementaire) * _this5.chambreChecked * _this5.nombreNuitCalendar)
                };
            }*/
            /** */
            if (checkedAdulte.prefix != undefined) {
                $(`[id="${checkedAdulte.prefix}"]`).each(function () {
                    $(this).text(`${parseFloat(checkedAdulte.prix).toFixed(2)}€`);
                });
                _this5.marge_calculer = _this5.marge_calculer + checkedAdulte.marge;
                _this5.prix_chambre_personne = _this5.prix_chambre_personne + checkedAdulte.prix;
            }
            /** */
        },
        nombreChambreCompleted(nb_jours, all_personne, personne_base, personne_base_max, cout_supplementaire, checkedAdulte, prix_vente_unitaire_chambre_adulte, prix_marge_unitaire_chambre_adulte) {
            var _this5 = this;
            if (_this5.chambreChecked <= 0) {
                return {
                    ...checkedAdulte,
                    marge: 0,
                    prix: 0,
                }
            }

            if (all_personne >= _this5.chambreChecked * personne_base) {
                return checkedAdulte;
            } else {
                const chambre_reste = _this5.chambreChecked - parseInt(all_personne / (_this5.chambreChecked * personne_base));
                const personne_reste = all_personne - (parseInt(all_personne / (_this5.chambreChecked * personne_base)) * personne_base);
                const nb_personne_reste_par_chambre = parseInt(personne_reste / chambre_reste);
                const personne_chambre_0 = personne_reste - (nb_personne_reste_par_chambre * chambre_reste);
                /** */
                const prix_chambre_0 = (prix_vente_unitaire_chambre_adulte / personne_base) * (personne_chambre_0 + nb_personne_reste_par_chambre);
                const marge_chambre_0 = (prix_marge_unitaire_chambre_adulte / personne_base) * (personne_chambre_0 + nb_personne_reste_par_chambre);
                /** */
                const prix_chambre_other = (prix_vente_unitaire_chambre_adulte / personne_base) * nb_personne_reste_par_chambre * (chambre_reste - 1);
                const marge_chambre_other = (prix_vente_unitaire_chambre_adulte / personne_base) * nb_personne_reste_par_chambre * (chambre_reste - 1);
                /** */
                const chambre_en_cout_supp = (personne_chambre_0 + nb_personne_reste_par_chambre) == personne_base ? chambre_reste - 1 : chambre_reste; //si le cas de chambre_0 est en base normale alors enlever une chambre
                const prix_adulte_chambre_supp = {
                    marge: marge_chambre_0 + marge_chambre_other,
                    prix: prix_chambre_0 + prix_chambre_other + (cout_supplementaire * chambre_en_cout_supp * nb_jours)
                }
                /** total chambre base */
                const prix_adulte_chambre_base = {
                    marge: prix_marge_unitaire_chambre_adulte * parseInt(all_personne / (_this5.chambreChecked * personne_base)),
                    prix: prix_vente_unitaire_chambre_adulte * parseInt(all_personne / (_this5.chambreChecked * personne_base))
                }
                /** total tarif chambre _supp et chambre_base */
                return {
                    ...checkedAdulte,
                    marge: prix_adulte_chambre_supp.marge + prix_adulte_chambre_base.marge,
                    prix: prix_adulte_chambre_supp.prix + prix_adulte_chambre_base.prix,
                }
            }
        },
        calculeSupplement() {
            var _this5 = this;
            _this5.item.hebergement.supplement_activite.map(function (_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function (_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.nombreNuitCalendar);
                        }
                    }
                });
                $(`[for="activite_${_arr_supp.id}"]`).each(function () {
                    $(this).attr('data-label', `${somme}€`);
                });
            })
            _this5.item.hebergement.supplement_pension.map(function (_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function (_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.nombreNuitCalendar);
                        }
                    }
                });
                $(`[for="pension_${_arr_supp.id}"]`).each(function () {
                    $(this).attr('data-label', `${somme}€`);
                });
            })

            _this5.item.hebergement.supplement_vue.map(function (_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function (_item_supp_tarif) {
                    somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.chambreChecked * _this5.nombreNuitCalendar);
                });
                $(`[for="vue_${_arr_supp.id}"]`).each(function () {
                    $(this).attr('data-label', `${somme}€`);
                });
            })
            _this5.prix_supp_personne = 0;
            _this5.prix_supp_chambre = 0;
            for (var supp in _this5.supplementCkecked) {
                var somme_all = 0;
                _this5.supplementCkecked[supp] = _this5.supplementCkecked[supp].map(function (_item_supp) {
                    if (_item_supp.regle_tarif == "1") {
                        var somme = 0;
                        _item_supp.tarif.map(function (_item_supp_tarif) {
                            for (var pers in _this5.personneChecked) {
                                if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                                    somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb);
                                    somme_all = somme_all + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb);
                                    /* unitaire supp personne */
                                    _this5.prix_supp_personne = _this5.prix_supp_personne + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.nombreNuitCalendar);
                                }
                            }
                        });

                        return {
                            ..._item_supp,
                            prix_calculer: somme
                        }
                    } else if (_item_supp.regle_tarif == "2") {
                        var somme = 0;
                        _item_supp.tarif.map(function (_item_supp_tarif) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.chambreChecked);
                            somme_all = somme_all + (parseFloat(_item_supp_tarif.prix_vente) * _this5.chambreChecked);
                            /* unitaire supp chambre */
                            _this5.prix_supp_chambre = (_this5.prix_supp_chambre + parseFloat(_item_supp_tarif.prix_vente)) * _this5.nombreNuitCalendar * _this5.chambreChecked;
                        });

                        return {
                            ..._item_supp,
                            prix_calculer: somme
                        }
                    }
                });

                $(`[for="${supp}"]`).each(function () {
                    var _label = this;
                    $(`[name="${supp}"]`).each(function () {
                        $(_label).attr('data-label', `${_this5.$multiplication(somme_all, _this5.nombreNuitCalendar)}€`);
                    })
                });
            }

        },
        validerCommander(event) {
            var _this5 = this,
                data_form = null,
                _el = event.currentTarget;
            $('#reservetion_form').each(function () {
                data_form = Myform(this).serialized();
            });
            const checkMaxNuit = _this5.checkMaxNuit();
            const checkPersonneAdulte = _this5.checkPersonneAdulte();
            const hasChambre = _this5.hasChambre();
            if (_this5.nombreNuitCalendar == 0 || data_form == null || checkMaxNuit.valide == false || checkPersonneAdulte.valid == false || hasChambre.valide == false) {
                _this5.$modal.show('dialog', {
                    title: _this5.$dictionnaire.info_form_incomplete_title,
                    text: `<ul>${checkPersonneAdulte.msg} ${checkMaxNuit.msg} ${hasChambre.msg}</ul>`,
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
                marge_calculer: _this5.marge_calculer,
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
                personneChecked: _this5.personne.map(function (_pers_) {
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
                function (commande_data) {
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
                        props: ['panier', 'achat']
                    }, {
                        panier: function () {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/panier`, { id: $(_el).attr('id-commande') })
                        },
                        achat: function () {
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
        },
        checkPersonneAdulte() {
            var checked = false;
            const msg = `<li>Au moins une (1) personne adulte selectionner par chambre </li>`;
            for (var k in this.personneChecked) {
                if (this.personneChecked[k].reference_prix == '1' && this.personneChecked[k].nb > 0 && this.personneChecked[k].nb >= this.chambreChecked) {
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
                    msg: `<li>Nous n'accéptons pas une réservation inférieur à ${this.nuit_min} nuits (${this.nuit_min} nuits min) </li>`
                }
            } else if (this.nuit_max > 0 && this.nombreNuitCalendar > this.nuit_max) {
                return {
                    valide: false,
                    msg: `<li>vous dépassez le nombre maximum de nuits (${this.nuit_max} nuits max) </li>`
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
                    msg: this.chambre_disponible > 0 ? `<li>Veuillez sélectionner une chambre </li>` : `<li>Aucune chambre n'est disponible</li>`,
                }
            } else if (this.item.type_chambre.capacite * this.chambreChecked < this.nombre_personne_checked) {
                for (var _pers in this.personneChecked) {
                    if (this.personneChecked[_pers].reference_prix != '1') {
                        $(`[name="personne_${this.personneChecked[_pers].id}"]`).each(function () {
                            $(this).attachClass('form-control-danger').dettachClass('form-control-success');
                        })
                    }
                }

                return {
                    valide: false,
                    msg: `<li>Vous dépassez le nombre maximum de personne (Capacité max : ${this.item.type_chambre.capacite * this.chambreChecked} Pers.) </li>`,
                }
            }
            return {
                valide: true,
                msg: ``
            }
        },
    },
    props: [
        'personne',
        'mycommande',
        'editpannier'
    ]
});