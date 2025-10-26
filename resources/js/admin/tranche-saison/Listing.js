import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('tranche-saison-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionFormUrlTranche: '',
            myEvent: {},
            actionForm: false, //[ajouter-form, affiche btn and edit ],
            containerFormEdit: [],
            data_request_customer: {
                location: this.location.id
            }
        }
    },
    methods: {
        editTranche(event, url, id, actionForm = false) {
            var _this5 = this,
                container = $('<div/>').attr({
                    style: 'position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white',
                });
            _this5.removeFormAction();
            _this5.actionForm = actionForm;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionFormUrlTranche = _this5.urlbase + '/admin/location-vehicule-tranche-saisons/' + response.data.trancheSaison.id;
                ['id', 'titre', 'nombre_min', 'nombre_max'].map((el, index) => {
                    const readonly = el == 'id' ? { readonly: 'readonly' } : {};
                    _this5.containerFormEdit[index] = container.clone(true);
                    $(`#liste-${el}-${id}`).each(function() {
                        var _this_el = this;
                        $('<input/>').attr({
                            type: 'text',
                            class: 'form-control',
                            required: 'required',
                            name: el,
                            value: response.data.trancheSaison[el],
                            ...readonly,
                        }).appendTo(
                            $('<div/>').attr({
                                class: 'col-12'
                            }).appendTo(
                                $('<div/>').attr({
                                    class: 'form-group row align-items-center',
                                    style: 'margin:auto;margin-left: 0;width: 100%;'
                                }).appendTo(
                                    _this5.containerFormEdit[index].appendTo($(_this_el))
                                )
                            )
                        );
                    })
                });
                $(`#liste-modif-${id}`).each(function() {
                    const id = _this5.containerFormEdit.length;
                    _this5.containerFormEdit[id] = container.clone(true);
                    var _this_el = this,
                        btn_save = $('<button/>').attr({
                            type: 'submit',
                            class: 'btn btn-primary',
                            style: 'display: flex;align-items: center;margin:auto;margin-right:12px;',
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
        createTranche() {
            this.removeFormAction();
            this.actionForm = true;
            this.actionFormUrlTranche = this.action;
        },
        storeTranche(event, actionForm = [false, true]) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.actionForm = false;
                    _this5.removeFormAction();
                }
            }, false);
        },
        deleteTranche(event, url) {
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
        }
    },
    props: [
        'url',
        'action',
        'location',
        'urlbase', 'urlasset'
    ]
});