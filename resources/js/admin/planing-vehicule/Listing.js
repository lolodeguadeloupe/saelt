import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';
const color = ['#4fe885', '#e8de4f', '#e8874f', '#4fdee8', '#4f8fe8'];

Vue.component('planing-vehicule-listing', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {},
            myEvent: {},
            month: parseInt(this.data.month) - 1,
            length_month: 1,
            year: this.data.year,
            location_id: null,
            vehicule_immatriculation: null,
            vehicule_categorie: null,
            categorie_id: null,
            day_in_year: [],
            vehicule: [],
            categorie_calendar: [],
            width_calendar: 50,
            state_change: [0],
            detail_location: [],
            tab: [true, false, false, false],
        }
    },
    watch: {
        'location_id': function location_id(newVal, oldVal) {
            if (+newVal != +oldVal && this.year != null && this.month != null) {
                this.searcPlaning(this.year, this.month, this.length_month, newVal, this.categorie_id);
            }
        },
        'categorie_id': function categorie_id(newVal, oldVal) {
            if (+newVal != +oldVal && this.year != null && this.month != null) {
                this.searcPlaning(this.year, this.month, this.length_month, this.location_id, newVal);
                this.changeState();
            }
        },
        'month': function month(newVal, oldVal) {
            if (+newVal != +oldVal && this.year != null) {
                this.searcPlaning(this.year, newVal, this.length_month, this.location_id, this.categorie_id);
            }
        },
        'year': function year(newVal, oldVal) {
            if (+newVal != +oldVal && this.month != null) {
                this.searcPlaning(newVal, this.month, this.length_month, this.location_id, this.categorie_id);
            }
        },
        'length_month': function length_month(newVal, oldVal) {
            if (+newVal != +oldVal && this.month != null) {
                this.searcPlaning(this.year, this.month, newVal, this.location_id, this.categorie_id);
            }
        },
        'vehicule': function vehicule(newVal, oldVal) {
            if (+newVal != +oldVal) {
                this.vehiculePlaning();
            }
        }
    },
    async mounted() {
        var _this5 = this;
        await _this5.getCalendar(_this5.year, _this5.month, _this5.length_month);
        _this5.vehicule = [..._this5.data.vehicule];
        /** */
        $('.opacity-load-0').each(function () {
            $(this).removeClass('opacity-load-0');
            $('.create-page-load').each(function () {
                $(this).remove();
                $('body').each(function () {
                    $(this).css({ overflow: 'auto' })
                })
            })
        });
        /* manager liens */
        $('body').each(function () {
            $(this).click(function (event) {
                var _body = this;
                var el = null;
                $(event.originalEvent.target).each(function () {
                    $(this).parents('li.manager-liens').each(function () {
                        $(this).find('a.nav-link-manager-liens').each(function () {
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

    },
    methods: {
        changeState() {
            var _this5 = this;
            if (this.state_change[0] != undefined) {
                this.state_change = [];
                this.$promise(function () {
                    _this5.state_change = [1]
                })
            }
        },
        deleteCategorieFiltre() {
            this.categorie_id = null;
            this.vehicule_categorie = "";
        },
        deleteVehiculeFiltre() {
            this.location_id = null;
            this.vehicule_immatriculation = "";
        },
        vehiculePlaning() {
            var _this5 = this;
            var categorie = [];
            for (let index_cat = 0; index_cat < _this5.vehicule.length; index_cat++) {
                //categorie
                var title_cat = null;
                var vehicule = [];
                for (let index_vehicule = 0; index_vehicule < _this5.vehicule[index_cat].length; index_vehicule++) {
                    //vehicule
                    var title_veh = null;
                    const day_in_year_day = JSON.parse(JSON.stringify(_this5.day_in_year.day));
                    for (let index_month = 0; index_month < day_in_year_day.length; index_month++) {
                        var next_vehicule = 0;
                        for (let index_day = 0; index_day < day_in_year_day[index_month].length; index_day++) {
                            delete day_in_year_day[index_month][index_day]['planing'];
                            var while_vehicule = 0;
                            /** */
                            next_vehicule = next_vehicule <= 0 ? 0 : next_vehicule;
                            /** */
                            if (next_vehicule == 0) {
                                day_in_year_day[index_month][index_day]['planing'] = 1;
                                while (while_vehicule < _this5.vehicule[index_cat][index_vehicule].length) {
                                    title_cat = {
                                        id: _this5.vehicule[index_cat][index_vehicule][while_vehicule].categorie_vehicule_id,
                                        titre: _this5.vehicule[index_cat][index_vehicule][while_vehicule].categorie_vehicule_titre
                                    };
                                    title_veh = {
                                        id: _this5.vehicule[index_cat][index_vehicule][while_vehicule].location_id,
                                        titre: _this5.vehicule[index_cat][index_vehicule][while_vehicule].immatriculation
                                    };
                                    if (_this5.vehicule[index_cat][index_vehicule][while_vehicule].date_recuperation != undefined) {
                                        const date_recuperation = _this5.$parseDate(_this5.vehicule[index_cat][index_vehicule][while_vehicule].date_recuperation);
                                        const date_restriction = _this5.$parseDate(_this5.vehicule[index_cat][index_vehicule][while_vehicule].date_restriction);
                                        if (moment(date_recuperation).isSameOrBefore(day_in_year_day[index_month][index_day].toDate) && moment(date_restriction).isSameOrAfter(day_in_year_day[index_month][index_day].toDate)) {
                                            var intervale = parseInt(moment(date_restriction).diff(moment(day_in_year_day[index_month][index_day].toDate), 'day', true)) + 1;
                                            const last_day = parseInt(moment(day_in_year_day[index_month][day_in_year_day[index_month].length - 1].toDate).diff(moment(day_in_year_day[index_month][index_day].toDate), 'day', true)) + 1;
                                            intervale = intervale <= 0 ? 0 : intervale;
                                            day_in_year_day[index_month][index_day]['vehicule'] = _this5.vehicule[index_cat][index_vehicule][while_vehicule];
                                            next_vehicule = intervale;
                                            day_in_year_day[index_month][index_day]['planing'] = intervale > last_day ? last_day : intervale;
                                        }
                                    }
                                    while_vehicule++;
                                }
                            }
                            next_vehicule--;
                        }
                    }
                    vehicule = [
                        ...vehicule,
                        {
                            titre: title_veh,
                            value: day_in_year_day,
                        }
                    ]
                }
                categorie = [
                    ...categorie,
                    {
                        titre: title_cat,
                        value: vehicule,

                    }
                ]
            }
            _this5.categorie_calendar = [...categorie];
        },
        getCalendar(year, month, _length_month) {
            var _this5 = this;
            _this5.day_in_year = [];
            _this5.categorie_calendar = [];
            const length_month = parseInt(_length_month);
            const first_month = new Date(parseInt(year), parseInt(month));
            var all_length_day = 0;
            var _temp = {
                month: [],
                day: []
            };

            for (var k = 0; k < length_month; k++) {
                first_month.setMonth(first_month.getMonth() + (k > 0 ? 1 : k));
                const last_day_month = new Date(first_month.getFullYear(), first_month.getMonth() + 1);
                last_day_month.setDate(last_day_month.getDate() - 1);
                const interval_day = moment(last_day_month).diff(first_month, 'day');
                const temp_day_month = new Date(first_month.getFullYear(), first_month.getMonth());
                _temp = {
                    ..._temp,
                    month: [
                        ..._temp.month,
                        {
                            month_string: `${_this5.$dictionnaire.short_month[first_month.getMonth()]} ${first_month.getFullYear()}`,
                            month: first_month.getMonth(),
                            month_year: first_month.getFullYear()
                        }
                    ]
                }
                _temp.day[k] = [];
                var i = 0;
                while (i <= parseInt(interval_day)) {
                    temp_day_month.setDate(temp_day_month.getDate() + (i > 0 ? 1 : i));
                    _temp.day[k] = [
                        ..._temp.day[k],
                        {
                            length_day: interval_day,
                            day_string: `${temp_day_month.getDate()} ${_this5.$dictionnaire.short_month[temp_day_month.getMonth()]}`,
                            day_string: _this5.$dictionnaire.short_week_list[temp_day_month.getDay() == 0 ? 6 : (temp_day_month.getDay() - 1)],
                            day: temp_day_month.getDate(),
                            day_year: temp_day_month.getFullYear(),
                            toDate: moment(temp_day_month).toDate(),
                            day_to_string: `${temp_day_month.getDate()} ${_this5.$dictionnaire.short_month[temp_day_month.getMonth()]} ${temp_day_month.getFullYear()}`,
                            planing: 1
                        }
                    ];
                    i++;
                    all_length_day++;
                }

            }
            _this5.width_calendar = all_length_day * 50;
            _this5.day_in_year = _temp;
            return true;
        },
        async searcPlaning(year, month, _length_month) {
            await this.getCalendar(year, month, _length_month)
            this.loadPlaning();
        },
        loadPlaning() {
            var _this5 = this;
            let loading = $($('#calendar')).InputLoadRequest();
            axios.get(`${_this5.url}?month=${(parseInt(_this5.month) + 1)}&year=${_this5.year}&location_id=${_this5.location_id}&categorie_id=${_this5.categorie_id}&length_month=${_this5.length_month}`).then(function (response) {
                _this5.vehicule = response.data.vehicule ? [...response.data.vehicule] : [];
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) {
                    loading.remove();
                }
            });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        autocompleteVehicule() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                    _this5.location_id = item.id;
                    _this5.vehicule_immatriculation = item.immatriculation;
                },
                fnBtnNew: function (event, options) {

                },
                fnBtnNewEnable: false,
                detailInfo: ['immatriculation', 'modele.titre'],
                formateDetailInfo: null,
                frame: this,
                dataRequest: {
                    categorie_vehicule_id: _this5.categorie_id
                }
            }
        },
        autocompleteCategorie() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                    _this5.categorie_id = item.id;
                    _this5.vehicule_categorie = item.titre;
                },
                fnBtnNew: function (event, options) {

                },
                fnBtnNewEnable: false,
                detailInfo: [],
                formateDetailInfo: null,
                frame: this,
            }
        },
        displayDate(planing, vehicule) {
            return (planing != undefined);
        },
        detail(event, url) {
            var _this5 = this;
            let loading = $(event.currentTarget).InputLoadRequest();
            axios.get(`${url}/edit`).then(function (response) {
                _this5.$modal.show('planing');
                _this5.detail_location = [response.data.ligneCommandeLocation];
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading)
                    loading.remove();
            });
        },
        changeTab(index) {
            if (this.tab[index] != undefined) {
                const _temp = this.tab;
                for (const k in _temp) {
                    _temp[k] = false;
                }
                _temp[index] = true;
                this.tab = [..._temp];
            }
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
    ]
});