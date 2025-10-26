import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('tarif-excursion-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {
                supplements: [],
                taxes: []
            },
            actionEditTarif: '',
            actionEditTarifForm: '',
            myEvent: {},
            tarif_form: [true, false],
            typePersonnes: [],
            saisons: [],
            readonly: false,
        }
    },
    methods: {
        editTarifForm(event, url, condition) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditTarifForm = response.data.tarifExcursion.resource_url;
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarifForm': function() {
                        $('#edit-tarif-form' + condition).each(function() {
                            Myform(this).setForm({...response.data.tarifExcursion, type_personne: response.data.tarifExcursion.personne.type });
                        })
                    }
                }
                _this5.$modal.show('edit_tarif_form' + condition)
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        updateTarifForm(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {}, true);
        },
        checkMarge(event, suffix_name) {
            const marge = $('input[name="marge' + suffix_name + '"]'),
                _this555 = this;
            marge.each(function() {
                //if ($(this).val() == '' || isNaN($(this).val())) $(this).val(0.0);
                const marge_val = ($(this).val() == '' || isNaN($(this).val())) ? 0.0 : $(this).val();
                $('input[name="prix_achat' + suffix_name + '"]').each(function() {
                    //if ($(this).val() == '' || isNaN($(this).val())) $(this).val(0.0);
                    const prix_achat = ($(this).val() == '' || isNaN($(this).val())) ? 0.0 : $(this).val();
                    $('input[name="prix_vente' + suffix_name + '"]').each(function() {
                        const calc = `${(parseFloat(prix_achat) + parseFloat(marge_val))}`
                        $(this).val(parseFloat(calc));
                    })
                })
            })
        },
        editTarifSaison(event, url, tabs = [false, true]) {
            //_this5.$notify({ type: 'info', title: ``, text: _this5.$dictionnaire.tarif_saison_vide });
            var _this5 = this;
            _this5.readonly = true;
            let loading = $('#edit-tarif').InputLoadRequest();
            _this5.tarif_form = tabs.map(is => !is);
            const _url = `${url}/${event.target.value}`
            axios.get(_url).then(function(response) {
                _this5.actionEditTarif = `${_this5.urlbase}/admin/tarif-excursions/${_this5.excursion.id}/update`;
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.saisons = response.data.saison ? response.data.saison : [];
                var _data_tarif = {};

                response.data.tarifExcursion.map(function(_data) {})
                _this5.typePersonnes.map(function(_type, index) {
                    const index_check = response.data.tarifExcursion.findIndex(function(_index_elm) {
                        return _index_elm.type_personne_id == _type.id;
                    });
                    if (index_check >= 0) {
                        _data_tarif['marge_' + index] = response.data.tarifExcursion[index_check].marge;
                        _data_tarif['prix_achat_' + index] = response.data.tarifExcursion[index_check].prix_achat;
                        _data_tarif['prix_vente_' + index] = response.data.tarifExcursion[index_check].prix_vente;
                        _data_tarif['saison_id'] = response.data.tarifExcursion[index_check].saison_id;
                    }
                });
                $('#edit-tarif').each(function() {
                    Myform(this).setForm(_data_tarif)
                });
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        editTarif(event, url, tabs = [false, true]) {
            var _this5 = this;
            _this5.readonly = true;
            let loading = $(event.target).InputLoadRequest();
            _this5.tarif_form = tabs.map(is => !is);
            axios.get(url).then(function(response) {
                _this5.actionEditTarif = `${_this5.urlbase}/admin/tarif-excursions/${_this5.excursion.id}/update`;
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.saisons = response.data.saison ? response.data.saison : [];
                var _data_tarif = {};

                response.data.tarifExcursion.map(function(_data) {})
                _this5.typePersonnes.map(function(_type, index) {
                    const index_check = response.data.tarifExcursion.findIndex(function(_index_elm) {
                        return _index_elm.type_personne_id == _type.id;
                    });
                    if (index_check >= 0) {
                        _data_tarif['marge_' + index] = response.data.tarifExcursion[index_check].marge;
                        _data_tarif['prix_achat_' + index] = response.data.tarifExcursion[index_check].prix_achat;
                        _data_tarif['prix_vente_' + index] = response.data.tarifExcursion[index_check].prix_vente;
                        _data_tarif['saison_id'] = response.data.tarifExcursion[index_check].saison_id;
                    }
                });
                _this5.$modal.show('edit_tarif');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarif': function() {
                        var _data = response.data.tarifExcursion;
                        $('#edit-tarif').each(function() {
                            Myform(this).setForm(_data_tarif)
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },

        createTarif(event, url) {
            var _this5 = this;
            _this5.readonly = false;
            let loading = $(event.target).InputLoadRequest();
            _this5.typePersonnes = [];
            axios.get(url).then(function(response) {
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.saisons = response.data.saison ? response.data.saison : [];
                _this5.tarif_form = [true, false];
                _this5.$modal.show('create_tarif');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeTarif(event, modal) {
            var _this5 = this;
            /*remove error*/
            $('#tarif_excursion_block').each(function() {
                    $(this).removeClass('block-error');
                    $(this).find('.fallback-error').each(function() {
                        $(this).remove();
                    });
                })
                /* remove error*/
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                },
                errors: function(error) {
                    $('#create-tarif').each(function() {
                        if (error.response && error.response.status && error.response.status === 422) {
                            var origin_errors = {...error.response.data.errors };
                            for (const xx in origin_errors) {
                                const x = String(xx).split('.');
                                origin_errors[x[1]] = origin_errors[xx];
                            }
                            Myform(this).erreur({ error: 422, data: origin_errors });
                            for (var err in origin_errors) {
                                if (['saison_id'].indexOf(String(err)) >= 0 && !_this5.tarif_form[0])
                                    _this5.tarif_form = [true, false];
                            }

                            $('#tarif_excursion_block').each(function() {
                                $(this).addClass('block-error');
                                $('<div/>').attr({ class: 'fallback-error' }).html(`${_this5.$dictionnaire.form_error}`).appendTo($(this));
                            })
                        }
                    })
                },
            }, false);
        },
        createPersonne(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createPersonne': function() {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_personne');
        },
        storePersonne(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.typePersonnes = response.data.typePersonne;
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        createSaison(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createSaison': function() {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_saison');
        },
        storeSaison(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.saisons.push(response.data.saison);
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        changeFormTarif(event, form = []) {
            event.preventDefault();
            var _this5 = this;
            if (_this5.tarif_form[0]) {
                $('[name="saison_id"]').each(function() {
                    if (Myform(this).isValid()) {
                        _this5.tarif_form = form.map(is => !is);
                    }
                })
            } else {
                _this5.tarif_form = form.map(is => !is);
            }
            /*remove error*/
            $('#tarif_excursion_block').each(function() {
                    $(this).removeClass('block-error');
                    $(this).find('.fallback-error').each(function() {
                        $(this).remove();
                    });
                })
                /* remove error*/
        },
        duplicateTarif() {
            var _this5 = this;
            $('#edit-tarif').each(function() {
                Myform(this).removeErreur();
            })
            $('#create-tarif').each(function() {
                Myform(this).removeErreur();
            })
            $('input[name="montant_0"]').each(function() {
                const val = $(this).val();
                _this5.typePersonnes.map((types, index) => {
                    if (index > 0) {
                        $('input[name="montant_' + index + '"]').each(function() {
                            $(this).val(val);
                        });
                    }
                })
            })
        },
        redirect(url) {
            window.location.replace(url);
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'excursion',
    ]
});