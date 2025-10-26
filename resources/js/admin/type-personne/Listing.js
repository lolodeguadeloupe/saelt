import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('type-personne-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditPersonne: '',
            myEvent: {},
            data_request_customer: {}
        }
    },
    methods: {
        editPersonne(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditPersonne = response.data.typePersonne.resource_url;
                _this5.$modal.show('edit_personne');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editPersonne': function () {
                        var _data = response.data.typePersonne
                        $('#edit-personne').each(function () {
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
        createPersonne(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createPersonne': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_personne');
        },
        storePersonne(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        autocompleteType() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'hebergement-excursion-transfert-location-billeterie',
                        href: `${_this5.urlbase}/admin/type-personnes`,
                        name: _this5.$dictionnaire.type_personne,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'other',
                        range: '2',
                        _$: $
                    });
                },
                detailInfo: ['type', 'age'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});