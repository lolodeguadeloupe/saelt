import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('base-type-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditBaseType: '',
            myEvent: {}
        }
    },
    methods: { 
        editBaseType(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditBaseType = response.data.baseType.resource_url; 
                _this5.$modal.show('edit_base_type');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editBaseType': function () {
                        var _data = response.data.baseType
                        $('#edit-base-type').each(function () {
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
        createBaseType(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent, 'createBaseType': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_base_type');
        },
        storeBaseType(event, modal) {
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