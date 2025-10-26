import { BaseListing } from 'craftable';
import '../helperJquery';

var _lodash = require('lodash');
var lang = function (lang) {
    var dict = {};
    switch (lang) {
        case 'en':
            dict = {
                'warning': 'Warning',
                'delete_confirm': 'Do you really want to delete',
                'delete_item_confirm': 'Do you really want to delete this item',
                'confirm_no_cancel': 'No, cancel',
                'confirm_yes_delete': 'Yes, delete',
                'item_successful_delete': 'Item successfully deleted',
                'error_occured': 'An error has occured',
                'success': 'Success',
                'error': 'Error',
                'selected_item': 'selected items',
            }
            break;

        case 'fr':
            dict = {
                'warning': 'Avertissement',
                'delete_confirm': 'Voulez-vous vraiment supprimer',
                'delete_item_confirm': 'Voulez-vous vraiment supprimer cet élément',
                'confirm_no_cancel': 'Non, annuler',
                'confirm_yes_delete': 'Oui, supprimer',
                'item_successful': 'Élément supprimé avec succès',
                'error_occured': 'Une erreur s\'est produite',
                'success': 'Succès',
                'error': 'Erreur',
                'selected_item': 'éléments sélectionnés'
            }
            break;
    }
    return dict;
}

export default {
    mixins: [BaseListing],
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
        window.onbeforeunload = function (e) {
            /*_this5.$beforCloseWindow().map(function(data){
                data.call(_this5,[]);
            })*/
        }
    },
    methods: {
        bulkDelete: function bulkDelete(url, callback) {
            var _this5 = this;

            var itemsToDelete = (0, _lodash.keys)((0, _lodash.pickBy)(this.bulkItems));
            var self = this;

            this.$modal.show('dialog', {
                title: `${lang('fr').warning}!`,
                text: `${lang('fr').delete_confirm} ${this.clickedBulkItemsCount} ${lang('fr').selected_item} ?`,
                buttons: [{ title: `${lang('fr').confirm_no_cancel}.` }, {
                    title: `<span class="btn-dialog btn-danger">${lang('fr').confirm_yes_delete}.<span>`,
                    handler: function handler() {
                        _this5.$modal.hide('dialog');
                        axios.post(url, {
                            data: {
                                'ids': itemsToDelete
                            }
                        }).then(function (response) {
                            self.bulkItems = {};
                            if (callback && callback.success)
                                callback.success(response)
                            _this5.loadData();
                            _this5.$notify({ type: 'success', title: `${lang('fr').success}!`, text: response.data.message ? response.data.message : `${lang('fr').item_successful_delete}.` });
                        }, function (error) {
                            if (callback && callback.errors)
                                callback.errors(errors)
                            _this5.$notify({ type: 'error', title: `${lang('fr').error}`, text: error.response.data.message ? error.response.data.message : `${lang('fr').error_occured}.` });
                        });
                    }
                }]
            });
        },
        deleteItem: function deleteItem(url, callback, dialog, reload = true) {
            var _this7 = this;
            var _dialog = {};
            if (dialog) {
                _dialog = {
                    'text': dialog.text,
                    'cancel_title': dialog.cancel_title,
                    'yes_title': dialog.yes_title
                };
            } else {
                _dialog = {
                    'text': `${lang('fr').delete_item_confirm}`,
                    'cancel_title': `${lang('fr').confirm_no_cancel}`,
                    'yes_title': `${lang('fr').confirm_yes_delete}`,
                };
            }

            this.$modal.show('dialog', {
                title: `${lang('fr').warning}!`,
                text: _dialog.text,
                buttons: [{ title: _dialog.cancel_title }, {
                    title: `<span class="btn-dialog btn-danger">${_dialog.yes_title}.<span>`,
                    handler: function handler() {
                        _this7.$modal.hide('dialog');
                        axios.post(`${url}/delete`).then(function (response) {
                            if (callback && callback.success)
                                callback.success(response)
                            if (reload) {
                                _this7.loadData();
                            }
                            _this7.$notify({ type: 'success', title: `${lang('fr').success}!`, text: response.data.message ? response.data.message : `${lang('fr').item_successful_delete}.` });
                        }, function (error) {
                            if (callback && callback.errors)
                                callback.errors(errors)
                            _this7.$notify({ type: 'error', title: `${lang('fr').error}!`, text: error.response.data.message ? error.response.data.message : `${lang('fr').error_occured}.` });
                        }).finally(() => {
                            if (callback && callback.finally)
                                callback.finally()
                        });
                    }
                }]
            });
        },
        loadData: function loadData(resetCurrentPage) {
            var _this6 = this;

            var options = {
                params: {
                    per_page: this.pagination.state.per_page,
                    page: this.pagination.state.current_page,
                    orderBy: this.orderBy.column,
                    orderDirection: this.orderBy.direction,
                }
            };
            var my_load_parms = {}
            for (var i in _this6.data_request_customer ? _this6.data_request_customer : {}) {
                if (_this6.data_request_customer[i] != '') {
                    my_load_parms[i] = _this6.data_request_customer[i];
                }
            }
            options.params = { ...options.params, ...my_load_parms };

            if (resetCurrentPage === true) {
                options.params.page = 1;
            }

            Object.assign(options.params, this.filters);

            axios.get(this.url, options).then(function (response) {
                if (_this6.update_state_data_childre) {
                    _this6.update_state_data_childre(response);
                }
                return _this6.populateCurrentStateAndData(response.data.data);
            }, function (error) {
                // TODO handle error
            });
        },
    }
};