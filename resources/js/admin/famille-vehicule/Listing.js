import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';


Vue.component('famille-vehicule-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: { description: '' },
            actionEditFamilleVehicule: '',
            myEvent: {}
        }
    },
    methods: {
        editFamilleVehicule(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditFamilleVehicule = response.data.familleVehicule.resource_url;
                _this5.form.description = response.data.familleVehicule.description;
                _this5.$modal.show('edit_famille_vehicule');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editFamilleVehicule': function () {
                        var _data = response.data.familleVehicule
                        $('#edit-famille-vehicule').each(function () {
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
        createFamilleVehicule(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.form = { ..._this5.form, description: "" }
            _this5.myEvent = {
                ..._this5.myEvent, 'createFamilleVehicule': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_famille_vehicule');
        },
        storeFamilleVehicule(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false, {
                description: (_this5.form && _this5.form.description) ?? '',
            });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        }
    }, props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});