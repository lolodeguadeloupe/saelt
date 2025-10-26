import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('detail-billeterie-maritime-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditBilleterie: '',
            actionEditTarifPersonne: '',
            myEvent: {},
            billeterie_form: [true, false],
            typePersonnes: [],
            compagnies: [],
            data_detail: [this.detail],
            images: [],
            logo: [],
            weeksAvailability: [],
            is_create: false,
            pagination_: [true, false],
            url_item_time: '',
            has_create_time: false,
            has_edit_time: false,
            parcours: 1,
        }
    },
    methods: {
        changeParcour(val) {
            this.parcours = val;
        },
        editBilleterie(event, url, tabs = [false, true], tab_action = false) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.billeterie_form = tabs.map(is => !is);
            _this5.typePersonnes = [];
            _this5.compagnies = [];
            axios.get(url).then(function (response) {
                _this5.actionEditBilleterie = response.data.billeterieMaritime.resource_url;
                _this5.typePersonnes = response.data.typePersonne ? response.data.typePersonne : [];
                _this5.compagnies = response.data.compagnieTransport ? response.data.compagnieTransport : [];
                _this5.parcours = response.data.billeterieMaritime.parcours;
                //
                _this5.id_model = `billeterie_maritime_${response.data.billeterieMaritime.id}`;
                _this5.url_item_time = response.data.billeterieMaritime.resource_url;
                _this5.url_get_time = response.data.billeterieMaritime.resource_url;
                //
                var _data_tarif = {},
                    tarifs = response.data.tarif.tarif;
                _this5.images = response.data.billeterieMaritime.image ? [response.data.billeterieMaritime.image] : [];
                _this5.typePersonnes.map(function (_type, index) {
                    for (var i in tarifs) {
                        if (tarifs[i].type_personne_id == _type.id) {
                            _data_tarif['marge_aller_' + index] = tarifs[i].marge_aller;
                            _data_tarif['marge_aller_retour_' + index] = tarifs[i].marge_aller_retour;
                            _data_tarif['prix_achat_aller_' + index] = tarifs[i].prix_achat_aller;
                            _data_tarif['prix_achat_aller_retour_' + index] = tarifs[i].prix_achat_aller_retour;
                            _data_tarif['prix_vente_aller_' + index] = tarifs[i].prix_vente_aller;
                            _data_tarif['prix_vente_aller_retour_' + index] = tarifs[i].prix_vente_aller_retour;
                        }
                    }
                })
                if (tab_action) {
                    $('#edit-billeterie').each(function () {
                        const _data = response.data.billeterieMaritime;
                        Myform(this).setForm({ ..._data, ..._data_tarif, lieu_depart: _data.depart.name, lieu_arrive: _data.arrive.name });

                    })
                } else {
                    _this5.$modal.show('edit_billeterie');
                    _this5.myEvent = {
                        ..._this5.myEvent,
                        'editBilleterie': function () {
                            var _data = response.data.billeterieMaritime;
                            $('#edit-billeterie').each(function () {
                                Myform(this).setForm({ ..._data, ..._data_tarif, lieu_depart: _data.depart.name, lieu_arrive: _data.arrive.name });

                            })
                        }
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        storeBilleterie(event, modal) {
            var _this5 = this;
            /*remeve error */
            $('#billeterie_maritime_block').each(function () {
                $(this).removeClass('block-error');
                $(this).children('div').find('.fallback-error').each(function () {
                    $(this).remove();
                });
            })
            /*remove error*/
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                    _this5.getDetail();
                },
                errors: function (error) {
                    $('#edit-billeterie').each(function () {
                        if (error.response && error.response.status && error.response.status === 422) {
                            var origin_errors = { ...error.response.data.errors };
                            for (const xx in origin_errors) {
                                const x = String(xx).split('.');
                                origin_errors[x[1]] = origin_errors[xx];
                            }
                            Myform(this).erreur({ error: 422, data: origin_errors });
                            _this5.billeterie_form = [true, false, true];
                            for (var _err in origin_errors) {
                                const err = String(_err).split('.');
                                if (['marge_aller', 'marge_aller_retour', 'prix_vente_aller', 'prix_vente_aller_retour', 'prix_achat_aller', 'prix_achat_aller_retour'].indexOf(err[0]) >= 0)
                                    _this5.billeterie_form = [false, true, false];
                            }
                            $('#billeterie_maritime_block').each(function () {
                                $(this).addClass('block-error');
                                $('<div/>').attr({ class: 'fallback-error' }).html(`${_this5.$dictionnaire.form_error}`).appendTo($(this).children('div'));
                            })
                        }
                    })
                },
            }, false, {});
        },
        changeWeekAvailableDate(event) {
            var _this5 = this;
            const val = $(event.target).attr('data-value');
            this.weeksAvailability = this.weeksAvailability.filter(function (week) {
                return week != val;
            });
            if (event.target.checked) {
                this.weeksAvailability.push(val)
            }
            $('#billeterie-list-week').each(function () {
                $(this).find('input').each(function () {
                    $(this).prop('checked', false);
                    const _val = $(this).attr('data-value');
                    if (_this5.weeksAvailability.findIndex(d => d == _val) >= 0) {
                        $(this).prop('checked', true);
                    }

                });
            });
        },
        fnWeekRender(week) {
            if (week == null) return [];
            const arrWeek = String(week).split(',');
            return this.$dictionnaire.week_list.filter((_week, id) => {
                return arrWeek.indexOf(String(id)) >= 0;
            })
        },
        deleteBilleterie(url) {
            var _this5 = this;
            this.deleteItem(url, {
                success: function (response) {
                    _this5.getDetail();
                }
            }, null, false)
        },
        createPersonne(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createPersonne': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_personne');
        },
        editPersonne(event, type_personne) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent,
                'createPersonne': function () {
                    $('#create-personne').each(function () {
                        Myform(this).setForm(type_personne);
                    });
                    loading.remove();
                }
            }
            _this5.$modal.show('create_personne');
        },
        storePersonne(event, modal) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            $('#create-personne').each(function () {
                const _type_pers = Myform(this).serialized();
                if (_type_pers != null) {
                    const index = _this5.typePersonnes.findIndex(function (_type) {
                        return _type.type == _type_pers.type;
                    });
                    if (index < 0) {
                        _type_pers['id'] = 0;
                        _type_pers['reference_prix'] = 0;
                        _this5.typePersonnes = [..._this5.typePersonnes, _type_pers];
                        _this5.$modal.hide(modal);
                    } else if (index >= 0) {
                        const _temp = _this5.typePersonnes;
                        const id = _temp[index].id;
                        _temp[index] = { ..._temp[index], ..._type_pers, id: id }
                        _this5.typePersonnes = [..._temp];
                        _this5.$modal.hide(modal);
                    }
                }
                loading.remove();
            });
        },
        deletePersonne(event, $index) {
            let loading = $(event.target).InputLoadRequest();
            this.typePersonnes = this.typePersonnes.filter((_val, _id) => _id != $index);
            this.$promise(function () {
                loading.remove();
            })
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        changeFormBilleterie(event, form = []) {
            event.preventDefault();
            var _this5 = this;
            if (_this5.billeterie_form[0]) {
                var isValid = true;
                $('[name="titre"],[name="compagnie_transport_id"],[name="quantite"],[name="date_acquisition"][name="date_acquisition"],[name="date_limite"],[name="lieu_depart"],[name="date_depart"],[name="lieu_arrive"],[name="date_arrive"]').each(function () {
                    if (!Myform(this).isValid()) {
                        isValid = false;
                    }
                })
                if (isValid) {
                    _this5.billeterie_form = form.map(is => !is);
                }
            } else {
                _this5.billeterie_form = form.map(is => !is);
            }
            /*remeve error */
            $('#billeterie_excursion_block').each(function () {
                $(this).removeClass('block-error');
                $(this).find('.fallback-error').each(function () {
                    $(this).remove();
                });
            })
            /*remove error*/
        },
        initTarif() {
            var _this5 = this;
            $('#edit-billeterie').each(function () {
                Myform(this).removeErreur();
            });
            _this5.typePersonnes.map((types, index) => {
                if (index > 0) {
                    $('[name="marge_aller_' + index + '"],[name="marge_aller_retour_' + index + '"],[name="prix_achat_aller_' + index + '"],[name="prix_achat_aller_retour_' + index + '"],[name="prix_vente_aller_' + index + '"],[name="prix_vente_aller_retour_' + index + '"]').each(function () {
                        $(this).val('0');
                    });
                }
            })
        },
        checkMarge(event, suffix_name) {
            const marge = $('input[name="marge_' + suffix_name + '"]'),
                _this555 = this;
            marge.each(function () {
                //if ($(this).val() == '' || isNaN($(this).val())) $(this).val(0.0);
                const marge_val = ($(this).val() == '' || isNaN($(this).val())) ? 0.0 : $(this).val();
                $('input[name="prix_achat_' + suffix_name + '"]').each(function () {
                    //if ($(this).val() == '' || isNaN($(this).val())) $(this).val(0.0);
                    const prix_achat = ($(this).val() == '' || isNaN($(this).val())) ? 0.0 : $(this).val();
                    $('input[name="prix_vente_' + suffix_name + '"]').each(function () {
                        const calc = `${(parseFloat(prix_achat) + parseFloat(marge_val))}`
                        $(this).val(parseFloat(calc));
                        $(this).removeInputErrer();
                    })
                })
            })
        },
        createCompagnie(event, url) {
            var _this5 = this;
            _this5.logo = [];
            let loading = $(event.target).InputLoadRequest();
            _this5.$modal.show('create_compagnie');
            _this5.myEvent = {
                ..._this5.myEvent,
                'createCompagnie': function () {
                    loading.remove()
                }
            }

        },
        storeCompagnie(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.compagnies.push(response.data.compagnieTransport);
                    _this5.$promise(function () {
                        $('#create-billeterie').each(function () {
                            Myform(this).setForm({
                                compagnie_transport_id: response.data.compagnieTransport.id
                            });
                        });
                        $('#edit-billeterie').each(function () {
                            Myform(this).setForm({
                                compagnie_transport_id: response.data.compagnieTransport.id
                            });
                        });
                    });
                    _this5.$modal.hide('create_compagnie');
                }
            }, false);
        },
        storePlaningTime(event) {
            var _this5 = this;
            const availability = _this5.weeksAvailability.length ? { availability: _this5.weeksAvailability.join(',') } : {};
            this.mySubmit(event, {
                success: function (response) {
                    _this5.has_edit_time = false;
                    _this5.has_create_time = false;
                    _this5.getDetail();
                    $('#planing_time').each(function () {
                        Myform(this).setForm({ debut: '', fin: '' });
                    });
                    _this5.weeksAvailability = [];
                }
            }, false, { ...availability }, false);
        },
        getDetail() {
            var loading = null;
            $('#parent-loader').each(function () {
                loading = $(this).InputLoadRequest();
            })
            var _this5 = this;
            axios.get(_this5.url).then(function (response) {
                _this5.data_detail = [response.data.data];
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) loading.remove();
            });
        },
        deletePlaningTime(url) {
            var _this5 = this;
            this.deleteItem(url, {
                success: function (response) {
                    _this5.getDetail();
                }
            }, null, false)
        },
        trierPlaningTime(planingTime) {

            const times = function (time) {
                return String(time).split(':');
            }
            return planingTime ? planingTime.map(function (arr) { return arr }).sort(function (a, b) {

                if (parseInt(times(a.debut)[0]) == parseInt(times(b.debut)[0]))
                    return parseInt(times(a.debut)[1]) - parseInt(times(b.debut)[1]);
                return parseInt(times(a.debut)[0]) - parseInt(times(b.debut)[0]);
            }) : []
        },
        editPlaningTime(time) {
            var _this5 = this;
            _this5.url_item_time = time.resource_url;
            _this5.has_edit_time = true;
            _this5.has_create_time = false;
            _this5.weeksAvailability = _this5.$splite(time.availability, ",");
            $('#planing_time').each(function () {
                Myform(this).setForm(time);
            });
        },
        createPlaningTime() {
            var _this5 = this;
            _this5.has_edit_time = false;
            _this5.has_create_time = true;
            _this5.weeksAvailability = [];
            _this5.url_item_time = `${_this5.urlbase}/admin/planing-times`;
            $('#planing_time').each(function () {
                Myform(this).setForm({ debut: '', fin: '' });
            });
        },
        editTarifPersonne(event, url, condition) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTarifPersonne = response.data.tarifBilleterieMaritime.resource_url;
                _this5.myEvent = {
                    ..._this5.myEvent,
                    'editTarifPersonne': function () {
                        $('#edit-tarif-form' + condition).each(function () {
                            Myform(this).setForm({ ...response.data.tarifBilleterieMaritime, type_personne: response.data.tarifBilleterieMaritime.personne.type });
                        })
                    }
                }
                _this5.$modal.show('edit_tarif_personne' + condition)
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        updateTarifForm(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.getDetail();
                    _this5.$modal.hide(modal)
                }
            }, false, {}, false);
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
                            _this5.images = [data.target.result];
                            progress_bar.remove();
                        }
                        reader.onprogress = (_event) => {
                            $($(event.target).is('figure') ? $(event.target) : $(event.target).parents('figure')).each(function () {
                                $(this).find('.my-_btn-add').each(function () {
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
            this.images = [];
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
                            $($(event.target).is('figure') ? $(event.target) : $(event.target).parents('figure')).each(function () {
                                $(this).find('.my-_btn-add').each(function () {
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
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
                    window.location.replace(`${_this5.urlbase}/admin/service-ports`);
                },
                detailInfo: ['name', 'code_service', 'adresse', 'ville.name', 'ville.pays.nom'],
                formateDetailInfo: null,
                frame: this,
            }
        },
        autocompleteVille() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
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
                success: function (response) {
                    _this5.$modal.hide('create_ville');
                }
            }, false, {}, false);
        },
        autocompletePays() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
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
                success: function (response) {
                    _this5.$modal.hide('create_pays');
                }
            }, false, {}, false);
        },
        nextPage(current) {
            this.pagination_ = current.map(is => !is);
        },
        autocompleteType() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) { },
                fnBtnNew: function (event, options) {
                    _this5.$managerliens({
                        is_parent: false,
                        parent_name: 'hebergement-excursion-transfert-location-billeterie',
                        href: `${_this5.urlbase}/admin/type-personnes`,
                        name: _this5.$dictionnaire.type_personne,
                        body: event.target,
                        _this: _this5,
                        axios: axios,
                        liens: 'other',
                        range: '2',
                        _$: $
                    });
                },
                detailInfo: ['type', 'age'],
                formateDetailInfo: null,
                frame: this,
            }
        },
    },
    props: [
        'url',
        'action',
        'devises',
        'urlcompagnie',
        'urlbase', 'urlasset',
        'detail'
    ]
});