import SectionPage from '../app-front/SectionPage';
import Myform from '../app-front/helperForm';

Vue.component('excursion-product', {
    mixins: [SectionPage],
    data: function () {
        return {
            disabledDates: [],
            selectCalendarDate: [],
            isMultipleDate: false,
            fromDate: { month: new Date().getMonth() + 1, year: new Date().getUTCFullYear() },
            supplementCkecked: {},
            personneChecked: {},
            marge_calculer: 0,
            prix_excursion_personne: 0,
            prix_supp_personne: 0,
            date_commande: null,
            //
            item: null,
            prix_saison: [],
            //
            min_saison: new Date(),
            max_saison: new Date(),
        }
    },
    created() {
        var _this5 = this;
        if (_this5.sessionrequest && _this5.sessionrequest.terminer_commande != undefined && _this5.sessionrequest.terminer_commande != null) {
            for (var __x in _this5.sessionrequest.terminer_commande) {
                _this5[__x] = _this5.sessionrequest.terminer_commande[__x];
            }
        }
        if (this.mycommande.length > 0 && this.editpannier == 'true') {
            const myCommande = JSON.parse(this.mycommande[0].data);
            for (var _data in myCommande) {
                this[_data] = myCommande[_data];
            }
            if (_this5.selectCalendarDate[0] != undefined) {
                _this5.selectCalendarDate = _this5.selectCalendarDate.map(function (_date) {
                    return _this5.$parseDate(_date, false);
                })
            }
            _this5.date_commande = _this5.mycommande[0].date_commande;
        }

    },
    mounted() {
        var _this5 = this;
        $('#my_calendar').each(function () {
            var _el = this;
            var dateExclusive = $(this).attr('data-calendarexclusive') != undefined ? JSON.parse($(this).attr('data-calendarexclusive')) : [];
            _this5.disabledDates = dateExclusive.map(function (_date) {
                return {
                    start: _this5.$parseDate(_date.date),
                    end: _this5.$parseDate(_date.date),
                };
            })
            /* week disponibilite date */
            var _style_availlable_date = '';
            JSON.parse($(this).attr('date-disponible')).map(function (_date) {
                _style_availlable_date += `#my_calendar .vc-weeks .vc-weekday:nth-child(${parseInt(_date) + 1}) {
                    color: #56d521 !important;
                    text-decoration: none;
                    font-weight: bold;
                  } `;
            });
            $(`<style>${_style_availlable_date}</style>`).appendTo($('head'));
        });

        /** set form */
        if (_this5.mycommande.length > 0 && _this5.editpannier == 'true') {
            $('#reservetion_form').each(function () {
                Myform(this).setForm(_this5.mycommande[0].form);
            });
            for (var i in _this5.mycommande[0].form) {
                if (String(i).match(/^personne_+\d$/g) != null) {
                    $(`[name="${i}"]`).each(function () {
                        $(this).attr('data-oldValue', $(this).val());
                        const prix = typeof $(this).attr('data-tarif') != 'undefined' ? parseFloat($(this).attr('data-tarif')) : 0;
                        const _val = $(this).val() != '' ? $(this).val() : 0;
                        $(`[id="${i}"]`).each(function () {
                            $(this).text(`${prix * _val} €`);
                        });
                    });
                }
            }
        }
    },
    computed: {
        attributes() {
            return [...this.selectCalendarDate].map(date => ({
                highlight: {
                    style: {
                        backgroundColor: 'green',
                        class: 'opacity-100',
                    },
                    fillMode: 'light',
                },
                popover: {
                    label: `test`,
                    hideIndicator: true,
                },
                dates: date
            }));
        },
        prixTotal() {
            this.detailSupplementPrix();
            return this.prix_excursion_personne + this.prix_supp_personne;
        },
    },
    watch: {
        'personneChecked': function personneChecked(newVal, oldVal) {
            var _this5 = this;
            if (+newVal !== +oldVal) {
                _this5.checkPrix();
            }
        },
        'selectCalendarDate': function selectCalendarDate(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.checkSaison();
            }
        },
        'prix_saison': function prix_saison(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                /* set prix personne */
                this.checkPrix();
            }
        },
        'item': function item(newVal, oldVal) {
            var _this5 = this;
            if (+newVal != +oldVal) {
                const all_saison = [];
                _this5.item.saison.map(function (_saison) {
                    var k = 0;
                    while (moment(_this5.$plusDays(_saison.debut, k)).isBefore(_saison.fin)) {
                        all_saison.push(_this5.$plusDays(_saison.debut, k));
                        k++;
                    }
                })
                all_saison.sort(function (d1, d2) {
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
                            _this5.disabledDates = [
                                ..._this5.disabledDates,
                                {
                                    start: _this5.$plusDays(all_saison[l - 1], 1),
                                    end: _this5.$plusDays(all_saison[l], -1)
                                }
                            ];
                        }
                        const day_ = parseInt(moment(all_saison[l]).format('d')) - 1;
                        if (_this5.availability(newVal.availability).includes(day_ < 0 ? '6' : `${day_}`) == false) {
                            _this5.disabledDates = [
                                ..._this5.disabledDates,
                                {
                                    start: all_saison[l],
                                    end: all_saison[l]
                                }
                            ];
                        }
                        l++;
                    }
                }
            }
        }
    },
    methods: {
        setItem(item) {
            this.item = item;
            return this.item != null;
        },
        availability: function ($string) {
            if ($string == null || String($string).trim() == '') {
                return [];
            }
            return String($string).split(',');
        },
        onDayClick(day) {
            var _this5 = this;
            if (day.isDisabled != false) return;
            const _index = _this5.selectCalendarDate.findIndex(function (_date) {
                return moment.duration(moment(day.date).diff(moment(_date))).asDays() == 0;
            })
            $(day.el).parents('div#my_calendar').each(function () {
                $(this).find('.vc-pane-container').each(function () {
                    const _content = $('<div/>').attr({
                        class: 'calendar-content-day-div',
                    }).append(
                        $('<div/>').attr({
                            class: 'calendar-content-day-div-content'
                        }).append(
                            $('<div/>').attr({
                                class: 'calendar-content-day-div-close'
                            }).append(
                                $('<a/>').attr({
                                    class: 'close-button'
                                })
                            ).on('click', function () {
                                _content.remove();
                            })
                        ).append(
                            $('<div/>').attr({
                                class: 'calendar-content-day-div-title'
                            }).html(`${String(day.ariaLabel).substr(0, 1).toUpperCase()}${String(day.ariaLabel).substr(1)}`)
                        ).append(
                            $('<span/>').attr({
                                class: `calendar-content-day-span add ${_index >= 0 ? 'd-none' : ''}`
                            }).on('click', function () {
                                _this5.selectCalendarDate = _this5.isMultipleDate == true ? [..._this5.selectCalendarDate, day.date] : [day.date];
                                _content.remove();
                            }).html('Ajoutez')
                        ).append(
                            $('<span/>').attr({
                                class: `calendar-content-day-span remove ${_index < 0 ? 'd-none' : ''}`
                            }).on('click', function () {
                                _this5.selectCalendarDate = [..._this5.selectCalendarDate.filter((_date, index) => index != _index)];
                                _content.remove();
                            }).html('Enlevez')
                        )).appendTo(this);
                })
            })
        },
        checkPersonne(event, prefix, array_id, id) {
            var _this5 = this;
            const _val = $(event.target).val() != '' ? $(event.target).val() : 0;
            var _temp = { ..._this5.personneChecked }
            _temp[`${prefix}${id}`] = {
                id: id,
                type: _this5.personne.filter(_pers_ => _pers_.id == id)[0],
                prix: 0,
                nb: _val,
                capacite_min: 0
            };
            _this5.personneChecked = { ..._temp };
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
                            ..._this5.item.supplement[table].filter(_table_item => _table_item.id == _val).map(_table_item => ({ ..._table_item, prix_calculer: 0 }))
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
        detailSupplementPrix() {
            var _this5 = this;

            const supp_dejeneur = _this5.item.supplement.dejeneur != undefined ? _this5.item.supplement.dejeneur : [];
            supp_dejeneur.map(function (_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function (_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.selectCalendarDate.length);
                        }
                    }
                });
                $(`[for="dejeneur_${_arr_supp.id}"]`).each(function () {
                    $(this).attr('data-label', `${parseFloat(somme).toFixed(2)}€`);
                });
            })
            /** */
            const supp_activite = _this5.item.supplement.activite != undefined ? _this5.item.supplement.activite : [];
            supp_activite.map(function (_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function (_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.selectCalendarDate.length);
                        }
                    }
                });
                $(`[for="activite_${_arr_supp.id}"]`).each(function () {
                    $(this).attr('data-label', `${parseFloat(somme).toFixed(2)}€`);
                });
            })
            /** */
            const supp_autres = _this5.item.supplement.autres != undefined ? _this5.item.supplement.autres : [];
            supp_autres.map(function (_arr_supp) {
                var somme = 0;
                _arr_supp.tarif.map(function (_item_supp_tarif) {
                    for (var pers in _this5.personneChecked) {
                        if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                            somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.selectCalendarDate.length);
                        }
                    }
                });
                $(`[for="autres_${_arr_supp.id}"]`).each(function () {
                    $(this).attr('data-label', `${parseFloat(somme).toFixed(2)}€`);
                });
            })
            _this5.prix_supp_personne = 0;
            for (var supp in _this5.supplementCkecked) {
                var somme_all = 0;
                _this5.supplementCkecked[supp] = _this5.supplementCkecked[supp].map(function (_item_supp) {
                    var somme = 0;
                    _item_supp.tarif.map(function (_item_supp_tarif) {
                        for (var pers in _this5.personneChecked) {
                            if (_this5.personneChecked[pers].id == _item_supp_tarif.type_personne_id) {
                                somme = somme + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.selectCalendarDate.length);
                                somme_all = somme_all + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.selectCalendarDate.length);
                                _this5.prix_supp_personne = _this5.prix_supp_personne + (parseFloat(_item_supp_tarif.prix_vente) * _this5.personneChecked[pers].nb * _this5.selectCalendarDate.length);
                            }
                        }
                    });
                    return {
                        ..._item_supp,
                        prix_calculer: somme
                    }
                });
                $(`[for="${supp}"]`).each(function () {
                    $(this).attr('data-label', `${parseFloat(somme_all).toFixed(2)}€`);
                });
            }

        },
        checkSaison() {
            var _this5 = this;
            if (_this5.selectCalendarDate.length == 0)
                return;

            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/excursions/product-prices`, {
                saison: _this5.selectCalendarDate,
                excursion_id: _this5.item.id
            }).then(function (response) {
                /** produit command added */
                _this5.prix_saison = response.data.tarif;
                /** */
            }).catch(function (errors) {

            }).finally(() => {
                loading_.remove();
            });
        },
        checkPrix() {
            var _this5 = this;
            var prix_personne = {};
            _this5.prix_excursion_personne = 0;
            _this5.marge_calculer = 0;
            _this5.prix_saison.map(function (_val_tarif) {
                _val_tarif.map(function (_item_tarif) {
                    for (var p in _this5.personneChecked) {
                        if (_this5.personneChecked[p].id == _item_tarif.type_personne_id) {
                            const _tarif = parseFloat(_item_tarif.prix_vente) * _this5.personneChecked[p].nb;
                            const marge = parseFloat(_item_tarif.marge) * _this5.personneChecked[p].nb;
                            prix_personne[p] = {
                                ..._this5.personneChecked[p],
                                prix_unitaire: parseFloat(_item_tarif.prix_vente),
                                marge: (prix_personne[p] != undefined && prix_personne[p].marge != undefined) ? (parseFloat(prix_personne[p].marge) + marge) : marge,
                                prix_calculer: (prix_personne[p] != undefined && prix_personne[p].prix_calculer != undefined) ? (parseFloat(prix_personne[p].prix_calculer) + _tarif) : _tarif
                            }
                        }
                    }
                })
            });
            for (var _p in prix_personne) {
                _this5.prix_excursion_personne = _this5.prix_excursion_personne + prix_personne[_p].prix_calculer;
                _this5.marge_calculer = _this5.marge_calculer + prix_personne[_p].marge;
                $(`[id="${_p}"]`).each(function () {
                    $(this).text(`${parseFloat(prix_personne[_p].prix_calculer).toFixed(2)}€`);
                });
                _this5.personneChecked[_p]['marge'] = prix_personne[_p].marge;
                _this5.personneChecked[_p]['prix'] = prix_personne[_p].prix_calculer;
                _this5.personneChecked[_p]['unitaire'] = prix_personne[_p].prix_unitaire;
            }
        },
        checkPersonneAdulte() {
            var checked = false;
            const msg = `<li>Veuillez renseigner au moins une (1) personne </li>`;
            for (var k in this.personneChecked) {
                if (this.personneChecked[k].nb > 0) {
                    checked = true;
                }
            }
            return {
                valid: checked,
                msg: checked ? '' : msg
            }
        },
        validerCommander(event) {
            var _this5 = this,
                data_form = null,
                _el = event.currentTarget,
                personne_checked = {};
            const checkPersonneAdulte = _this5.checkPersonneAdulte();
            $('#reservetion_form').each(function () {
                data_form = Myform(this).serialized();
            });

            if (_this5.selectCalendarDate.length == 0 || data_form == null || checkPersonneAdulte.valid == false) {
                _this5.$modal.show('dialog', {
                    title: _this5.$dictionnaire.info_form_incomplete_title,
                    text: `<ul><li>${_this5.$dictionnaire.info_form_incomplete}</li> ${checkPersonneAdulte.msg}</ul>`,
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
                selectCalendarDate: _this5.selectCalendarDate,
                isMultipleDate: _this5.isMultipleDate,
                fromDate: { month: _this5.selectCalendarDate[0].getMonth() + 1, year: _this5.selectCalendarDate[0].getUTCFullYear() },
                supplementCkecked: _this5.supplementCkecked,
                personneChecked: _this5.personneChecked,
                marge_calculer: _this5.marge_calculer,
                prix_excursion_personne: _this5.prix_excursion_personne,
                prix_supp_personne: _this5.prix_supp_personne,
                date_commande: _this5.date_commande,
                item: _this5.item
            };
            const computed = {
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

            for (var _pers in _this5.personneChecked) {
                personne_checked[_pers] = _this5.personneChecked[_pers].nb;
            }

            _this5.putCommande(
                event,
                'excursion', {
                data: JSON.stringify(data),
                computed: JSON.stringify(computed),
                form: data_form,
                edit_pannier: _this5.editpannier == 'true',
                date_commande: _this5.date_commande,
            },
                function (commande_reponse) {
                    _this5.$modal.show({
                        template: `
                            <div class="card border-success text-center">
                                <div class="card-header bg-success text-uppercase font-weight-bold card-title text-white">
                                    ${_this5.$dictionnaire.commande_produit_succes_title}
                                </div>
                                <div class="card-body pb-5">
                                    <h5 class="card-title">Saelt voyages propose de la billetterie maritime, des locations de voiture, des transferts.</h5>
                                    <p class="card-text">Réservez dès maintenant sur un simple clic </p>
                                    <a href="#" class="btn btn-sm btn-primary" @click.prevent="billeterie">Billetterie maritime</a>
                                    <a href="#" class="btn btn-sm btn-primary" @click.prevent="location">Locations de vehicule</a>
                                    <a href="#" class="btn btn-sm btn-primary" @click.prevent="transfert">Transferts</a>
                                </div>
                                <div class="card-footer text-muted d-flex align-items-center bg-success">
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click.prevent="achat">${_this5.$dictionnaire.commande_produit_btn_continuer_achat}</button>
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click.prevent="panier">${_this5.$dictionnaire.commande_produit_btn_passer_commande}</button>
                                </div>
                            </div>
                      `,
                        props: ['billeterie', 'location', 'transfert', 'panier', 'achat']
                    }, {
                        billeterie: function () {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/billetteries`, {
                                parcours: 1,
                                depart: _this5.item.lieu_depart_id,
                                arrive: _this5.item.lieu_arrive_id,
                                date_depart: moment(_this5.selectCalendarDate[0]).format('YYYY-MM-DD'),
                                ...personne_checked,
                                customer_search: {
                                    parcours: 1,
                                    depart: _this5.item.lieu_depart_id,
                                    arrive: _this5.item.lieu_arrive_id,
                                    date_depart: moment(_this5.selectCalendarDate[0]).format('YYYY-MM-DD'),
                                    ...personne_checked
                                },
                                date_commande_relation_childre: commande_reponse.date_commande,
                                produit_link_commande_relation_childre: commande_reponse.produit_link
                            })
                        },
                        location: function () {
                            _this5.$modal.hide('dialog');
                            if (_this5.item.agence_location[0] == undefined) {
                                window.location.href = `${_this5.urlbase}/locations`;
                            } else {
                                _this5.managerRequest(event, `${_this5.urlbase}/locations`, {
                                    lieu_recuperation: _this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].id : '',
                                    lieu_restriction: _this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].id : '',
                                    date_recuperation: _this5.selectCalendarDate[0],
                                    date_restriction: _this5.selectCalendarDate[0],
                                    heure_recuperation: String(_this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].heure_ouverture : '00:00').split(':')[0],
                                    heure_restriction: String(_this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].heure_fermeture : '23:59').split(':')[0],
                                    //
                                    ville_excursion: _this5.item.ville_id,
                                    //
                                    customer_search: {
                                        lieu_recuperation: _this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].id : '',
                                        lieu_restriction: _this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].id : '',
                                        date_recuperation: new Date(_this5.selectCalendarDate[0]),
                                        date_restriction: new Date(_this5.selectCalendarDate[0]),

                                        heure_recuperation: String(_this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].heure_ouverture : '00:00').split(':')[0],
                                        heure_restriction: String(_this5.item.agence_location[0] != undefined ? _this5.item.agence_location[0].heure_fermeture : '23:59').split(':')[0],
                                        //
                                        ville_excursion: _this5.item.ville_id
                                    },
                                    date_commande_relation_childre: commande_reponse.date_commande,
                                    produit_link_commande_relation_childre: commande_reponse.produit_link
                                })
                            }
                        },
                        transfert: function () {
                            _this5.$modal.hide('dialog');
                            window.location.href = `${_this5.urlbase}/transferts`;
                        },
                        panier: function () {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/panier`, { id: $(_el).attr('id-commande') })
                        },
                        achat: function () {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.url}`, { id: $(_el).attr('id-commande') })
                        }
                    }, {
                        height: 'auto',
                        clickToClose: false
                    }, {
                        'before-open': e => {

                        },
                        'before-close': e => {

                        }
                    })
                }
            );
        }
    },
    props: [
        'urlcalendar',
        'datacalendar',
        'personne',
        'mycommande',
        'editpannier'
    ]
});