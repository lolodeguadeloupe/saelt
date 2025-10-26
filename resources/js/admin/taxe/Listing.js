import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('taxe-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditTaxe: '',
            myEvent: {},
            taxe_prix: true,
            TVA: 'autres',
            EDIT_TVA: ''
        }
    },
    methods: {
        changeTva(TVA) {
            switch (TVA) {
                case 'tva_transfert':
                    $('#tva_transfert').each(function () {
                        $(this).prop('checked', true);
                    })
                    break;

                case 'tva_excursion':
                    $('#tva_excursion').each(function () {
                        $(this).prop('checked', true);
                    })
                    break;
                case 'tva_hebergement_pack':
                    $('#tva_hebergement_pack').each(function () {
                        $(this).prop('checked', true);
                    })
                    break;
                case 'tva_location':
                    $('#tva_location').each(function () {
                        $(this).prop('checked', true);
                    })
                    break;
                case 'tva_billetterie':
                    $('#tva_billetterie').each(function () {
                        $(this).prop('checked', true);
                    })
                    break;
                case 'autres':
                    $('#autres').each(function () {
                        $(this).prop('checked', true); 
                    })
                    break;
            }
            this.TVA = TVA;
        },
        editTaxe(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.taxe_prix = true;
            axios.get(url).then(function (response) {
                _this5.actionEditTaxe = response.data.taxe.resource_url;
                _this5.taxe_prix = response.data.taxe.taxe_appliquer == '1' ? true : false;
                _this5.$modal.show('edit_taxe');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTaxe': function () {
                        var _data = response.data.taxe;
                        _this5.EDIT_TVA = _data.titre;
                        _this5.changeTva(_data.sigle);
                        $('#edit-taxe').each(function () {
                            Myform(this).setForm(_data)
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createTaxe(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.taxe_prix = true;
            _this5.EDIT_TVA = '';
            _this5.myEvent = {
                ..._this5.myEvent,
                'createTaxe': function () {
                    _this5.changeTva('autres');
                    loading.remove()
                }
            }
            _this5.$modal.show('create_taxe');
        },
        storeTaxe(event, modal) {
            var _this5 = this;
            $('#create-taxe').each(function () {
                Myform(this).removeErreur();
            });
            $('#edit-taxe').each(function () {
                Myform(this).removeErreur();
            });
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        checkTaxeAppliquer(event) {
            var _this5 = this;
            if (event.target.checked) this.taxe_prix = event.target.value == '0' ? false : true;
            $('input[name="valeur_devises"]').each(function () {
                $(this).val('0');
            });
            $('input[name="valeur_pourcent"]').each(function () {
                $(this).val('0');
            })
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});