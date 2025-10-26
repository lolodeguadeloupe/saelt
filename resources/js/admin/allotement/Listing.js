import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
import lang from '../app-components/lang';
var dict = lang('fr');

Vue.component('allotement-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditAllotement: '',
            compagnies: [],
            myEvent: {},
            logo: [],
        }
    },
    methods: {
        editAllotement(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditAllotement = response.data.allotement.resource_url;
                _this5.compagnies = response.data.compagnie;
                _this5.$modal.show('edit_allotement');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editAllotement': function() {
                        var _data = response.data.allotement,
                            _this55 = _this5;
                        $('#edit-allotement').each(function() {
                            Myform(this).setForm({..._data, lieu_depart: _data.depart.name, lieu_arrive: _data.arrive.name });
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createAllotement(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.compagnies = response.data.compagnie;
                _this5.$modal.show('create_allotement');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createAllotement': function() {
                        var _data = {};
                        $('#create-allotement').each(function() {
                            Myform(this).setForm(_data)
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        createCompagnie(event, url) {
            var _this5 = this;
            _this5.logo = [];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createCompagnie': function() {

                    }
                }
                _this5.$modal.show('create_compagnie');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });

        },
        storeAllotement(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        storeCompagnie(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.compagnies.push(response.data.compagnieTransport);
                    _this5.$modal.hide('create_compagnie');
                }
            }, false);
        },
        uploadLogo(event, drop = false) {
            var _this5 = this,
                progress_bar = $("<div/>").css({
                    'background-color': 'green',
                    'width': '0%',
                    'height': '100%',
                    'position': 'absolute',
                    'z-index': '12',
                    'top': '0',
                    'left': '0'
                });

            const files = drop ? event.dataTransfer.files : event.target.files;
            for (const file of files) {
                if (file && file.type && ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'].includes(String(file.type))) {
                    if (file.size && file.size > 1024 * 1024 * 1024 * 4) {
                        _this5.$notify({ type: 'error', title: 'Error!', text: `${_this5.$dictionnaire.file_error}` });
                    } else {
                        var reader = new FileReader();
                        reader.onload = (data) => {
                            _this5.logo = [data.target.result];
                            progress_bar.remove();
                        }
                        reader.onprogress = (_event) => {
                            $($(event.target).is('figure') ? $(event.target) : $(event.target).parents('figure')).each(function() {
                                $(this).find('.my-_btn-add').each(function() {
                                    $(this).append(progress_bar);
                                    if (_event.loaded && _event.total) {
                                        const percent = (_event.loaded / _event.total) * 100;
                                        progress_bar.css({ width: `${percent}%` });
                                    }
                                })
                            })
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    _this5.$notify({ type: 'error', title: 'Error!', text: `${_this5.$dictionnaire.file_size}` });
                }
            }
        },
        removeLogo(index) {
            this.logo = [];
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        autocompleteVille() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function(event, options) {
                    _this5.$modal.show('create_ville');
                    _this5.eventFormSubmit = {
                        ..._this5.eventFormSubmit,
                        create_ville: options
                    }
                },
                detailInfo: [],
                formateDetailInfo: null,
                frame: this,
            }
        },
        storeVille(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide('create_ville');
                }
            }, false, {}, false);
        },
        autocompletePays() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function(event, options) {
                    _this5.$modal.show('create_pays');
                    _this5.eventFormSubmit = {
                        ..._this5.eventFormSubmit,
                        create_pays: options
                    }
                },
                detailInfo: [],
                formateDetailInfo: null,
                frame: this,
            }
        },
        storePays(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide('create_pays');
                }
            }, false, {}, false);
        },
        autocompleteAeroport() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function(event) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'hebergement',
                        href: `${_this5.urlbase}/admin/service-aeroports`,
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
        'urlbase', 'urlasset',
        'urlcompagnie'
    ]
});