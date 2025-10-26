import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('compagnie-liaison-excursion-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            myEvent: {},
            compagnies: [],
        }
    },
    methods: {
        createCompagnieExcursion(event, url) {
            var _this5 = this;
            this.compagnies = [];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.compagnies = response.data.compagnieTransport;
                var isCompagnie = {};
                for (var index in response.data.excursion.compagnie) {
                    isCompagnie['compagnie_' + response.data.excursion.compagnie[index].id] = '1';
                }
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createCompagnie': function() {
                        $('#create-compagnie').each(function() {
                            Myform(this).setForm({
                                ...isCompagnie,
                                lieu_depart_id: response.data.excursion.lieu_depart_id,
                                lieu_depart: response.data.excursion.depart.name,
                                lieu_arrive_id: response.data.excursion.lieu_arrive_id,
                                lieu_arrive: response.data.excursion.arrive.name,
                            })
                        })
                    }
                }
                _this5.$modal.show('create_compagnie');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        storeCompagnieExcursion(event, modal) {
            var _this5 = this;
            var idCompagnie = [];
            $('#create-compagnie').each(function() {
                const data = Myform(this).serialized();
                for (var xx in data) {
                    const arr_xx = String(xx).split('_');
                    if (arr_xx[0] == 'compagnie' && data[xx] == '1')
                        idCompagnie.push(arr_xx[1]);
                }
            });

            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, { compagnie_id: idCompagnie });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        autocompletePort() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function(event) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'excursion',
                        href: `${_this5.urlbase}/admin/service-ports`,
                        name: _this5.$dictionnaire.compagnie,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'other',
                        range: '3',
                        _$: $
                    });
                },
                detailInfo: ['name', 'code_service', 'adresse', 'ville.name', 'ville.pays.nom'],
                formateDetailInfo: null,
                frame: this,
            }
        },
    },
    props: [
        'url',
        'action',
        'excursion',
        'urlbase', 'urlasset',
    ]
});