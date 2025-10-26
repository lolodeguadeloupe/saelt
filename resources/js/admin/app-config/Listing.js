import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('app-config-listing', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {},
            actionEditApp: '',
            myEvent: {},
            logo: [],
            item_url: '',
            isEdit: false
        }
    },
    mounted() {
        /** */
        var _this5 = this;
        $('.opacity-load-0').each(function() {
            $(this).removeClass('opacity-load-0');
            $('.create-page-load').each(function() {
                $(this).remove();
                $('body').each(function() {
                    $(this).css({ overflow: 'auto' })
                })
            })
        });
        /* manager liens */
        $('body').each(function() {
                $(this).click(function(event) {
                    var _body = this;
                    var el = null;
                    $(event.originalEvent.target).each(function() {
                        $(this).parents('li.manager-liens').each(function() {
                            $(this).find('a.nav-link-manager-liens').each(function() {
                                el = this;
                                event.preventDefault();
                            });
                        });
                    })
                    if (el && $(el).is('a.lien_parent')) {
                        _this5.$managerliens({
                            is_parent: true,
                            parent_name: typeof $(el).attr('data-parent') != "undefined" ? $(el).attr('data-parent') : '',
                            href: $(el).attr('href'),
                            name: $(el).find('.nav-link-titre').html(),
                            body: _body,
                            _this: _this5,
                            axios: axios,
                            liens: 'parent',
                            _$: $
                        });
                    } else if (el && $(el).is('a.lien_child')) {
                        _this5.$managerliens({
                            is_parent: false,
                            parent_name: typeof $(el).attr('data-parent') != "undefined" ? $(el).attr('data-parent') : '',
                            href: $(el).attr('href'),
                            name: $(el).find('.nav-link-titre').html(),
                            body: _body,
                            _this: _this5,
                            axios: axios,
                            liens: 'childre',
                            range: $(el).attr('data-range') != "undefined" ? $(el).attr('data-range') : '1',
                            _$: $
                        });
                    } else if (el && $(el).is('a.lien_complement')) {
                        _this5.$managerliens({
                            is_parent: false,
                            parent_name: typeof $(el).attr('data-parent') != "undefined" ? $(el).attr('data-parent') : '',
                            href: $(el).attr('href'),
                            name: $(el).find('.nav-link-titre').html(),
                            body: _body,
                            _this: _this5,
                            axios: axios,
                            liens: 'complement',
                            range: $(el).attr('data-range') != "undefined" ? $(el).attr('data-range') : '2',
                            _$: $
                        });
                    } else if ($(event.originalEvent.target).is('a') && typeof $(event.originalEvent.target).attr('href') != 'undefined' && $(event.originalEvent.target).attr('href') != '#') {
                        event.preventDefault();
                        _this5.$managerliens({
                            is_parent: typeof $(event.originalEvent.target).attr('data-is-parent') != 'undefined' ? $(event.originalEvent.target).attr('data-is-parent') : false,
                            parent_name: typeof $(event.originalEvent.target).attr('data-parent') != 'undefined' ? $(event.originalEvent.target).attr('data-parent') : '',
                            href: $(event.originalEvent.target).attr('href'),
                            name: $(event.originalEvent.target).text(),
                            body: _body,
                            _this: _this5,
                            axios: axios,
                            liens: 'other',
                            range: $(event.originalEvent.target).attr('data-range') != "undefined" ? $(event.originalEvent.target).attr('data-range') : '1',
                            _$: $
                        });
                    } else if ($(event.originalEvent.target).parent().is('a') && typeof $(event.originalEvent.target).parent().attr('href') != 'undefined' && $(event.originalEvent.target).parent().attr('href') != '#') {
                        event.preventDefault();
                        _this5.$managerliens({
                            is_parent: typeof $(event.originalEvent.target).parent().attr('data-is-parent') != 'undefined' ? $(event.originalEvent.target).parent().attr('data-is-parent') : false,
                            parent_name: typeof $(event.originalEvent.target).parent().attr('data-parent') != 'undefined' ? $(event.originalEvent.target).parent().attr('data-parent') : '',
                            href: $(event.originalEvent.target).parent().attr('href'),
                            name: $(event.originalEvent.target).parent().text(),
                            body: _body,
                            _this: _this5,
                            axios: axios,
                            liens: 'other',
                            range: $(event.originalEvent.target).parent().attr('data-range') != "undefined" ? $(event.originalEvent.target).parent().attr('data-range') : '1',
                            _$: $
                        });
                    }
                });
            })
            /* manager liens */
            /** */
        var data = this.data;
        this.item_url = data.resource_url;
        this.logo = data.logo ? [data.logo] : [];
        this.actionEditApp = data.resource_url;
        $('#edit-app').each(function() {
            if (data.ville != null) {
                data['ville_id'] = data.ville.id;
                data['ville_name'] = data.ville.name;
            }
            Myform(this).setForm(data);
        });
    },
    methods: {
        editApp(event, url, name) {
            var _this5 = this;
            const el = event.currentTarget;
            let loading = $(el).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditApp = response.data.appConfig.resource_url;
                var _data = response.data.appConfig
                if (name == 'ville_name') {
                    $('#edit-app').each(function() {
                        var _temp = {};
                        if (_data.ville != null) {
                            _temp['ville_id'] = _data.ville.id;
                            _temp['ville_name'] = _data.ville.name;
                        }
                        Myform(this).setForm({..._temp });
                    });
                    $('#ville-name-readonly').css({ display: 'none' });
                } else {
                    $('#edit-app').each(function() {
                        if (_data.ville != null) {
                            _data['ville_id'] = _data.ville.id;
                            _data['ville_name'] = _data.ville.name;
                        }
                        var _temp = {};
                        _temp[name] = _data[name];

                        Myform(this).setForm({..._temp });
                    });
                    $('#ville-name-readonly').css({ display: 'block' });
                }
                /* */

                /** */
                $(`[name="${name}"]`).each(function() {
                    $(this).prop('readonly', false);
                    $(this).focus();
                })
                $('.form-group .btn').each(function() {
                    $(this).css({ display: 'inline-block' });
                })
                $(el).each(function() {
                    $(this).css({ display: 'none' })
                })
                _this5.isEdit = true;
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createApp(event, url) {
            var _this5 = this;
            _this5.logo = [];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.$modal.show('create_app');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeApp(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.isEdit = false;
                    var _data = response.data.appConfig
                    this.logo = _data.logo ? [_data.logo] : [];
                    $('.form-group .btn').each(function() {
                        $(this).css({ display: 'inline-block' });
                    })
                    $('#edit-app').each(function() {
                        if (_data.ville != null) {
                            _data['ville_id'] = _data.ville.id;
                            _data['ville_name'] = _data.ville.name;
                        }
                        Myform(this).setForm({..._data });
                    });
                    $('#ville-name-readonly').css({ display: 'none' });
                }
            }, true, {}, false);
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
                            _this5.isEdit = true;
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
    ]
});