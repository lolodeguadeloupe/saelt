import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('mode-payement-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: {},
            actionEditModePayement: '',
            myEvent: {},
            icon: []
        }
    },
    methods: {
        editModePayement(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditModePayement = response.data.modePayement.resource_url;
                _this5.icon = response.data.modePayement.icon ? [`${response.data.modePayement.icon}`] : [];
                _this5.$modal.show('edit_mode_payement');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editModePayement': function() {
                        var _data = response.data.modePayement;
                        $('#edit-mode-payement').each(function() {
                            Myform(this).setForm({
                                ..._data,
                                key_test: _data.config.key_test,
                                key_prod: _data.config.key_prod,
                                base_url_test: _data.config.base_url_test,
                                base_url_prod: _data.config.base_url_prod,
                                mode: _data.config.mode,
                                api_version: _data.config.api_version,
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
        createModePayement(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.icon = [];
            axios.get(url).then(function(response) {
                _this5.$modal.show('create_mode_payement');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeModePayement(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        uploadIcon(event, drop = false) {
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
                            _this5.icon = [data.target.result];
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
        iconPaiement(event, liste = []) {
            for (var k in liste) {
                if (liste[k].titre == event.target.value) {
                    this.icon = [`${liste[k].icon}`];
                }
            };
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'paiementmode'
    ]
});