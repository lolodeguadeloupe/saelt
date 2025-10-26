import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('supplement-excursion-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditSupplement: '',
            actionEditTarifForm: '',
            actionEditTarifPersonne: '',
            myEvent: {},
            supplement_form: [true, false],
            typePersonnes: [],
            icon: []
        }
    },
    methods: {
        editTarifForm(event, url, condition) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTarifPersonne = response.data.tarifSupplementExcursion.resource_url;
                _this5.$modal.show('edit_tarif_form');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarifPersonne': function () {
                        $('#edit-tarif-form' + condition).each(function () {
                            Myform(this).setForm({ ...response.data.tarifSupplementExcursion, type_personne: response.data.tarifSupplementExcursion.personne.type });
                        })
                    }
                }
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarifForm': function () {
                        $('#edit-tarif-form').each(function () {
                            Myform(this).setForm(_data_tarif)
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        updateTarifForm(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false, {}, true);
        },
        editSupplement(event, url, tabs = [false, true], tab_action = false) {
            var _this5 = this;
            _this5.isChangedFom = true;
            let loading = $(event.target).InputLoadRequest();
            _this5.supplement_form = tabs.map(is => !is);
            axios.get(url).then(function (response) {
                _this5.actionEditSupplement = response.data.supplementExcursion.resource_url;
                _this5.icon = response.data.supplementExcursion.icon ? [response.data.supplementExcursion.icon] : [];
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                var _data_tarif = { ...response.data.supplementExcursion },
                    tarifs = _data_tarif.tarif;
                _this5.typePersonnes.map(function (_type, index) {
                    for (var i in tarifs) {
                        if (tarifs[i].type_personne_id == _type.id) {
                            _data_tarif['marge_' + index] = tarifs[i].marge;
                            _data_tarif['prix_achat_' + index] = tarifs[i].prix_achat;
                            _data_tarif['prix_vente_' + index] = tarifs[i].prix_vente;
                        }
                    }
                })
                if (tab_action) {
                    $('#edit-supplement').each(function () {
                        Myform(this).setForm({ ..._data_tarif, prestataire_name: _data_tarif.prestataire ? _data_tarif.prestataire.name : '' })
                    })
                } else {
                    _this5.$modal.show('edit_supplement');
                    _this5.myEvent = {
                        ..._this5.myEvent,
                        'editSupplement': function () {
                            $('#edit-supplement').each(function () {
                                Myform(this).setForm({ ..._data_tarif, prestataire_name: _data_tarif.prestataire ? _data_tarif.prestataire.name : '' })
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
        createSupplement(event, url) {
            var _this5 = this;
            _this5.isChangedFom = false;
            _this5.icon = [];
            let loading = $(event.target).InputLoadRequest();
            _this5.typePersonnes = [];
            axios.get(url).then(function (response) {
                _this5.typePersonnes = response.data.typePersonne;
                _this5.supplement_form = [true, false];
                _this5.$modal.show('create_supplement');
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeSupplement(event, modal) {
            var _this5 = this;
            $('#supplement_excursion_block').each(function () {
                $(this).removeClass('block-error');
                $(this).find('.fallback-error').each(function () {
                    $(this).remove();
                });
            })
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                },
                errors: function (error) {
                    $('#create-supplement').each(function () {
                        if (error.response && error.response.status && error.response.status === 422) {
                            var origin_errors = { ...error.response.data.errors };
                            for (const xx in origin_errors) {
                                const x = String(xx).split('.');
                                origin_errors[x[1]] = origin_errors[xx];
                            }
                            Myform(this).erreur({ error: 422, data: origin_errors });
                            for (var err in origin_errors) {
                                if (['titre'].indexOf(String(err)) >= 0 && !_this5.supplement_form[0])
                                    _this5.supplement_form = [false, true];
                            }

                            $('#supplement_excursion_block').each(function () {
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
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        changeFormSupplement(event, form = []) {
            event.preventDefault();
            var _this5 = this;
            if (_this5.supplement_form[0]) {
                $('input[name="titre"]').each(function () {
                    if (Myform(this).isValid()) {
                        _this5.supplement_form = form.map(is => !is);
                    }
                })
            } else {
                _this5.supplement_form = form.map(is => !is);
            }
        },
        duplicateTarif() {
            var _this5 = this;
            $('#edit-supplement').each(function () {
                Myform(this).removeErreur();
            })
            $('#create-supplement').each(function () {
                Myform(this).removeErreur();
            })
            $('input[name="tarif_0"]').each(function () {
                const val = $(this).val();
                _this5.typePersonnes.map((types, index) => {
                    if (index > 0) {
                        $('input[name="tarif_' + index + '"]').each(function () {
                            $(this).val(val);
                        });
                    }
                })
            })
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
                    })
                })
            })
        },
        uploadIcon(event, drop = false) {
            var _this5 = this,
                progress_bar = $("<div/>").css({
                    'background-color': 'green',
                    'width': '0%',
                    'height': '100%',
                    'position': 'absolute',
                    'z-index': '12',
                    'top': '0',
                    'left': '0'
                });

            const files = drop ? event.dataTransfer.files : event.target.files;
            for (const file of files) {
                if (file && file.type && ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'].includes(String(file.type))) {
                    if (file.size && file.size > 1024 * 1024 * 1024 * 4) {
                        _this5.$notify({ type: 'error', title: 'Error!', text: `${_this5.$dictionnaire.file_error}` });
                    } else {
                        var reader = new FileReader();
                        reader.onload = (data) => {
                            _this5.icon = [data.target.result];
                            progress_bar.remove();
                        }
                        reader.onprogress = (_event) => {
                            $($(event.target).is('figure') ? $(event.target) : $(event.target).parents('figure')).each(function () {
                                $(this).find('.my-_btn-add').each(function () {
                                    $(this).append(progress_bar);
                                    if (_event.loaded && _event.total) {
                                        const percent = (_event.loaded / _event.total) * 100;
                                        progress_bar.css({ width: `${percent}%` });
                                    }
                                })
                            })
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    _this5.$notify({ type: 'error', title: 'Error!', text: `${_this5.$dictionnaire.file_size}` });
                }
            }
        },
        checkSupplement(val) {
            var _this5 = this;
            _this5.typesupplement.map(function (_supp) {
                if (_supp.id == val) {
                    _this5.icon = [_supp.icon];
                }
            })
        },
        autocompletePrestataire() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                },
                fnBtnNew: function (event, options) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'excursion',
                        href: `${_this5.urlbase}/admin/prestataires`,
                        name: _this5.$dictionnaire.prestataire,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'complement',
                        range: '3',
                        _$: $
                    });
                },
                detailInfo: ['name', 'ville.name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
    },
    props: [
        'url',
        'action',
        'devises',
        'typesupplement',
        'excursion',
        'urlbase', 'urlasset'
    ]
});