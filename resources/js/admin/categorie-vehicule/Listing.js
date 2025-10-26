import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('categorie-vehicule-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: { description: '',famille_vehicule_description:'' },
            actionEditCategorieVehicule: '',
            myEvent: {}
        }
    },
    methods: {
        editCategorieVehicule(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditCategorieVehicule = response.data.categorieVehicule.resource_url;
                _this5.form.description = response.data.categorieVehicule.description;
                _this5.$modal.show('edit_categorie_vehicule');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editCategorieVehicule': function () {
                        var _data = response.data.categorieVehicule
                        $('#edit-categorie-vehicule').each(function () {
                            Myform(this).setForm({..._data,famille_vehicule_titre:_data.famille.titre})
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createCategorieVehicule(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.form = { ..._this5.form, description: "" }
            _this5.myEvent = {
                ..._this5.myEvent, 'createCategorieVehicule': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_categorie_vehicule');
        },
        storeCategorieVehicule(event, modal) {
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
                description: (_this5.form && _this5.form.famille_vehicule_description) ?? '',
            },false);
        },
        autocomplete() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                    ['#create-categorie-vehicule', '#edit-categorie-vehicule'].map(function (id) {
                        $(id).each(function(){
                            Myform(this).setForm({ famille_vehicule_id: item.id, famille_vehicule_titre: item.titre }).removeErreur();
                        })
                    })
                },
                fnBtnNew: function () {
                    _this5.form = { ..._this5.form, famille_vehicule_description: "" }
                    _this5.myEvent = {
                        ..._this5.myEvent, 'createFamilleVehicule': function () {
                            
                        }
                    }
                    _this5.$modal.show('create_famille_vehicule');
                },
                detailInfo: [],
                formateDetailInfo: null,
                frame: this,
            }
        }
    }, props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});
