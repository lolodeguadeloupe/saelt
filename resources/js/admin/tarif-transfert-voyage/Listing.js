import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
import '../app-components/helperJquery';

Vue.component('tarif-transfert-voyage-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: { description: '' },
            actionEditTarif: '',
            myEvent: {},
            typePersonnes: [],
            data_request_customer: {
                tranche_transfert_voyage_id: '',
                trajet_transfert_voyage_id: '',
            },
            state_tranchetransfertvoyage: [...this.tranchetransfertvoyage],
            state_trajettransfertvoyage: [...this.trajettransfertvoyage],
        }
    },
    watch: {
        'data_request_customer.tranche_transfert_voyage_id': function data_request_customerTranche_transfert_voyage_id(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.data_request_customer.tranche_transfert_voyage_id = newVal;
                this.loadData();
            }
        },
        'data_request_customer.trajet_transfert_voyage_id': function data_request_customerTrajet_transfert_voyage_id(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.data_request_customer.trajet_transfert_voyage_id = newVal;
                this.loadData();
            }
        }
    },
    methods: {
        update_state_data_childre(_data) {
            var _this55 = this,
                data = _data.data;
            ['tranchetransfertvoyage', 'trajettransfertvoyage'].map(function(val) {
                if (data[val]) {
                    _this55[`state_${val}`] = data[val];
                }
            })
        },
        editTarif(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.actionEditTarif = response.data.resource_url;
                var data = [];
                response.data.tarifTransfertVoyage.map(function(_data_tarif) {
                    data[`prix_achat_aller_retour_${_data_tarif.type_personne_id}`] = _data_tarif.prix_achat_aller_retour;
                    data[`marge_aller_retour_${_data_tarif.type_personne_id}`] = _data_tarif.marge_aller_retour;
                    data[`prix_vente_aller_retour_${_data_tarif.type_personne_id}`] = _data_tarif.prix_vente_aller_retour;
                    //
                    data[`prix_achat_aller_${_data_tarif.type_personne_id}`] = _data_tarif.prix_achat_aller;
                    data[`marge_aller_${_data_tarif.type_personne_id}`] = _data_tarif.marge_aller;
                    data[`prix_vente_aller_${_data_tarif.type_personne_id}`] = _data_tarif.prix_vente_aller;
                    //
                    data['type_personne_id'] = _data_tarif.personne.id;
                    data['type_personne_titre'] = _data_tarif.personne.type;
                    //
                    data['trajet_transfert_voyage_id'] = _data_tarif.trajet.id;
                    data['trajet_transfert_voyage_titre'] = _data_tarif.trajet.titre;
                    //
                    data['tranche_transfert_voyage_id'] = _data_tarif.tranche.id;
                    data['tranche_transfert_voyage_titre'] = _data_tarif.tranche.titre;
                    //
                    data['type_transfert_id'] = _data_tarif.tranche.type.id;
                    data['type_transfert_titre'] = _data_tarif.tranche.type.titre;
                });

                data['prime_nuit'] = response.data.prime_nuit ? response.data.prime_nuit.prime_nuit : 0;
                _this5.state_tranchetransfertvoyage = response.data.tranchetransfertvoyage;


                let loading = $(event.target).InputLoadRequest();
                _this5.$modal.show('edit_tarif');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarif': function() {
                        $('#edit-tarif').each(function() {
                            Myform(this).setForm({
                                ...data
                            });
                        })
                        for (var _id in data) {
                            $(`#${_id}`).each(function() {
                                $(this).html(data[_id]);
                            });
                        }
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.response.datamessage ? error.response.response.datamessage : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });


        },
        createTarif(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.state_tranchetransfertvoyage = response.data.tranchetransfertvoyage;
                _this5.$modal.show('create_tarif');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createTarif': function() {}
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.response.datamessage ? error.response.response.datamessage : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });


        },
        storeTarif(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide(modal);
                }
            }, false);
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
                        $(this).removeInputErrer();
                    })
                })
            })
        },
        redirect(url) {
            window.location.replace(url);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        autocompleteTrajetVoyage() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function() {
                    _this5.$redirect(`${_this5.urlbase}/admin/trajet-transfert-voyages`);
                },
                detailInfo: ['titre'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        createPersonne(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createPersonne': function() {
                    loading.remove();
                }
            }
            _this5.$modal.show('create_personne');
        },
        storePersonne(event, modal) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            $('#create-personne').each(function() {
                const _type_pers = Myform(this).serialized();
                if (_type_pers != null) {
                    _type_pers['id'] = 0;
                    _type_pers['reference_prix'] = 0;
                    _this5.typePersonnes = [..._this5.typePersonnes, _type_pers];
                    loading.remove();
                    _this5.$modal.hide(modal);
                }
            });
        },
        deletePersonne(event, $index) {
            let loading = $(event.target).InputLoadRequest();
            this.typePersonnes = this.typePersonnes.filter((_val, _id) => _id != $index);
            this.$promise(function() {
                loading.remove();
            })
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'tranchetransfertvoyage',
        'trajettransfertvoyage',
    ]
});