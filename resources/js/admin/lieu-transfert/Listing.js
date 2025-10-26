import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('lieu-transfert-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditLieu: '',
            myEvent: {},

        }
    },
    methods: {
        editLieu(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditLieu = response.data.lieuTransfert.resource_url;
                _this5.$modal.show('edit_lieu');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editLieu': function () {
                        var _data = response.data.lieuTransfert;
                        $('#edit-lieu').each(function () {
                            Myform(this).setForm({ ..._data, ville_name: _data.ville ? _data.ville.name : '' })
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createLieu(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createLieu': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_lieu');
        },
        storeLieu(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },

        autocompleteVille() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
                    _this5.$modal.show('create_ville');
                    _this5.eventFormSubmit = {
                        ..._this5.eventFormSubmit,
                        create_ville: options
                    }
                },
                detailInfo: ['name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        storeVille(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.$modal.hide('create_ville');
                }
            }, false, {}, false);
        },
        autocompletePays() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
                    _this5.$modal.show('create_pays');
                    _this5.eventFormSubmit = {
                        ..._this5.eventFormSubmit,
                        create_pays: options
                    }
                },
                detailInfo: ['name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        storePays(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
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