import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('type-hebergement-listing', {
    mixins: [AppListing, AppForm], 
    data: function () {
        return {
            form: {},
            actionEditType: '',
            myEvent: {}
        }
    },
    methods: { 
        editType(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditType = response.data.typeHebergement.resource_url; 
                _this5.$modal.show('edit_type');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editType': function () {
                        var _data = response.data.typeHebergement
                        $('#edit-type').each(function () {
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
        createType(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent, 'createType': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_type');
        },
        storeType(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false);
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