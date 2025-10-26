import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('ville-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditVille: '',
            myEvent: {},
        }
    },
    methods: {
        editVille(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditVille = response.data.ville.resource_url;
                _this5.$modal.show('edit_ville');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editVille': function() {
                        var _data = response.data.ville
                        $('#edit-ville').each(function() {
                            Myform(this).setForm({..._data, pays_name: _data.pays.nom });
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createVille(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.$modal.show('create_ville');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeVille(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                    _this5.logo = [];
                }
            }, false, {});
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        autocompletePays() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function(event, options) {
                    _this5.$modal.show('create_pays');
                    _this5.eventFormSubmit = {
                        ..._this5.eventFormSubmit,
                        create_pays: options
                    }
                },
                detailInfo: [],
                formateDetailInfo: null,
                frame: this,
            }
        },
        storePays(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide('create_pays');
                }
            }, false, {}, false);
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
    ]
});