import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('marque-vehicule-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditMarque: '',
            myEvent: {},
        }
    },
    methods: {
        editMarque(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditMarque = response.data.marqueVehicule.resource_url;
                _this5.$modal.show('edit_marque');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editMarque': function () {
                        var _data = response.data.marqueVehicule
                        $('#edit-marque').each(function () {
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
        createMarque(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent, 'createMarque': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_marque');
        },
        storeMarque(event, modal) {
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
    }, props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});