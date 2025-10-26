import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('frais-dossier-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditFraisDossier: '',
            myEvent: {},
        }
    },
    methods: {
        editFraisDossier(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditFraisDossier = response.data.fraisDossier.resource_url;
                _this5.$modal.show('edit_frais');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editFraisDossier': function() {
                        var _data = response.data.fraisDossier;
                        $('#edit-frais').each(function() {
                            Myform(this).setForm({..._data, debut: _data.saison.debut, fin: _data.saison.fin });
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createFraisDossier(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.$modal.show('create_frais');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeFraisDossier(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
    ]
});