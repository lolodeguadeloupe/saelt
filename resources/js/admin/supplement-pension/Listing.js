import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('supplement-pension-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditSupPension: '',
            actionEditTarifPersonne: '',
            chambres: [],
            myEvent: {},
            typePersonnes: [],
            icon: ['assets/img/supplement/repas.png']
        }
    },
    methods: {
        editSupPension(event, url) {
            var _this5 = this;
            _this5.typePersonnes = [];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.icon = response.data.supplementPension.icon ? [response.data.supplementPension.icon] : [];
                _this5.actionEditSupPension = response.data.supplementPension.resource_url;
                _this5.chambres = response.data.chambres;
                _this5.$modal.show('edit_sup_pension');
                var _data_tarif = { ...response.data.supplementPension },
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
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editSupPension': function () {
                        $('#edit-sup-pension').each(function () {
                            Myform(this).setForm({ ..._data_tarif, prestataire_name: _data_tarif.prestataire ? _data_tarif.prestataire.name : '' })
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createSupPension(event, url) {
            var _this5 = this;
            _this5.typePersonnes = [];
            _this5.icon = ['assets/img/supplement/repas.png'];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.chambres = response.data.chambres;
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createSupPension': function () { }
                }
                _this5.$modal.show('create_sup_pension');
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        storeSupPension(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
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
                    })
                })
            })
        },
        editTarifPersonne(event, url, condition) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTarifPersonne = response.data.tarifSupplementPension.resource_url;
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarifPersonne': function () {
                        $('#edit-tarif-form' + condition).each(function () {
                            Myform(this).setForm({ ...response.data.tarifSupplementPension, type_personne: response.data.tarifSupplementPension.personne.type });
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
        autocompletePrestataire() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                },
                fnBtnNew: function (event, options) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'hebergement',
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
        'appliquer',
        'urlchambre',
        'urlbase', 'urlasset'
    ]
});