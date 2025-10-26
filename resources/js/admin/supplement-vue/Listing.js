import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('supplement-vue-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditSupVue: '',
            myEvent: {},
            icon: ['assets/img/supplement/vue.png'],
            chambre: []
        }
    },
    methods: {
        editSupVue(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.form = { ..._this5.form, chambre: [] };
            axios.get(url).then(function (response) {
                _this5.icon = response.data.supplementVue.icon ? [response.data.supplementVue.icon] : [];
                _this5.actionEditSupVue = response.data.supplementVue.resource_url;
                _this5.chambre = response.data.chambre;
                _this5.form = { ..._this5.form, chambre: response.data.supplementVue.chambre };
                _this5.$modal.show('edit_sup_vue');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editSupVue': function () {
                        var _data = response.data.supplementVue;
                        $('#edit-sup-vue').each(function () {
                            Myform(this).setForm({
                                ..._data,
                                'marge': _data.tarif[0].marge,
                                'prix_achat': _data.tarif[0].prix_achat,
                                'prix_vente': _data.tarif[0].prix_vente,
                                prestataire_name: _data.prestataire ? _data.prestataire.name : ''
                            })
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createSupVue(event, url) {
            var _this5 = this;
            _this5.icon = ['assets/img/supplement/vue.png'];
            let loading = $(event.target).InputLoadRequest();
            _this5.form = { ..._this5.form, chambre: [] }
            axios.get(url).then(function (response) {
                _this5.chambre = response.data.chambre;
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createSupVue': function () { }
                }
                _this5.$modal.show('create_sup_vue');
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        storeSupVue(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false, {
                chambre: _this5.form.chambre != undefined ? _this5.form.chambre.map(val => val.id) : []
            });
        },
        redirect(url) {
            window.location.replace(url);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
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