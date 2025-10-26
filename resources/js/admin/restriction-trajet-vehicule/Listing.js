import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('restriction-trajet-vehicule-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditTrajet: '',
            myEvent: {},
            categories: [],
            restrictionTrajetVehicule: [],
            categories_restrictionTrajetVehicule_edit: 0
        }
    },
    mounted() {
    },
    methods: {
        editTrajet(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTrajet = response.data.restrictionTrajetVehicule.resource_url;
                _this5.$modal.show('edit_trajet');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editTrajet': function () {
                        var _data = response.data.restrictionTrajetVehicule;
                        $('#edit-trajet').each(function () {
                            Myform(this).setForm({ ..._data, agence_location_arrive_titre: _data.point_arrive.name, agence_location_depart_titre: _data.point_depart.name })
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createTrajet(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent, 'createTrajet': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_trajet');
        },
        storeTrajet(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.checkTrajet(`${response.data.restrictionTrajetVehicule.resource_url}/edit`);
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        autocompleteAgenceLocation() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                },
                fnBtnNew: function () {
                    _this5.$redirect(`${_this5.urlbase}/admin/agence-locations`);
                },
                detailInfo: ['name', 'code_agence', 'ville.name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        checkTrajet(url) {
            var _this5 = this;
            //let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.categories_restrictionTrajetVehicule_edit = 0;
                _this5.categories = [...response.data.categories];
                _this5.restrictionTrajetVehicule = [response.data.restrictionTrajetVehicule];
                _this5.myEvent = {
                    ..._this5.myEvent, 'createSupplementTrajet': function () {
                        for (var x in _this5.categories) {
                            if (_this5.categories[x].tarif != null) {
                                var form_tarif = {};
                                form_tarif[`tarif_${x}`] = _this5.categories[x].tarif.tarif;
                                $(`#form_categorie_${_this5.categories[x].id}`).each(function () {
                                    Myform(this).setForm(form_tarif);
                                });
                            }
                        }
                    }
                }
                _this5.$modal.show('supplement_trajet');
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                //loading.remove();
            });
        },
        changeFormCategorieTraje(id, inc) {
            var _this5 = this;
            var temp_inc = _this5.categories_restrictionTrajetVehicule_edit;
            $(`#form_categorie_${id[temp_inc]}`).each(function () {
                const data = Myform(this).serialized();
                if (data) {
                    temp_inc = temp_inc + (inc);
                    temp_inc = temp_inc <= 0 ? 0 : (temp_inc >= id.length ? id.length - 1 : temp_inc);
                    $(`#categorie_${id.join(',#categorie_')}`).each(function () {
                        $(this).addClass('d-none');
                        $(this).removeClass('d-flex');
                    })
                    $(`#categorie_${id[temp_inc]}`).each(function () {
                        $(this).removeClass('d-none');
                        $(this).addClass('d-flex');
                    });
                    _this5.categories_restrictionTrajetVehicule_edit = temp_inc;
                }
            });
        },
        saveFormCategorieTrajet(event, id, url) {
            var _this5 = this;
            var all_data = {};
            $(`#form_categorie_${id.join(',#form_categorie_')}`).each(function () {
                const _temp = Myform(this).serialized();
                if (_temp) {
                    all_data = { ...all_data, ..._temp };
                } else {
                    all_data = null;
                }
            });
            if (all_data) {
                let loading = $(event.target).InputLoadRequest();
                axios.post(url, all_data).then(function (response) {
                    _this5.$modal.hide('supplement_trajet');
                }, function (error) {
                    _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

                }).finally(() => {
                    loading.remove();
                });
            }
        }
    }, props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});