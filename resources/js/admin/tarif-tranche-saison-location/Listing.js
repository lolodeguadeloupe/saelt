import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('tarif-tranche-saison-location-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditTarif: '',
            categories: [],
            data_request_customer: {
                saisons_id: '',
                tranche_saison_id: '',
            },
            state_tranche_saison: [...this.tranchesaison],
            state_saisons: [...this.saison],
        }
    },
    watch: {
        'data_request_customer.saisons_id': function data_request_customerSaisons_id(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.data_request_customer.saisons_id = newVal;
                this.loadData();
            }
        },
        'data_request_customer.tranche_saison_id': function data_request_customerTranche_saison_id(newVal, oldVal) {
            if (+newVal !== +oldVal) {
                this.data_request_customer.tranche_saison_id = newVal;
                this.loadData();
            }
        }
    },
    methods: {
        editTarif(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditTarif = response.data.tarifTrancheSaisonLocation.resource_url;
                var data = {
                    ...response.data.tarifTrancheSaisonLocation,
                    tranche_saison_titre: `${response.data.tarifTrancheSaisonLocation.tranche_saison.titre} (${response.data.tarifTrancheSaisonLocation.tranche_saison.nombre_min} à ${response.data.tarifTrancheSaisonLocation.tranche_saison.nombre_max})`,
                    saisons_titre: response.data.tarifTrancheSaisonLocation.saison.titre,
                };

                _this5.$modal.show('edit_tarif');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarif': function() {
                        $('#edit-tarif').each(function() {
                            Myform(this).setForm({
                                ...data
                            })
                        });
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
                _this5.state_tranche_saison = response.data.tranche_saison;
                _this5.state_saisons = response.data.saison;
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
            this.$modal.show('dialog', {
                title: `${_this5.$dictionnaire.warning}!`,
                text: _this5.$dictionnaire.confirm_save,
                buttons: [{ title: _this5.$dictionnaire.confirm_no_cancel }, {
                    title: `<span class="btn-dialog btn-info">${_this5.$dictionnaire.confirm_yes_save}.<span>`,
                    handler: function handler() {
                        _this5.$modal.hide('dialog');
                        _this5.mySubmit(event, {
                            success: function(response) {
                                _this5.$modal.hide(modal);
                            }
                        }, false);
                    }
                }]
            });
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
        redirect(url) {
            window.location.replace(url);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        setFormTarifSaison(url) {
            let loading = null;
            var _this5 = this;
            $('#create-tarif').each(function() {
                loading = $(this).InputLoadRequest();
            })
            axios.get(url).then(function(response) {
                const data = {};
                _this5.state_tranche_saison.map(function(val, index) {
                    for (var k in response.data.tarif) {
                        if (val.id == response.data.tarif[k].tranche_saison.id) {
                            data[`marge_${index}`] = response.data.tarif[k].marge;
                            data[`prix_achat_${index}`] = response.data.tarif[k].prix_achat;
                            data[`prix_vente_${index}`] = response.data.tarif[k].prix_vente;
                        }
                    }
                });
                $('#create-tarif').each(function() {
                    Myform(this).setForm(data);
                })
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.response.datamessage ? error.response.response.datamessage : 'An error has occured.' });
            }).finally(() => {
                if (loading) loading.remove();
            });
        },
        autocompleteSaison() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {
                    _this5.setFormTarifSaison(`${_this5.urlbase}/admin/tarif-tranche-saison-locations/${_this5.vehicule.id}/${item.id}/show`);
                },
                fnBtnNew: function() {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'location-vehicule',
                        href: `${_this5.urlbase}/admin/location-vehicule-saisons`,
                        name: _this5.$dictionnaire.saison,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'childre',
                        range: '2',
                        _$: $
                    });
                },
                dataRequest: { model_saison: 'location_voiture' },
                detailInfo: ['titre','debut_format','fin_format'],
                formateDetailInfo: null,
                frame: this,
            }
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'tranchesaison',
        'saison',
        'vehicule'
    ]
});