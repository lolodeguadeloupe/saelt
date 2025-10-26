import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('produit-condition-tarifaire-listing', {
    mixins: [AppForm],
    data: function() {
        return {
            form: { condition_tarifaire: '' },
            is_edit: false,
        }
    },
    mounted() {
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

    },
    methods: {
        editCondition(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function(response) {
                _this5.is_edit = true;
                _this5.form = { condition_tarifaire: response.data && response.data.condition_tarifaire ? response.data.condition_tarifaire : "" };
            }, function(error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        saveCondition(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.post(url, {
                condition_tarifaire: _this5.form.condition_tarifaire,
                model_id: _this5.model.id
            }).then(function(response) {
                _this5.$notify({
                    type: 'success',
                    title: `${_this5.$dictionnaire.success}!`,
                    text: response.data.message ? response.data.message : `${_this5.$dictionnaire.success}`
                });
                _this5.is_edit = false;
                return true;
            }).catch(function(errors) {
                _this5.$notify({
                    type: 'error',
                    title: `${_this5.$dictionnaire.error}!`,
                    text: `${_this5.$dictionnaire.error}`
                });
                return false;
            }).finally(() => {
                loading.remove();
            });
        }
    },
    props: [
        'data',
        'url',
        'action',
        'urlbase', 'urlasset',
        'model'
    ]
});