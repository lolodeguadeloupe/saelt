import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('pay-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditPays: '',
            myEvent: {},
        }
    },
    methods: {
        editPays(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditPays = response.data.pays.resource_url;
                _this5.$modal.show('edit_pays');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editPays': function() {
                        var _data = response.data.pays
                        $('#edit-pays').each(function() {
                            Myform(this).setForm({..._data });
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createPays(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.$modal.show('create_pays');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storePays(event, modal) {
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