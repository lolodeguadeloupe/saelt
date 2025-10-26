import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';


Vue.component('itineraire-excursion-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: { description: '' },
            actionEditItineraire: '',
            myEvent: {},
            image: [],
        }
    },
    methods: {
        editItineraire(event, url) {
            var _this5 = this;
            _this5.image = [];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditItineraire = response.data.itineraireExcursion.resource_url;
                _this5.form = {
                    ..._this5.form,
                    description: response.data.itineraireExcursion.description ? response.data.itineraireExcursion.description : '',
                }
                _this5.image = response.data.itineraireExcursion.image ? [response.data.itineraireExcursion.image] : [];
                _this5.$modal.show('edit_itineraire');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editItineraire': function() {
                        var _data = response.data.itineraireExcursion
                        $('#edit-itineraire').each(function() {
                            Myform(this).setForm({..._data })
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createItineraire(event, url) {
            var _this5 = this;
            _this5.image = [];
            _this5.form = {
                ..._this5.form,
                description: ''
            }
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'createItineraire': function() {
                        $('#create-itineraire').each(function() {
                            Myform(this).setForm({ rang: response.data.rang })
                        })
                    }
                }
                _this5.$modal.show('create_itineraire');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeItineraire(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {
                description: _this5.form.description
            });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        uploadImage(event, drop = false) {
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
                            _this5.image = [data.target.result];
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
        removeImage(index) {
            this.image = [];
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
    ]
});