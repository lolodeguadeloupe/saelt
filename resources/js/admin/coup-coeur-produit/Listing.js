import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('coup-coeur-produit-listing', {
    mixins: [AppForm],
    data: function () {
        return {
            form: {},
            myEvent: {},
            produit: this.$getKey(this.options, 'id'),
            mot_cles: '',
            item_limit: 5,
            all_coup_coeur: true,
            data_loaded: { ...this.produits },
            loading: false,
        }
    },
    watch: {
        'produit': function produit(newVal, oldVal) {
            if (+newVal != +oldVal && this.loading == false) {
                this.loadData();
            }
        },
        'mot_cles': function mot_cles(newVal, oldVal) {
            if (+newVal != +oldVal && this.loading == false) {
                this.loadData();
            }
        },
        'all_coup_coeur': function mot_cles(newVal, oldVal) {
            if (+newVal != +oldVal && this.loading == false) {
                this.loadData();
            }
        },
        'item_limit': function item_limit(newVal, oldVal) {
            if (+newVal != +oldVal && this.loading == false) {
                this.loadData();
            }
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
        loadData() {
            var _this5 = this;
            _this5.loading == true;
            let loading = $($('body')).InputLoadRequest();
            axios.get(`${_this5.url}?produit=${_this5.produit}&mot_cles=${_this5.mot_cles}&all_coup_coeur=${_this5.all_coup_coeur}&item_limit=${_this5.item_limit}`).then(function (response) {
                _this5.data_loaded = response.data ? { ...response.data } : {};
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) {
                    loading.remove();
                }
                _this5.loading == false;
            });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        ajouterItem(event, item, index, produit) {
            var _this5 = this;
            let loading = $(event.currentTarget).InputLoadRequest();
            axios.post(`${_this5.url}`, {
                sigle: item.sigle,
                id: item.id
            }).then(function (response) {
                const _temp = _this5.data_loaded;
                _temp[produit][index] = {
                    ..._temp[produit][index],
                    coup_coeur: response.data.coup_coeur,
                    resource_url: response.data.resource_url
                };
                _this5.data_loaded = { ..._temp };
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) {
                    loading.remove();
                }
            });
        },
        deleteItem(event, item, index, produit) {
            var _this5 = this;
            let loading = $(event.currentTarget).InputLoadRequest();
            axios.post(`${item.resource_url}/delete`).then(function (response) {
                const _temp = _this5.data_loaded;
                if (_this5.all_coup_coeur == true) {
                    _temp[produit].splice(index, 1);
                } else {
                    _temp[produit][index] = {
                        ..._temp[produit][index],
                        coup_coeur: response.data.coup_coeur,
                        resource_url: response.data.resource_url
                    };
                }

                _this5.data_loaded = { ..._temp };
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                if (loading) {
                    loading.remove();
                }
            });
        }
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'options',
        'lang',
        'produits'
    ]
});