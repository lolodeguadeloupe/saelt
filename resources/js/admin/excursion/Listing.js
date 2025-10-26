import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
const formatDateString = "YYYY-MM-DD";

Vue.component('excursion-listing', {
    mixins: [AppListing, AppForm],
    data: function() {
        return {
            form: { taxes: [] },
            actionEditExcursion: '',
            actionEditPrestataire: '',
            actionCalendar: null,
            myEvent: {},
            form_excursion: [false, false],
            form_excursion_edit: [false, false],
            url_resourse_prestataire: "",
            url_resourse_excursion: "",
            imageUploads: [],
            imageServeur: [],
            cardImage: [],
            prestataireIsReadOnly: false,
            calendarServeur: [],
            calendarLocal: [],
            modelCalendar: [],
            style_color_calendar: '#aaaaaa',
            calendar_btn_action: [false, true],
            dataCalendarModifier: [],
            weeksAvailability: [],
            taxes: [],
            taxe_prix: true,
            logo: [],
            isTicket: false,
            isLunch: false,
            all_restaurant: [],
            all_billeterie: [],
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
        allRestaurantValue() {
            return this.all_restaurant.map(val => val.id).join(',');
        },
        allBilleterieValue() {
            return this.all_billeterie.map(val => val.id).join(',');
        },
        availability(){
            return  this.weeksAvailability.join(',');
        }

    },
    methods: {
        editExcursion(event, url, tabs = [false, true], tab_action = false) {
            var _this5 = this;
            this.form_excursion_edit = tabs.map(tab => !tab);
            this.url_resourse_excursion = url;
            _this5.imageUploads = [];
            _this5.imageServeur = [];
            _this5.cardImage = [];
            _this5.calendarLocal = []; //init calendar local
            _this5.weeksAvailability = [];
            _this5.taxes = [];
            _this5.all_restaurant = [];
            _this5.all_billeterie = [];
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditExcursion = response.data.excursion.resource_url;
                _this5.actionCalendar = response.data.excursion.resource_url + '/calendar';
                _this5.taxes = response.data.taxe;
                _this5.cardImage = response.data.excursion.card ? [response.data.excursion.card] : [];
                _this5.fond_image = response.data.excursion.fond_image ? [response.data.excursion.fond_image] : [];
                _this5.weeksAvailability = response.data.excursion.availability ? response.data.excursion.availability.split(',') : [];
                _this5.url_resourse_prestataire = response.data.prestataire.resource_url
                _this5.imageServeur = response.data.excursion.image ? [...response.data.excursion.image].map(function(image) { return {...image, name: `${image.name}` } }) : [];
                _this5.form.taxes = response.data.taxe.filter(val => response.data.excursion.taxe.map(_val => _val.id).includes(val.id));
                _this5.isTicket = response.data.excursion.ticket == 1;
                _this5.isLunch = response.data.excursion.lunch == 1;
                /** */
                _this5.all_restaurant = response.data.excursion.lunch_prestataire;
                _this5.all_billeterie = response.data.excursion.ticket_billeterie;
                if (tab_action) {
                    $('#edit-excursion').each(function() {
                        Myform(this).setForm({
                            ...response.data.excursion,
                            ville_name: response.data.excursion.ville?response.data.excursion.ville.name:'',
                            lieu_depart: response.data.excursion.depart != null ? response.data.excursion.depart.name : '',
                            lieu_arrive: response.data.excursion.arrive != null ? response.data.excursion.arrive.name : '',
                            ile_name: response.data.excursion.ile.name,
                        });
                        $('#excursion-list-week').each(function() {
                            $(this).find('input').each(function() {
                                $(this).prop('checked', false);
                                const _val = $(this).attr('data-value');
                                if (_this5.weeksAvailability.findIndex(d => d == _val) >= 0) {
                                    $(this).prop('checked', true);
                                }

                            });
                        });
                    })
                } else {
                    _this5.$modal.show('edit_excursion');
                    _this5.myEvent = {
                        ..._this5.myEvent,
                        'editExcursion': function() {
                            var _data = response.data.excursion,
                                _this55 = _this5;
                            $('#edit-excursion').each(function() {
                                Myform(this).setForm({
                                    ..._data,
                                    ville_name: _data.ville?_data.ville.name:'',
                                    lieu_depart: _data.depart != null ? _data.depart.name : '',
                                    lieu_arrive: _data.arrive != null ? _data.arrive.name : '',
                                    ile_name: _data.ile.name,
                                });
                                $('#excursion-list-week').each(function() {
                                    $(this).find('input').each(function() {
                                        $(this).prop('checked', false);
                                        const _val = $(this).attr('data-value');
                                        if (_this5.weeksAvailability.findIndex(d => d == _val) >= 0) {
                                            $(this).prop('checked', true);
                                        }

                                    });
                                });
                            })
                        }
                    }
                }
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        editPrestataire(event, url, tabs) {
            var _this5 = this;
            _this5.prestataireIsReadOnly = true;
            _this5.logo = [];
            this.form_excursion_edit = tabs.map(tab => !tab);
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.actionEditPrestataire = `${_this5.actionEditExcursion}/prestataire/${response.data.prestataire.id}`;
                _this5.logo = response.data.prestataire.logo ? [response.data.prestataire.logo] : [];
                $('#edit-prestataire').each(function() {
                    Myform(this).setForm({...response.data.prestataire, ville_name: response.data.prestataire.ville.name });
                })
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) {
                    loading.remove();
                }
            });
        },
        createExcursion(event, url) {
            var _this5 = this;
            _this5.prestataireIsReadOnly = true;
            let loading = $(event.target).InputLoadRequest();
            _this5.imageUploads = [];
            _this5.imageServeur = [];
            _this5.cardImage = [];
            _this5.fond_image = [];
            _this5.weeksAvailability = [];
            _this5.calendarLocal = []; //init calendar local
            _this5.actionCalendar = _this5.url + '/0/calendar';
            _this5.taxes = [];
            _this5.all_restaurant = [];
            _this5.all_billeterie = [];
            _this5.form = {...(_this5.form ? _this5.form : {}) };
            axios.get(url).then(function(response) {
                _this5.form_excursion = [true, false];
                _this5.taxes = response.data.taxe;
                _this5.$modal.show('create_excursion');
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            }).finally(() => {
                loading.remove();
            });
        },
        storeExcursion(event, modal) {
            var _this5 = this;
            const data_excursion = _this5.submitExcursionForm();
            const data_prest = _this5.submitPrestataireForm();
            const availability = _this5.weeksAvailability.length ? { availability: _this5.weeksAvailability.join(',') } : {};
            if (data_excursion && data_prest) {
                var loading = $(event.target).InputLoadRequest();
                $('#create-excursion').each(function() {
                    _this5.postData(
                        _this5.urlexcursionwithprestataire, {
                            excursion: {
                                ...data_excursion,
                                image: _this5.imageUploads,
                                ...availability,
                                taxes: [...(_this5.form.taxes ? _this5.form.taxes : [])].map(val => `${val.id}`)
                            },
                            prest: {
                                ...data_prest
                            },
                            calendar: _this5.calendarLocal,
                        }, {
                            success: function(response) {
                                _this5.loadData();
                                _this5.calendarLocal = [];
                                _this5.modelCalendar = [];
                                _this5.calendarServeur = response.data.calendar;
                                _this5.$modal.hide(modal);
                            },
                            errors: function(error) {
                                $('#create-excursion').each(function() {
                                    if (error.response && error.response.status && error.response.status === 422) {
                                        const origin_errors = {...error.response.data.errors };
                                        var new_errors = {};
                                        for (const xx in origin_errors) {
                                            const x = String(xx).split('.');
                                            if (x.length > 1 && x[0] == "excursion") new_errors[x[1]] = origin_errors[xx];
                                        }
                                        Myform(this).erreur({ error: 422, data: new_errors });
                                    }
                                })
                                $('#create-prestataire').each(function() {
                                    if (error.response && error.response.status && error.response.status === 422) {
                                        const origin_errors = {...error.response.data.errors };
                                        var new_errors = {};
                                        for (const xx in origin_errors) {
                                            const x = String(xx).split('.');
                                            if (x.length > 1 && x[0] == "prest") new_errors[x[1]] = origin_errors[xx];
                                        }
                                        Myform(this).erreur({ error: 422, data: new_errors });
                                        for (var err in new_errors) {
                                            if (['name', 'adresse', 'phone', 'email', 'ville_id', 'heure_fermeture', 'heure_ouverture'].indexOf(String(err)) >= 0 && !_this5.form_excursion[0])
                                                _this5.form_excursion = [true, false];
                                        }

                                    }
                                })
                            },
                            finally: function() {
                                loading.remove();
                            }
                        }
                    )
                })
            }
        },
        storePrestataire(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function() {
                    _this5.$modal.hide(modal);
                }
            }, false, {});
        },
        updateExcursion(event, modal) {
            var _this5 = this;
            const availability = _this5.weeksAvailability.length ? { availability: _this5.weeksAvailability.join(',') } : {};
            this.mySubmit(event, {
                success: function(response) {
                    _this5.editPrestataire(event, `${_this5.url_resourse_prestataire}/edit`, [true, false]),
                        _this5.calendarLocal = [];
                    _this5.modelCalendar = [];
                    _this5.calendarServeur = response.data.calendar;
                }
            }, false, {
                image: _this5.imageUploads,
                calendar: _this5.calendarLocal,
                ...availability,
                taxes: [...(_this5.form.taxes ? _this5.form.taxes : [])].map(val => `${val.id}`)
            }, true);
        },
        updatePrestataire(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function(response) {
                    _this5.$modal.hide(modal);
                }
            }, false, {}, true);
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
        detail(event, id) {
            this.$managerliens({
                is_parent: false,
                parent_name: 'excursion',
                href: `${this.url}/${id}?excursion=${id}`,
                name: 'Info',
                body: event.target,
                _this: this,
                axios: axios,
                liens: 'childre',
                range: '0',
                _$: $
            });
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
        submitPrestataireForm() {
            var _this5 = this,
                data = null;
            $('#create-prestataire').each(function() {
                data = Myform(this).serialized();
                if (!data) {
                    _this5.form_excursion = [true, false];
                }
            });
            return data;
        },
        submitExcursionForm() {
            var _this5 = this,
                data = null;
            $('#create-excursion').each(function() {
                data = Myform(this).serialized();
                if (!data) {
                    _this5.form_excursion = [false, true];
                }
            });
            return data;
        },
        changeFormExcursion(form = []) {
            var _this5 = this;
            if (_this5.form_excursion[0]) {
                $('#create-prestataire').each(function() {
                    if (Myform(this).serialized()) {
                        _this5.form_excursion = form.map(is => !is);
                    }
                })
            } else {
                _this5.form_excursion = form.map(is => !is);
            }
        },
        autocomplete() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {
                    _this5.actionEditPrestataire = `${_this5.actionEditExcursion}/prestataire/${item.id}`;
                    _this5.logo = item.logo ? [item.logo] : [];
                    $('#create-prestataire').each(function() {
                        Myform(this).setForm({...item, ville_name: item.ville.name }).removeErreur();
                    });
                    $('#edit-prestataire').each(function() {
                        Myform(this).setForm({...item, ville_name: item.ville.name }).removeErreur();
                    });
                    $('#create-excursion').each(function() {
                        Myform(this).setForm({ prestataire_id: item.id }).removeErreur();
                    });
                    $('#edit-excursion').each(function() {
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
                                        $('#create-excursion').each(function() {
                                            Myform(this).setForm({ prestataire_id: data.id }).removeErreur();
                                        });
                                        $('#edit-excursion').each(function() {
                                            Myform(this).setForm({ prestataire_id: data.id }).removeErreur();
                                        });
                                        _this5.actionEditPrestataire = `${_this5.actionEditExcursion}/prestataire/${data.id}`;
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
        changeWeekAvailableDate(event) {
            var _this5 = this;
            const val = $(event.target).attr('data-value');
            this.weeksAvailability = this.weeksAvailability.filter(function(week) {
                return week != val;
            });
            if (event.target.checked) {
                this.weeksAvailability.push(val)
            }
            $('#excursion-list-week').each(function() {
                $(this).find('input').each(function() {
                    $(this).prop('checked', false);
                    const _val = $(this).attr('data-value');
                    if (_this5.weeksAvailability.findIndex(d => d == _val) >= 0) {
                        $(this).prop('checked', true);
                    }

                });
            });
        },
        uploadCart(event, drop = false) {
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
                            _this5.cardImage = [data.target.result];
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
        removeCart(index) {
            this.cardImage = [];
        }, 
        fnWeekRender(week) {
            if (week == null) return [];
            const arrWeek = String(week).split(',');
            return this.$dictionnaire.week_list.filter((_week, id) => {
                return arrWeek.indexOf(String(id)) >= 0;
            })
        },
        createTaxe(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.taxe_prix = false;
            _this5.myEvent = {
                ..._this5.myEvent,
                'createTaxe': function() {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_taxe');
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
        checkTicket(event) {
            this.isTicket = event.target.value == 1;
        },
        checkLunch(event) {
            this.isLunch = event.target.value == 1;
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
        autocompleteRestaurant() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {
                    const index = _this5.all_restaurant.findIndex(function(_val_search) {
                        return _val_search.id == item.id;
                    });
                    if (index >= 0) {
                        $(`#restaurant-${item.id}`).each(function() {
                            var _el = this;
                            $(_el).toggleClass('bg-success');
                            _this5.$promise(function() {
                                $(_el).toggleClass('bg-success');
                            }, 200);
                        });
                        return;
                    }
                    _this5.all_restaurant = [..._this5.all_restaurant, item];
                },
                fnBtnNew: function(event, options) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'excursion',
                        href: `${_this5.urlbase}/admin/prestataires`,
                        name: _this5.$dictionnaire.prestataire,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'complement',
                        range: '3',
                        _$: $
                    });
                },
                detailInfo: ['name', 'ville.name'],
                formateDetailInfo: null,
                frame: this,
            } 
        },
        autocompleteBilleterie() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function(item) {
                    const index = _this5.all_billeterie.findIndex(function(_val_search) {
                        return _val_search.id == item.id;
                    });
                    if (index >= 0) {
                        $(`#billeterie-${item.id}`).each(function() {
                            var _el = this;
                            $(_el).toggleClass('bg-success');
                            _this5.$promise(function() {
                                $(_el).toggleClass('bg-success');
                            }, 200);
                        });
                        return;
                    }
                    _this5.all_billeterie = [..._this5.all_billeterie, item];
                },
                fnBtnNew: function(event, options) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'excursion',
                        href: `${_this5.urlbase}/admin/billeterie-maritimes`,
                        name: _this5.$dictionnaire.billeterie,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'complement',
                        range: '3',
                        _$: $
                    });
                },
                detailInfo: ['titre', 'depart.name', 'arrive.name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        removeIndexRestaurant(event, index) {
            var _this5 = this;
            _this5.all_restaurant.splice(index, 1);
        },
        removeIndexBilleterie(event, index) {
            var _this5 = this;
            _this5.all_billeterie.splice(index, 1);
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'urlexcursionwithprestataire',
        'urlprestataire',
        'urlcalendar',
        'urltaxe',
    ]
});