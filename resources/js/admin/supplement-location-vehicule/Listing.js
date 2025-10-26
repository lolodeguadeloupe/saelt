import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('supplement-location-vehicule-listing', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {},
            myEvent: {},
            isEdit: [],
            last_el_edit: null,
            /** */
            jeune_conducteur: this.data.jeune_conducteur,
            conducteur_supplementaire: this.data.conducteur_supplementaire
        }
    },
    mounted() {
        var _this5 = this;
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
        editJeuneConducteur(event, url, index) {
            var _this5 = this;
            const el = event.currentTarget;
            const _temp = _this5.jeune_conducteur;
            for (var k in _temp) {
                _temp[k]['isEdit'] = false;
            }
            let loading = $(el).InputLoadRequest();
            axios.get(`${url}/edit`).then(function (response) {
                _temp[index] = { ..._temp[index], isEdit: true };
                $(el).each(function () {
                    $(this).parents('form').each(function () {
                        var _data = {};
                        for (const j in response.data.supplementJeuneConducteurLocationVehicule) {
                            _data[j] = response.data.supplementJeuneConducteurLocationVehicule[j];
                        }
                        Myform(this).setForm(_data);
                    });
                });

            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
                _this5.jeune_conducteur = [..._temp];
            });
        },
        storeJeuneConducteur(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.jeune_conducteur = [response.data.supplementJeuneConducteurLocationVehicule];
                }
            }, false, {}, false);
        },
        editConducteurSupplementaire(event, url, index) {
            var _this5 = this;
            const el = event.currentTarget;
            const _temp = _this5.conducteur_supplementaire;
            for (var k in _temp) {
                _temp[k]['isEdit'] = false;
            }
            let loading = $(el).InputLoadRequest();
            axios.get(`${url}/edit`).then(function (response) {
                _temp[index] = { ..._temp[index], isEdit: true };
                $(el).each(function () {
                    $(this).parents('form').each(function () {
                        var _data = {};
                        for (const j in response.data.conducteurSupplemetaireLocationVehicule) {
                            _data[j] = response.data.conducteurSupplemetaireLocationVehicule[j];
                        }
                        Myform(this).setForm(_data);
                    });
                });

            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
                _this5.conducteur_supplementaire = [..._temp];
            });
        },
        storeConducteurSupplementaire(event) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function (response) {
                    _this5.conducteur_supplementaire = [response.data.conducteurSupplemetaireLocationVehicule];
                }
            }, false, {}, false);
        },
        checkValeurAppliquer(event, item, index_item, id_other) {
            var _this5 = this;
            const el = event.currentTarget;
            const _temp = item;
            $(id_other).each(function () {
                $(this).val('0');
            })
            _temp[index_item]['valeur_appliquer'] = el.value;
            item = [..._temp];
        },
        annulerEdit(event, item, index_item) {
            var _this5 = this;
            const _temp = item;
            _temp[index_item]['isEdit'] = false;
            item = [..._temp];
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
    ]
});