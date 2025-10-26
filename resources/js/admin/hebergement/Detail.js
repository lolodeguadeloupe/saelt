import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
const formatDateString = "YYYY-MM-DD";


Vue.component('detail-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: { taxes: [] },
            actionEditHeb: '',
            actionEditPrestataire: '',
            types: [],
            myEvent: {},
            data_detail: [this.detail],
            pagination_: [true, false],
            url_resourse_prestataire: [],
            imageUploads: [],
            imageServeur: [],
            prestataireIsReadOnly: false,
            calendarServeur: [],
            calendarLocal: [],
            modelCalendar: [],
            style_color_calendar: '#aaaaaa',
            calendar_btn_action: [false, true],
            dataCalendarModifier: [],
            //for detail
            globalCalendarDates: this.datacalendar ? this.datacalendar : [],
            taxes: [],
            taxe_prix: true,
            logo: [],
            fond_image: [],
        }
    },
    computed: {
        attributes() {
            return [...this.calendarServeur, ...this.calendarLocal, ...this.modelCalendar].map(model => model.attrs);
        },
        modelcalendardates() {
            return JSON.stringify(this.modelCalendar.map(data => {
                return moment(data.attrs.dates).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('YYYY-MM-DD');
            }));
        },
        calendaralldates() {
            var _this5 = this;
            return this.globalCalendarDates.map(calendar => {
                var attrs = {};
                const _date_serveur = _this5.$parseDate(calendar.date);
                switch (calendar['ui_event']) {
                    case 'bar':
                        attrs = {
                            bar: {
                                style: {
                                    backgroundColor: calendar.color,
                                    class: Date.now() > _date_serveur ? 'opacity-75' : '',
                                }
                            },
                        }
                        break;

                    case 'dot':
                        attrs = {
                            dot: {
                                style: {
                                    backgroundColor: calendar.color,
                                    class: Date.now() > _date_serveur ? 'opacity-75' : '',
                                },
                            },
                        }
                        break;

                    case 'highlight':
                        attrs = {
                            highlight: {
                                style: {
                                    backgroundColor: calendar.color,
                                    class: Date.now() > _date_serveur ? 'opacity-75' : '',
                                },
                                fillMode: 'light',
                            },
                        }
                        break;
                }
                return {
                    ...attrs,
                    popover: {
                        label: `${calendar.description} ${calendar.time_start} - ${calendar.time_end}`,
                        hideIndicator: true,
                    },
                    dates: _date_serveur,
                }
            });
        }

    },
    methods: {
        editHeb(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.imageUploads = [];
            _this5.imageServeur = [];
            _this5.calendarLocal = []; //init calendar local
            _this5.taxes = [];
            axios.get(url).then(function(response) {
                _this5.actionEditHeb = response.data.hebergement.resource_url;
                _this5.actionCalendar = response.data.hebergement.resource_url + '/calendar';
                _this5.types = response.data.type_hebergements;
                _this5.taxes = response.data.taxe;
                _this5.fond_image = response.data.hebergement.fond_image ? [response.data.hebergement.fond_image] : [];
                _this5.imageServeur = response.data.hebergement.image ? [...response.data.hebergement.image].map(function(image) { return {...image, name: `${image.name}` } }) : [];
                _this5.form.taxes = response.data.taxe.filter(val => response.data.hebergement.taxe.map(_val => _val.id).includes(val.id));
                _this5.$modal.show('edit_hebergement');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editHeb': function() {
                        var _data = response.data.hebergement,
                            _this55 = _this5;
                        $('#edit-hebergement').each(function() {
                            Myform(this).setForm({
                                ..._data,
                                ville_name: _data.ville.name,
                                ile_name: _data.ile.name
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
        editPrestataire(event, url) {
            var _this5 = this;
            _this5.prestataireIsReadOnly = true;
            let loading = $(event.target).InputLoadRequest();
            _this5.logo = [];
            axios.get(url).then(function(response) {
                _this5.actionEditPrestataire = response.data.prestataire.resource_url;
                _this5.logo = response.data.prestataire.logo ? [response.data.prestataire.logo] : [];
                _this5.$modal.show('edit_prestataire');
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editPrestataire': function() {
                        var _data = response.data.prestataire,
                            _this55 = _this5;
                        $('#edit-prestataire').each(function() {
                            Myform(this).setForm({..._data, ville_name: _data.ville.name });
                        })
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
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
        storeHeb(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide(modal);
                    _this5.types = response.data.type_hebergements;
                    _this5.data_detail = [{..._this5.data_detail[0], ...response.data.hebergement, image: (response.data.hebergement.image ? response.data.hebergement.image : []) }];
                    _this5.calendarLocal = [];
                    _this5.modelCalendar = [];
                    _this5.calendarServeur = response.data.calendar;
                    _this5.globalCalendarDates = response.data.calendar;
                }
            }, false, {
                image: _this5.imageUploads,
                calendar: _this5.calendarLocal,
                taxes: [...(_this5.form.taxes ? _this5.form.taxes : [])].map(val => `${val.id}`),
            }, false);
        },
        updatePrestataire(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide(modal);
                    _this5.data_detail = [{..._this5.data_detail[0], prestataire: {...response.data.prestataire } }];
                }
            }, false, {}, false);
        },
        storePrestataire(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        storeTypeHeb(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.types = response.data.type_hebergements;
                    _this5.$promise(function() {
                        $('#edit-hebergement').each(function() {
                            Myform(this).setForm({ type_hebergement_id: response.data.type_hebergement.id })
                        })
                    })
                    _this5.$modal.hide('create_type_hebergement');
                }
            }, false, {}, false);
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
        autocompleteIle() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {},
                fnBtnNew: function(event, options) {
                    _this5.$modal.show('create_ile');
                    _this5.eventFormSubmit = {
                        ..._this5.eventFormSubmit,
                        create_ile: options
                    }
                },
                detailInfo: [],
                formateDetailInfo: null,
                frame: this,
            }
        },
        storeIle(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide('create_ile');
                }
            }, false, {}, false);
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
        },
        nextPage(current) {
            this.pagination_ = current.map(is => !is);
        },
        autocomplete() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {
                    _this5.actionEditPrestataire = `${_this5.data_detail[0].resource_url}/prestataire/${item.id}`;
                    _this5.logo = item.logo ? [item.logo] : [];
                    $('#create-prestataire').each(function() {
                        Myform(this).setForm({...item, ville_name: item.ville.name }).removeErreur();
                    });
                    $('#edit-prestataire').each(function() {
                        Myform(this).setForm({...item, ville_name: item.ville.name }).removeErreur();
                    });
                    $('#create-hebergement').each(function() {
                        Myform(this).setForm({ prestataire_id: item.id }).removeErreur();
                    });
                    $('#edit-hebergement').each(function() {
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
                                        $('#create-hebergement').each(function() {
                                            Myform(this).setForm({ prestataire_id: data.id }).removeErreur();
                                        });
                                        $('#edit-hebergement').each(function() {
                                            Myform(this).setForm({ prestataire_id: data.id }).removeErreur();
                                        });
                                        _this5.actionEditPrestataire = `${_this5.data_detail[0].resource_url}/prestataire/${data.id}`;
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
                detailInfo: ['name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        calendar(event) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.calendarServeur = [];
            _this5.modelCalendar = [];
            _this5.calendar_btn_action = [false, true];
            axios.post(_this5.actionCalendar).then(function(response) {
                    _this5.$modal.show('calendar');
                    _this5.calendarServeur = response.data.calendar.map(calendar => {

                        var attrs = {};
                        const _date_serveur = _this5.$parseDate(calendar.date);
                        switch (calendar['ui_event']) {
                            case 'bar':
                                attrs = {
                                    bar: {
                                        style: {
                                            backgroundColor: calendar.color,
                                            class: Date.now() > _date_serveur ? 'opacity-75' : '',
                                        }
                                    },
                                }
                                break;

                            case 'dot':
                                attrs = {
                                    dot: {
                                        style: {
                                            backgroundColor: calendar.color,
                                            class: Date.now() > _date_serveur ? 'opacity-75' : '',
                                        },
                                    },
                                }
                                break;

                            case 'highlight':
                                attrs = {
                                    highlight: {
                                        style: {
                                            backgroundColor: calendar.color,
                                            class: Date.now() > _date_serveur ? 'opacity-75' : '',
                                        },
                                        fillMode: 'light',
                                    },
                                }
                                break;
                        }
                        return {
                            attrs: {
                                ...attrs,
                                popover: {
                                    label: `${calendar.description} ${calendar.time_start} - ${calendar.time_end}`,
                                    hideIndicator: true,
                                },
                                dates: _date_serveur,
                            },
                            ...calendar
                        }
                    });
                },
                function(error) {
                    _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

                }).finally(() => {
                loading.remove();
            });

        },
        onDayClick(day) {
            var _this5 = this;
            if (moment().valueOf() > moment(day.date).valueOf()) return;
            if (this.calendar_btn_action[1]) {
                const idx = this.modelCalendar.findIndex(d => d.id === day.id);
                if (idx >= 0) {
                    this.modelCalendar.splice(idx, 1);
                } else {
                    this.modelCalendar.push({
                        id: day.id,
                        attrs: {
                            highlight: {
                                color: "#4c51bf",
                                fillMode: 'outline',
                            },
                            popover: {
                                label: this.$dictionnaire.new_event_calendar,
                                hideIndicator: true,
                            },
                            dates: day.date,
                        }
                    });
                }
            } else if (this.calendar_btn_action[0]) {
                const isServeur = this.calendarServeur.filter(d => {
                    return moment.duration(moment(_this5.$parseDate(d.date)).diff(moment(day.date))).asDays() == 0;
                });
                const isLocal = this.calendarLocal.filter(d => {
                    return moment.duration(moment(d.date).diff(moment(day.date))).asDays() == 0;
                });
                this.dataCalendarModifier = [...isLocal, ...isServeur].map(modif => {
                    var _modif = {
                        ...modif,
                        etat: moment(modif.date).valueOf() < moment().valueOf() ?
                            this.$dictionnaire.status_calendar_passe : modif.status == 1 ? this.$dictionnaire.status_calendar_active : this.$dictionnaire.status_calendar_desactive,
                    };
                    return _modif;
                })
                if (this.dataCalendarModifier.length) {
                    this.$modal.show('calendar-edit');
                }
            }


        },
        addCalendar(event) {
            var _this5 = this;
            $('#calendar').each(function() {
                const datas = Myform(this).serialized();
                if (datas) {
                    [...JSON.parse(datas.date)].map(_data => {
                        const data = {...datas, date: _data };
                        var attrs = {};
                        switch (data['ui_event']) {
                            case 'bar':
                                attrs = {
                                    bar: {
                                        style: {
                                            backgroundColor: data.color,
                                            class: Date.now() > data.date ? 'opacity-75' : '',
                                        }
                                    },
                                }
                                break;

                            case 'dot':
                                attrs = {
                                    dot: {
                                        style: {
                                            backgroundColor: data.color,
                                            class: Date.now() > data.date ? 'opacity-75' : '',
                                        },
                                    },
                                }
                                break;

                            case 'highlight':
                                attrs = {
                                    highlight: {
                                        style: {
                                            backgroundColor: data.color,
                                            class: Date.now() > data.date ? 'opacity-75' : '',
                                        },
                                        fillMode: 'light',
                                    },
                                }
                                break;
                        }
                        attrs = {
                            ...attrs,
                            popover: {
                                label: `${data.description} ${data.time_start} - ${data.time_end}`,
                                hideIndicator: true,
                            },
                            dates: moment(data.date).toDate(),
                        }

                        const isExistEventServeur = [..._this5.calendarServeur].filter(d => {
                            return moment.duration(
                                moment(_this5.$parseDate(d.date)).set({
                                    'hour': parseInt(String(d.time_start).split(':')[0]),
                                    'minute': parseInt(String(d.time_start).split(':')[1]),
                                    'seconde': 0,
                                    'millisecond': 0
                                }).diff(
                                    moment(data.date).set({
                                        'hour': parseInt(String(data.time_start).split(':')[0]),
                                        'minute': parseInt(String(data.time_start).split(':')[1]),
                                        'seconde': 0,
                                        'millisecond': 0
                                    })
                                )
                            ).asMinutes() == 0 && d.description == data.description;
                        });
                        const isExistEventLocal = [..._this5.calendarLocal].filter(d => {
                            return moment.duration(
                                moment(d.date).set({
                                    'hour': parseInt(String(d.time_start).split(':')[0]),
                                    'minute': parseInt(String(d.time_start).split(':')[1]),
                                    'seconde': 0,
                                    'millisecond': 0
                                }).diff(
                                    moment(data.date).set({
                                        'hour': parseInt(String(data.time_start).split(':')[0]),
                                        'minute': parseInt(String(data.time_start).split(':')[1]),
                                        'seconde': 0,
                                        'millisecond': 0
                                    })
                                )
                            ).asMinutes() == 0 && d.description == data.description;
                        });

                        if (isExistEventServeur.length == 0 && isExistEventLocal.length == 0) {
                            _this5.calendarLocal.push({
                                attrs,
                                ...data,
                            })
                        }
                    });
                    _this5.modelCalendar = [];
                    Myform(this).setForm({
                        time_start: '00:00',
                        time_end: '23:59',
                        date: '',
                        description: ''
                    })
                }
            });
        },
        deleteCalendar(event, item, index) {
            var _this7 = this;
            if (item.resource_url) {
                let loading = $(event.target).InputLoadRequest();
                axios.delete(item.resource_url).then(function(response) {
                    _this7.calendarServeur = _this7.calendarServeur.filter(d => {
                        return moment(
                            moment(_this7.$parseDate(d.date)).diff(moment(item.date))
                        ).asDays() == 0 && d.description == item.description;
                    });
                    _this7.$notify({ type: 'success', title: `${_this7.$dictionnaire.success}!`, text: response.data.message ? response.data.message : `${_this7.$dictionnaire.item_successful_delete}.` });
                }, function(error) {
                    _this7.$notify({ type: 'error', title: `${_this7.$dictionnaire.error}!`, text: error.response.data.message ? error.response.data.message : `${_this7.$dictionnaire.error_occured}.` });
                }).finally(function() {
                    loading.remove();
                });
            } else {
                _this7.calendarLocal = _this7.calendarLocal.filter(d => {

                    return !(moment(d.date).set({
                        'hour': 0,
                        'minute': 0,
                        'seconde': 0,
                        'millisecond': 0
                    }).valueOf() === moment(item.date).set({
                        'hour': 0,
                        'minute': 0,
                        'seconde': 0,
                        'millisecond': 0
                    }).valueOf() && d.description == item.description);
                });
            }
            _this7.dataCalendarModifier.splice(index, 1);
            if (!_this7.dataCalendarModifier.length) {
                this.$modal.hide('calendar-edit');
            }
        },
        changeCalendarBtn(action) {
            this.calendar_btn_action = action.map(is => !is);
        },
        createTaxe(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.taxe_prix = true;
            _this5.myEvent = {
                ..._this5.myEvent,
                'createTaxe': function() {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_taxe');
        },
        storeTaxe(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.taxes.push(response.data.taxe)
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        checkTaxeAppliquer(event) {
            var _this5 = this;
            if (event.target.checked) this.taxe_prix = event.target.value == '0' ? false : true;
            $('input[name="valeur_devises"]').each(function() {
                $(this).val('0');
            });
            $('input[name="valeur_pourcent"]').each(function() {
                $(this).val('0');
            })
        },
        stringToHTML(str) {
            var dom = document.createElement('div');
            dom.innerHTML = str;
            return dom;
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
        uploadFondImage(event, drop = false) {
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
                            _this5.fond_image = [data.target.result];
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
        removeFondImage(index) {
            this.fond_image = [];
        },
    },
    props: [
        'detail',
        'url',
        'action',
        'chambre',
        'urlbase', 'urlasset',
        'urlcalendar',
        'datacalendar',
        'urltaxe',
    ]
});