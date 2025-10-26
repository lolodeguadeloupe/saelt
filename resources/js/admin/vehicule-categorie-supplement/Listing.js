import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('vehicule-categorie-supplement-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionFormUrlSupplement: '',
            myEvent: {},
            actionForm: false, //[ajouter-form, affiche btn and edit ],
            containerFormEdit: [],
        }
    },
    methods: {
        editSupplement(event, url, id, actionForm = false) {
            var _this5 = this,
                container = $('<div/>').attr({
                    style: 'position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white',
                });
            _this5.removeFormAction();
            _this5.actionForm = actionForm;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                const data = {
                    ...response.data.vehiculeCategorieSupplement,
                    categorie_vehicule_titre: response.data.vehiculeCategorieSupplement.categorie.titre,
                    restriction_trajet_titre: response.data.vehiculeCategorieSupplement.trajet.titre
                }
                _this5.actionFormUrlSupplement = _this5.action + '/' + response.data.vehiculeCategorieSupplement.id;
                ['id', 'categorie_vehicule_titre', 'restriction_trajet_titre', 'tarif'].map((el, index) => {
                    const readonly = (el == 'id' || el == 'categorie_vehicule_titre' || el == 'restriction_trajet_titre') ? { readonly: 'readonly' } : {};
                    _this5.containerFormEdit[index] = container.clone(true);
                    $(`#liste-${el}-${id}`).each(function() {
                        var _this_el = this;
                        $('<input/>').attr({
                            type: 'text',
                            class: 'form-control',
                            required: 'required',
                            name: el,
                            value: data[el],
                            ...readonly,
                        }).appendTo(
                            $('<div/>').attr({
                                class: 'col-12'
                            }).appendTo(
                                $('<div/>').attr({
                                    class: el == 'id' ? 'form-group row align-items-center content-liste-id-' + id : 'form-group row align-items-center',
                                    style: 'margin:auto;'
                                }).appendTo(
                                    _this5.containerFormEdit[index].appendTo($(_this_el))
                                )
                            )
                        );
                    })
                });
                ['categorie_vehicule_id', 'restriction_trajet_id'].map((el, index) => {
                    $(`.content-liste-id-${id}`).each(function() {
                        var _this_el = this;
                        $('<input/>').attr({
                            type: 'text',
                            class: 'form-control',
                            required: 'required',
                            name: el,
                            value: data[el],
                            style: 'display:none;'
                        }).appendTo($(_this_el));
                    })
                });
                $(`#liste-modif-${id}`).each(function() {
                    const id = _this5.containerFormEdit.length;
                    _this5.containerFormEdit[id] = container.clone(true);
                    var _this_el = this,
                        btn_save = $('<button/>').attr({
                            type: 'submit',
                            class: 'btn btn-primary',
                            style: 'display: flex;align-items: center;margin:0 15px 0 auto;',
                        });
                    btn_save.appendTo(
                        _this5.containerFormEdit[id].appendTo($(_this_el))
                    );
                    btn_save.html(`${_this5.$dictionnaire.btn_save}`);
                })

            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        createSupplement() {
            this.removeFormAction();
            this.actionForm = true;
            this.actionFormUrlSupplement = this.action;
        },
        storeSupplement(event, actionForm = [false, true]) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.actionForm = false;
                    _this5.removeFormAction();
                }
            }, false);
        },
        deleteSupplement(event, url) {
            var _this5 = this;
            _this5.deleteItem(url, {
                finally: function() {}
            })
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        removeFormAction() {
            this.containerFormEdit.map(is => is.remove());
            this.containerFormEdit = [];
        },
        autocompleteTrajet() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function() {
                    _this5.$redirect(`${_this5.urlbase}/admin/restriction-trajet-vehicules`);
                },
                detailInfo: ['name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'categorie'
    ]
});