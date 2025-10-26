import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
import lang from '../app-components/lang';
var dict = lang('fr');

Vue.component('hebergement-marque-blanche-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditHebBlanche: '',
            types: [],
            myEvent: {},
            imageUploads: [],
            imageServeur: [],
        }
    },
    methods: {
        editHebBlanche(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.imageUploads = [];
            _this5.imageServeur = [];
            axios.get(url).then(function(response) {
                _this5.actionEditHebBlanche = response.data.hebergementMarqueBlanche.resource_url;
                _this5.types = response.data.type_hebergements
                _this5.$modal.show('edit_hebergement_blanche');
                _this5.imageServeur = response.data.hebergementMarqueBlanche.image ? [...response.data.hebergementMarqueBlanche.image].map(function(image) { return {...image, name: `${image.name}` } }) : [];
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editHebBlanche': function() {
                        var _data = response.data.hebergementMarqueBlanche
                        $('#edit-hebergement-blanche').each(function() {
                            Myform(this).setForm(_data);
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createHebBlanche(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.imageUploads = [];
            _this5.imageServeur = [];
            axios.get(url).then(function(response) {
                _this5.types = response.data.type_hebergements;
                _this5.$modal.show('create_hebergement_blanche');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeHebBlanche(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, { image: _this5.imageUploads });
        },
        createTypeHeb(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.$modal.show('create_type_hebergement');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeTypeHeb(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.types = response.data.type_hebergements;
                    _this5.$modal.hide('create_type_hebergement');
                }
            }, false);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        imageUpload(event, drop = false) {
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
                            _this5.imageUploads.push(data.target.result);
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
        removeUploadImage(index) {
            this.imageUploads = this.imageUploads.filter(function(val, i) {
                if (index != i) return val;
            })
        },
        deleteImageServeur(event, url, index) {
            var _this7 = this;
            this.$modal.show('dialog', {
                title: `${_this7.$dictionnaire.warning}!`,
                text: _this7.$dictionnaire.delete_item_confirm,
                buttons: [{ title: _this7.$dictionnaire.confirm_no_cancel }, {
                    title: `<span class="btn-dialog btn-danger">${_this7.$dictionnaire.confirm_yes_delete}.<span>`,
                    handler: function handler() {
                        _this7.$modal.hide('dialog');
                        let loading = $(event.target).InputLoadRequest();
                        axios.post(`${url}/delete`).then(function(response) {

                            _this7.imageServeur = _this7.imageServeur.filter(function(val, i) {
                                if (index != i) return val;
                            })

                            _this7.loadData();
                            _this7.$notify({ type: 'success', title: `${_this7.$dictionnaire.success}!`, text: response.data.message ? response.data.message : `${_this7.$dictionnaire.item_successful_delete}.` });
                        }, function(error) {
                            _this7.$notify({ type: 'error', title: `${_this7.$dictionnaire.error}!`, text: error.response.data.message ? error.response.data.message : `${_this7.$dictionnaire.error_occured}.` });
                        }).finally(function() {
                            loading.remove();
                        });
                    }
                }]
            });
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'urltypeheb'
    ]
});