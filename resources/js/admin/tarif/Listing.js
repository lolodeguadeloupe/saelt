import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
import lang from '../app-components/lang';

Vue.component('tarif-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditTarif: '',
            actionEditTarifPersonne: '',
            typeChambre: [],
            allotements: [],
            typePersonnes: [],
            saisons: [],
            myEvent: {},
            taxe: false,
            form_tarif: [false, false],
            form_tarif_edit: [false, false],
            url_resourse_tarif: "",
            url_resourse_tarif_vol: "",
            condition_vol: false,
            max_days: '',
            has_supp_tarif: false,
            affiche_detail: false,
            state_Chambres: this.typechambre,
            data_request_customer: {
                type_chambre_id: this.$joinKey(this.typechambre, 'id', ',')
            },
            //
            basetypes: [],
        }
    },
    watch: {
        'data_request_customer.type_chambre_id': function data_request_customerType_chambre_id(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.loadData();
            }
        },
    },
    methods: {
        checkPersonneBaseType(event) {
            var _this5 = this;
            _this5.basetypes = [];
            _this5.typeChambre.filter(function (_val) {
                if (event.target.value == _val.id) {
                    _this5.basetypes = [..._this5.basetypes, ..._val.base_type].map(function (_val_base) {
                        return {
                            ..._val_base,
                            typeChambre: _val,
                        }
                    });
                }
            });
        },
        checkPersonneSupp(event) {
            var _this5 = this;
            _this5.has_supp_tarif = false;
            _this5.basetypes.map(function (_val) {
                if (event.target.value == _val.id) {
                    _this5.has_supp_tarif = parseInt(_val.nombre) < parseInt(_val.typeChambre.capacite);
                }
            });
        },
        changeTaxe(event) {
            this.taxe = event.target.checked;
        },
        editTarif(event, url, tabs = [false, true], tab_action = false) {
            var _this5 = this;
            this.url_resourse_tarif = url;
            this.form_tarif_edit = tabs.map(tab => !tab);
            this.taxe = false;
            this.marge_prix = false;
            _this5.url_resourse_tarif_vol = null;
            _this5.typePersonnes = [];
            _this5.basetypes = [];
            _this5.has_supp_tarif = false;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTarif = response.data.tarif.resource_url;
                _this5.saisons = response.data.saisons;
                _this5.typePersonnes = response.data.personnes;
                _this5.typeChambre = response.data.typeChambre;
                _this5.allotements = response.data.allotement;
                _this5.taxe = response.data.tarif.taxe_active == '0' ? false : true;
                var _data_tarif = { ...response.data.tarif },
                    tarifs = _data_tarif.tarif;

                /**/
                response.data.typeChambre.map(function (_val) {
                    if (response.data.tarif.type_chambre_id == _val.id) {
                        _this5.basetypes = [..._this5.basetypes, ..._val.base_type].map(function (_val_base) {
                            return {
                                ..._val_base,
                                typeChambre: _val,
                            }
                        });
                        if (response.data.tarif.base_type != undefined) {
                            _this5.has_supp_tarif = parseInt(response.data.tarif.base_type.nombre) < parseInt(_val.capacite);
                        }
                    }
                });
                /** */
                _this5.typePersonnes.map(function (_type, index) {
                    for (var i in tarifs) {
                        if (tarifs[i].type_personne_id == _type.id) {
                            _data_tarif['marge_' + index] = tarifs[i].marge;
                            _data_tarif['prix_achat_' + index] = tarifs[i].prix_achat;
                            _data_tarif['prix_vente_' + index] = tarifs[i].prix_vente;
                            //
                            _data_tarif['marge_supp_' + index] = tarifs[i].marge_supp;
                            _data_tarif['prix_achat_supp_' + index] = tarifs[i].prix_achat_supp;
                            _data_tarif['prix_vente_supp_' + index] = tarifs[i].prix_vente_supp;
                        }
                    }
                })
                if (tab_action) {
                    if (response.data.tarif.vol) {
                        _this5.url_resourse_tarif_vol = response.data.tarif.vol.resource_url;
                        $('#edit-tarif').each(function () {
                            Myform(this).setForm({ 'condition-vol': '1' });
                        })
                    } else {
                        $('#edit-tarif-vol').each(function () {
                            Myform(this).setForm({ tarif_id: response.data.tarif.id, 'condition-vol': '0' });
                        })
                    }
                    setTimeout(function () {
                        $('#edit-tarif').each(function () {
                            Myform(this).setForm(_data_tarif);
                        })
                    }, 600);
                } else {
                    _this5.$modal.show('edit_tarif');
                    _this5.myEvent = {
                        ..._this5.myEvent,
                        'editTarif': function () {
                            var _data = response.data;
                            if (_data.tarif.vol) {
                                _this5.url_resourse_tarif_vol = _data.tarif.vol.resource_url;
                                _this5.condition_vol = true;
                                $('#edit-tarif').each(function () {
                                    Myform(this).setForm({ 'condition-vol': '1' });
                                })
                            } else {
                                _this5.condition_vol = false;
                                $('#edit-tarif-vol').each(function () {
                                    Myform(this).setForm({ tarif_id: _data.tarif.id, 'condition-vol': '0' });
                                })
                            }
                            $('#edit-tarif').each(function () {
                                Myform(this).setForm(_data_tarif);
                            })
                        }
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        editTarifVol(event, url, tabs) {

            var _this5 = this;
            this.changeFormTarifEdit(tabs)
            if (url == null) return;
            let loading = $(event.target).InputLoadRequest();
            axios.get(`${url}/edit`).then(function (response) {
                _this5.allotements = response.data.allotement;
                $('#edit-tarif-vol').each(function () {
                    Myform(this).setForm({
                        ...response.data.hebergementVol,
                        lieu_depart: response.data.hebergementVol.allotement.depart.name,
                        lieu_arrive: response.data.hebergementVol.allotement.arrive.name
                    });
                })
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createTarif(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            this.taxe = false;
            this.marge_prix = false;
            this.condition_vol = false;
            _this5.typePersonnes = [];
            axios.get(url).then(function (response) {
                _this5.saisons = response.data.saisons;
                _this5.typePersonnes = response.data.personnes;
                _this5.typeChambre = response.data.typeChambre;
                _this5.allotements = response.data.allotement;
                _this5.form_tarif = [true, false];
                _this5.$modal.show('create_tarif');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createTarif': function () {
                        $('#create-tarif').each(function () {
                            Myform(this).setForm({})
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        storeTarifAndVol(event, modal) {
            var _this5 = this;
            var loading = $(event.target).InputLoadRequest();
            const sub_data = _this5.submitTarif();
            const sub_data_vol = _this5.submitTarifVol();
            $("#tarif-hebergement-type-personne").each(function () {
                $(this).removeClass('block-error');
            })
            if (sub_data && sub_data_vol && _this5.condition_vol) {
                _this5.postData(
                    _this5.urltarifwithvol, { ...sub_data, ...sub_data_vol }, {
                    success: function (response) {
                        _this5.loadData();
                        _this5.$modal.hide(modal);
                    },
                    errors: function (error) {
                        $('#create-tarif').each(function () {
                            if (error.response && error.response.status && error.response.status === 422) {
                                Myform(this).erreur({ error: 422, data: error.response.data.errors });
                            }
                        })
                        $('#create-tarif-vol').each(function () {
                            if (error.response && error.response.status && error.response.status === 422) {
                                Myform(this).erreur({ error: 422, data: error.response.data.errors });
                            }
                        })
                        var trarif_error = false;
                        for (var err in error.response.data.errors) {
                            if (['type_personne_id', 'marge', 'prix_achat', 'prix_vente'].indexOf(String(err)) >= 0)
                                trarif_error = true;
                        }
                        if (trarif_error) {
                            $("#tarif-hebergement-type-personne").each(function () {
                                $(this).addClass('block-error');
                            })
                        }
                    },
                    finally: function () {
                        loading.remove();
                    }
                });
            } else if (sub_data && !_this5.condition_vol) {

                $('#create-tarif').each(function () {
                    _this5.postData(
                        $(this).attr('action'), { ...sub_data }, {
                        success: function () {
                            _this5.$modal.hide(modal);
                            _this5.loadData();
                        },
                        errors: function (error) {
                            $('#create-tarif').each(function () {
                                if (error.response && error.response.status && error.response.status === 422) {
                                    Myform(this).erreur({ error: 422, data: error.response.data.errors });
                                }
                            })
                            var trarif_error = false;
                            for (var err in error.response.data.errors) {
                                if (['type_personne_id', 'marge', 'prix_achat', 'prix_vente'].indexOf(String(err)) >= 0)
                                    trarif_error = true;
                            }
                            if (trarif_error) {
                                $("#tarif-hebergement-type-personne").each(function () {
                                    $(this).addClass('block-error');
                                })
                            }
                        },
                        finally: function () {
                            loading.remove();
                        }
                    })
                })
            } else {
                loading.remove();
            }
        },
        submitTarif() {
            var _this5 = this,
                data = null;
            $('#create-tarif').each(function () {
                data = Myform(this).serialized();
                if (!data) {
                    _this5.form_tarif = [true, false];
                }
            })
            return data;
        },
        submitTarifVol() {
            var _this5 = this,
                data = null;
            if (!_this5.condition_vol) return data;
            $('#create-tarif-vol').each(function () {
                data = Myform(this).serialized();
                if (!data) {
                    _this5.form_tarif = [false, true];
                }
            })
            return data;
        },
        submitTarifEdit() {
            var _this5 = this,
                data = null;
            $('#edit-tarif').each(function () {
                data = Myform(this).serialized();
                if (!data) {
                    _this5.form_tarif = [true, false];
                }
            })
            return data;
        },
        submitTarifVolEdit() {
            var _this5 = this,
                data = null;
            if (!_this5.condition_vol) return data;
            $('#edit-tarif-vol').each(function () {
                data = Myform(this).serialized();
                if (!data) {
                    _this5.form_tarif = [false, true];
                }
            })
            return data;
        },
        updateTarifAndVol(event, modal) {
            var _this5 = this;
            const sub_data = _this5.submitTarifEdit();
            const sub_data_vol = _this5.submitTarifVolEdit();
            $("#tarif-hebergement-type-personne").each(function () {
                $(this).removeClass('block-error');
            })
            if ((sub_data && sub_data_vol && _this5.condition_vol) || (sub_data && !_this5.condition_vol)) {

                this.$modal.show('dialog', {
                    title: `${_this5.$dictionnaire.warning}!`,
                    text: _this5.$dictionnaire.confirm_save,
                    buttons: [{
                        title: `<span class="btn-dialog btn-warning">${_this5.$dictionnaire.confirm_no_cancel}.<span>`,
                        handler: function handler() {
                            _this5.$modal.hide('dialog');
                        }
                    }, {
                        title: `<span class="btn-dialog btn-primary">${_this5.$dictionnaire.confirm_yes_save}.<span>`,
                        handler: function handler() {
                            _this5.$modal.hide('dialog');
                            var loading = $(event.target).InputLoadRequest();
                            if (sub_data && sub_data_vol && _this5.condition_vol) {
                                $('#edit-tarif').each(function () {
                                    _this5.postData(
                                        `${_this5.urltarifwithvol}/${sub_data_vol.tarif_id}`, { ...sub_data, ...sub_data_vol }, {
                                        success: function (response) {
                                            _this5.loadData();
                                            _this5.$modal.hide(modal);
                                        },
                                        errors: function (error) {
                                            $('#edit-tarif').each(function () {
                                                if (error.response && error.response.status && error.response.status === 422) {
                                                    Myform(this).erreur({ error: 422, data: error.response.data.errors });
                                                }
                                            })
                                            $('#edit-tarif-vol').each(function () {
                                                if (error.response && error.response.status && error.response.status === 422) {
                                                    Myform(this).erreur({ error: 422, data: error.response.data.errors });
                                                }
                                            })
                                            var trarif_error = false;
                                            for (var err in error.response.data.errors) {
                                                if (['type_personne_id', 'marge', 'prix_achat', 'prix_vente'].indexOf(String(err)) >= 0)
                                                    trarif_error = true;
                                            }
                                            if (trarif_error) {
                                                $("#tarif-hebergement-type-personne").each(function () {
                                                    $(this).addClass('block-error');
                                                })
                                            }
                                        },
                                        finally: function () {
                                            loading.remove();
                                        }
                                    });
                                })
                            } else if (sub_data && !_this5.condition_vol) {
                                $('#edit-tarif').each(function () {
                                    _this5.postData(
                                        $(this).attr('action'), { ...sub_data }, {
                                        success: function () {
                                            _this5.$modal.hide(modal);
                                            _this5.loadData();
                                        },
                                        errors: function (error) {
                                            $('#edit-tarif').each(function () {
                                                if (error.response && error.response.status && error.response.status === 422) {
                                                    Myform(this).erreur({ error: 422, data: error.response.data.errors });
                                                }
                                            });
                                            var trarif_error = false;
                                            for (var err in error.response.data.errors) {
                                                if (['type_personne_id', 'marge', 'prix_achat', 'prix_vente'].indexOf(String(err)) >= 0)
                                                    trarif_error = true;
                                            }
                                            if (trarif_error) {
                                                $("#tarif-hebergement-type-personne").each(function () {
                                                    $(this).addClass('block-error');
                                                })
                                            }
                                        },
                                        finally: function () {
                                            loading.remove();
                                        }
                                    })
                                })
                            } else {
                                loading.remove();
                            }
                        }
                    }]
                });
            }

        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        checkVoyageVol(event) {
            this.condition_vol = event.target.value == '0' ? false : true;
            $("#condition-transport-loading-create").each(function () {
                $(this).css({ display: 'flex' });
                var _this5 = this
                setTimeout(function () {
                    $(_this5).css({ display: 'none' });
                }, 500);
            })
        },
        changeFormTarif(form = []) {
            var _this5 = this;
            if (this.form_tarif[0]) {
                $('#create-tarif').each(function () {
                    if (Myform(this).serialized())
                        _this5.form_tarif = form.map(is => !is);
                })
            } else {
                _this5.form_tarif = form.map(is => !is);
                /*$(this.id_form_tarif_vol).each(function () {
                    if (Myform(this).serialized())
                        _this5.form_tarif = form.map(is => !is);
                })*/
            }
        },
        changeFormTarifEdit(form = []) {
            var _this5 = this;
            if (this.form_tarif_edit[0]) {
                $('#edit-tarif').each(function () {
                    if (Myform(this).serialized())
                        _this5.form_tarif_edit = form.map(is => !is);
                })
            } else {
                _this5.form_tarif_edit = form.map(is => !is);
                /*$(this.id_form_tarif_vol).each(function () {
                    if (Myform(this).serialized())
                        _this5.form_tarif = form.map(is => !is);
                })*/
            }
        },
        changeAllotementVol(event) {
            var allotement = this.allotements.filter(val => val.id == event.target.value);
            if (!allotement.length) return;
            allotement = allotement[0];
            $('#edit-tarif-vol').each(function () {
                Myform(this).setForm({
                    depart: allotement.date_depart,
                    arrive: allotement.date_arrive,
                    heure_depart: allotement.heure_depart,
                    heure_arrive: allotement.heure_arrive,
                    lieu_depart: allotement.depart.name,
                    lieu_arrive: allotement.arrive.name
                })
            });
            $('#create-tarif-vol').each(function () {
                Myform(this).setForm({
                    depart: allotement.date_depart,
                    arrive: allotement.date_arrive,
                    heure_depart: allotement.heure_depart,
                    heure_arrive: allotement.heure_arrive,
                    lieu_depart: allotement.depart.name,
                    lieu_arrive: allotement.arrive.name
                })
            })
        },
        createPersonne(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createPersonne': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_personne');
        },
        storePersonne(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.typePersonnes = response.data.typePersonne;
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        checkMarge(event, suffix_name) {
            const marge = $('input[name="marge' + suffix_name + '"]'),
                _this555 = this;
            marge.each(function () {
                //if ($(this).val() == '' || isNaN($(this).val())) $(this).val(0.0);
                const marge_val = ($(this).val() == '' || isNaN($(this).val())) ? 0.0 : $(this).val();
                $('input[name="prix_achat' + suffix_name + '"]').each(function () {
                    //if ($(this).val() == '' || isNaN($(this).val())) $(this).val(0.0);
                    const prix_achat = ($(this).val() == '' || isNaN($(this).val())) ? 0.0 : $(this).val();
                    $('input[name="prix_vente' + suffix_name + '"]').each(function () {
                        const calc = `${(parseFloat(prix_achat) + parseFloat(marge_val))}`
                        $(this).val(parseFloat(calc));
                        $(this).removeInputErrer();
                    })
                })
            })
        },
        editTarifPersonne(event, url, condition) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTarifPersonne = response.data.tarifTypePersonneHebergement.resource_url;
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarifPersonne': function () {
                        $('#edit-tarif-form' + condition).each(function () {
                            Myform(this).setForm({ ...response.data.tarifTypePersonneHebergement, type_personne: response.data.tarifTypePersonneHebergement.personne.type });
                        })
                    }
                }
                _this5.$modal.show('edit_tarif_personne' + condition)
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        updateTarifForm(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.$modal.hide(modal)
                }
            }, false, {}, true);
        },
        detail(id) {
            this.$managerliens({
                is_parent: false,
                parent_name: 'hebergement',
                href: `${this.action}/${id}?heb=${this.idheb}`,
                name: 'Tarif detail',
                body: event.target,
                _this: this,
                axios: axios,
                liens: 'childre',
                range: '3',
                _$: $
            });
        },
        checkMaxDays(val = 0) {
            var _this5 = this;
            this.saisons.map(function (_saison) {
                if (_saison.id == val) {
                    _this5.max_days = _this5.$intervalDateDays(_this5.$parseDate(_saison.debut), _this5.$parseDate(_saison.fin));
                    $('[name="jour_max"').each(function () {
                        //$(this).val(_this5.max_days);
                    });
                    $('[name="nuit_max"]').each(function () {
                        //$(this).val(_this5.max_days + 1);
                    });
                }
            });
        }
    },
    props: [
        'url',
        'action',
        'idheb',
        'urlpersonne',
        'urlchambre',
        'urlsaison',
        'urltarifvol',
        'urltarifwithvol',
        'urlallotement',
        'urlbase', 'urlasset', 'typechambre', 'urlbasetype'
    ]
});