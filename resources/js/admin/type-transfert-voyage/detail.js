import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
import lang from '../app-components/lang';


Vue.component('detail-type-transfert-voyage-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: { description: '' },
            actionEditType: '',
            myEvent: {},
            data_detail: [this.detail],
            myEvent: {},
            pagination_: [true, false],
            url_resourse_prestataire: [],
            prestataireIsReadOnly: false,
            logo: [],
        }
    },
    methods: {
        editType(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.prestataireIsReadOnly = true;
            axios.get(url).then(function(response) {
                _this5.actionEditType = response.data.typeTransfertVoyage.resource_url;
                _this5.form.description = response.data.typeTransfertVoyage.description;
                _this5.logo = response.data.typeTransfertVoyage.prestataire.logo ? [response.data.typeTransfertVoyage.prestataire.logo] : [];
                _this5.$modal.show('edit_type');
                const data = {
                    ...response.data.typeTransfertVoyage,
                }
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editType': function() {
                        var _this55 = _this5;
                        $('#edit-type').each(function() {
                            Myform(this).setForm(data);
                        })
                        $('#edit-prestataire').each(function() {
                            Myform(this).setForm({
                                ...data.prestataire,
                                ville_name: data.prestataire.ville.name
                            });
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },

        storeType(event, modal) {
            var _this5 = this;
            var data = null;
            $('#edit-prestataire').each(function() {
                data = Myform(this).serialized();
            });
            if (!data) {
                return;
            }
            $('#edit-type').each(function() {
                data = Myform(this).serialized();
            });
            if (!data) {
                return;
            }
            var loading = $(event.target).InputLoadRequest();
            $('#edit-type').each(function() {
                var _el = this;
                _this5.postData(
                    $(_el).attr('action'), {
                        ...data
                    }, {
                        success: function(response) {
                            _this5.getDetail();
                            _this5.$modal.hide(modal);
                        },
                        errors: function(error) {
                            if (error.response && error.response.status && error.response.status === 422) {
                                var origin_errors = {...error.response.data.errors };
                                $('#edit-type').each(function() {
                                    Myform(this).erreur({ error: 422, data: origin_errors });
                                });
                            }
                        },
                        finally: function() {
                            loading.remove();
                        }
                    });
            });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        getDetail() {
            var loading = null;
            $('#parent-loader').each(function() {
                loading = $(this).InputLoadRequest();
            })
            var _this5 = this;
            axios.get(_this5.url).then(function(response) {
                _this5.data_detail = [response.data.data];
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) loading.remove();
            });
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
        nextPage(current) {
            this.pagination_ = current.map(is => !is);
        },
        autocompletePrestataire() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {
                    _this5.logo = item.logo ? [item.logo] : [];
                    const _item = {...item, ville_name: item.ville.name }
                    console.log($('#create-prestataire'))
                    $('#create-prestataire').each(function() {
                        console.log(this)
                        Myform(this).setForm(_item).removeErreur();
                    });
                    $('#edit-prestataire').each(function() {
                        Myform(this).setForm(_item).removeErreur();
                    });
                    $('#create-type').each(function() {
                        Myform(this).setForm({ prestataire_id: item.id }).removeErreur();
                    });
                    $('#edit-type').each(function() {
                        Myform(this).setForm({ prestataire_id: item.id }).removeErreur();
                    });
                },
                fnBtnNew: function(event, options) {
                    if (_this5.prestataireIsReadOnly) {
                        axios.get(`${_this5.urlbase}/admin/prestataires/create`).then(function(response) {
                            _this5.$modal.show('create_prestataire');
                            _this5.logo = [];
                            _this5.eventFormSubmit = {
                                ..._this5.eventFormSubmit,
                                create_prestataire: {
                                    ...options,
                                    fnSet: function(form, data) {
                                        $(form).each(function() {
                                            Myform(this).setForm({...data, ville_name: data.ville.name }).removeErreur();
                                            _this5.logo = data.logo ? [data.logo] : [];
                                        })
                                        $('#create-type').each(function() {
                                            Myform(this).setForm({ prestataire_id: data.id }).removeErreur();
                                        });
                                        $('#edit-type').each(function() {
                                            Myform(this).setForm({ prestataire_id: data.id }).removeErreur();
                                        });

                                    }
                                }
                            }
                        }, function(error) {
                            _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
                        }).finally(() => {
                            //
                        });
                    }
                },
                detailInfo: ['name', 'ville.name'],
                formateDetailInfo: null,
                frame: this,
            }
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
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'detail'
    ]
});