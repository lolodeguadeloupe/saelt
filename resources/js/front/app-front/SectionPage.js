'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

import './helperJquery';
import './eventClick';
import Myform from './helperForm';
import './controleInput';
import Lancheur from './TimeOutFn';

var _moment = require('moment');

var _moment2 = _interopRequireDefault(_moment);

require('moment-timezone');
/** */
var _Pagination = require('./components/Pagination');
var _Pagination2 = _interopRequireDefault(_Pagination);
/** */
var _Sortable = require('./components/Sortable');
var _Sortable2 = _interopRequireDefault(_Sortable);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

export default {
    data: function data() {
        return {
            pagination: {
                state: {
                    per_page: this.$cookie.get('per_page') || 10, // required
                    current_page: 1, // required
                    last_page: 1, // required
                    from: 1,
                    to: 10 // required
                },
                options: {
                    alwaysShowPrevNext: true
                }
            },
            orderBy: {
                column: 'id',
                direction: 'asc'
            },
            filters: {},
            search: '',
            collection: null,
            now: (0, _moment2.default)().tz(this.timezone).format('YYYY-MM-DD HH:mm:ss'),
            datetimePickerConfig: {
                enableTime: true,
                time_24hr: true,
                enableSeconds: true,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd.m.Y H:i:S',
                locale: null,
                inline: true
            },
            dummy: null,
            data_request_customer: {},
            action_search: false,
            launcher: new Lancheur()
        };
    },
    watch: {
        'action_search': function action_search(newVal, oldVal) {
            if (+newVal != +oldVal) {
                $('.section-info-msg').each(function () {
                    $(this).css({ display: 'none' });
                })
            }
        },
    },
    mounted() {
        var _this5 = this;
        $('.form_customer_search').each(function () {
            var _data = {};
            if (_this5.sessionrequest && _this5.sessionrequest.customer_search) {
                for (const key in _this5.sessionrequest.customer_search) {
                    _data[key] = _this5.sessionrequest.customer_search[key];
                }
            }
            Myform(this).setForm({ ..._data });
        });

        /** */
        this.$parent.$on('loadData', function (search) {
            if (!search) return;
            var customer_search = {};
            _this5.data_request_customer = {}
            for (const key in search) {
                customer_search[key] = search[key];
            }
            _this5.data_request_customer['customer_search'] = customer_search;
            _this5.loadData();
        });
        _this5.launcher.lancher(_this5.checkCommande, 30000);
        _this5.fn_detail_image();
    },
    methods: {
        fn_detail_image() {
            var _this5 = this;
            $('.detail-image-modal').on('click', function () {
                if ($(this).attr('src') && $(this).attr('src') != '') {
                    _this5.$detailImage(_this5, $(this).attr('src'));
                } else {
                    $(this).find('img').each(function () {
                        _this5.$detailImage(_this5, $(this).attr('src'));
                    })
                }
            });
        },
        searchData: function (event) {
            var _this5 = this,
                customer_search = {};
            const data = Myform(event.target).serialized();
            if (!data) return;
            _this5.data_request_customer = {}
            for (const key in data) {
                customer_search[key] = data[key];
            }
            _this5.data_request_customer['customer_search'] = customer_search;
            _this5.loadData();
        },
        managerRequest: function managerRequest(event, url, data = {}) {
            var _this5 = this;
            event.preventDefault();
            let loading_ = $(event.target).InputLoadRequest();
            let loading = _this5.$loading();
            axios.post(`${_this5.urlbase}/put-request`, {
                ...data
            }).then(function (response) {
                window.location = `${url}?key_=${response.data.key}`;
            }).catch(function (errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        loadData: function loadData(resetCurrentPage) {
            var _this6 = this;
            const search_data = _this6.$loadingText();
            _this6.action_search = false;
            var options = {
                params: {
                    per_page: this.pagination.state.per_page,
                    page: this.pagination.state.current_page,
                    orderBy: this.orderBy.column,
                    orderDirection: this.orderBy.direction
                }
            };

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
            options.params = { ...options.params, ...my_load_parms, key_: _this6.keysessionrequest };
            if (resetCurrentPage === true) {
                options.params.page = 1;
            }

            Object.assign(options.params, this.filters);

            //let loading = _this6.$loading();

            axios.get(this.url, options).then(function (response) {

                //loading.remove();
                search_data.delete();
                _this6.action_search = true;

                return _this6.populateCurrentStateAndData(response.data.data);

            }, function (error) {
                // TODO handle error
                //loading.remove();
                search_data.delete();
            });
        },
        filter: function filter(column, value) {
            if (value == '') {
                delete this.filters[column];
            } else {
                this.filters[column] = value;
            }
            // when we change filter, we must reset pagination, because the total items count may has changed
            this.loadData(true);
        },
        populateCurrentStateAndData: function populateCurrentStateAndData(object) {
            if (typeof object == 'undefined') return;
            if (object.current_page > object.last_page && object.total > 0) {
                this.pagination.state.current_page = object.last_page;
                this.loadData();
                return;
            }

            this.collection = object.data;
            this.pagination.state.current_page = object.current_page;
            this.pagination.state.last_page = object.last_page;
            this.pagination.state.total = object.total;
            this.pagination.state.per_page = object.per_page;
            this.pagination.state.to = object.to;
            this.pagination.state.from = object.from;
        },
        putCommande(event, commande, data = {}, fn = null) {
            var _this5 = this;
            event.preventDefault();
            let loading = $(event.currentTarget).InputLoadRequest();
            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/put-commande`, {
                commande: commande,
                id: $(event.currentTarget).attr('id-commande'),
                titre: $(event.currentTarget).attr('titre-commande'),
                prix: $(event.currentTarget).attr('reference-prix'),
                image: $(event.currentTarget).attr('image-commande'),
                produit_link: $(event.currentTarget).attr('produit-url'),
                ...data
            }).then(function (response) {
                /** produit command added */
                if (typeof fn == 'function') {
                    fn(response.data);
                }
            }).catch(function (errors) {
                console.log(errors.response.data)
                if (errors.response.data.error_cmd != undefined)
                    _this5.$modal.show('dialog', {
                        title: _this5.$dictionnaire.error_occured,
                        text: `${errors.response.data.error_cmd}`,
                        buttons: [{
                            title: _this5.$dictionnaire.error_occured_btn_confirm,
                            handler: () => {
                                _this5.$modal.hide('dialog');
                                window.location.reload();
                            }
                        }],
                        class: 'alert alert-danger',
                    });
            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        checkCommande(parent) {
            var _this5 = this;
            /*let loading = $(event.currentTarget).InputLoadRequest();*/
            axios.post(`${_this5.urlbase}/check-commande`, {})
                .then(function (response) {
                    _this5.$parent.$emit('changeCountCommande', response.data.commande);
                    if (response.data.commande == 0) {
                        _this5.launcher.clear();
                    } else {
                        _this5.$notify({
                            group: 'notif-product-commande',
                            max: 2,
                            type: 'warn',
                            title: response.data.timeout.title,
                            text: response.data.timeout.message,
                            data: { ...response.data.timeout }
                        });
                    }

                }).catch(function (errors) {

                }).finally(() => {
                    parent.task = 0;
                    /*loading.remove();*/
                });
        },
        getCommande(event, commande, data = {}, callback) {
            var _this5 = this;
            event.preventDefault();
            let loading = $(event.currentTarget).InputLoadRequest();
            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/get-commande`, {
                commande: commande,
                ...data
            }).then(function (response) {
                if (callback && typeof callback == 'function') {
                    callback(response.data);
                }
            }).catch(function (errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        deleteCommande(event, commande, data = {}, callback) {
            var _this5 = this;
            event.preventDefault();
            let loading = $(event.currentTarget).InputLoadRequest();
            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/delete-commande`, {
                commande: commande,
                ...data
            }).then(function (response) {
                if (callback && typeof callback == 'function') {
                    callback(response.data);

                    /** */
                    var count = 0;
                    for (var _panier in response.data) {
                        if (response.data[_panier] != undefined || response.data[_panier] != null) {
                            count = count + response.data[_panier].length;
                        }
                    }
                    _this5.$parent.$emit('changeCountCommande', count);
                }
            }).catch(function (errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        allCommande(event, commande, data = {}, callback) {
            var _this5 = this;
            event.preventDefault();
            let loading = $(event.currentTarget).InputLoadRequest();
            let loading_ = _this5.$loading();
            axios.post(`${_this5.urlbase}/all-commande`, {
                commande: commande,
                ...data
            }).then(function (response) {
                if (callback && typeof callback == 'function') {
                    callback(response.data);
                }
            }).catch(function (errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
    },
    props: {
        'url': {
            type: String,
            required: true
        },
        'urlbase': {
            type: String,
            required: true
        },
        'urlasset': {
            type: String,
            required: true
        },
        'aside': {
            type: Object,
            default: function _default() {
                return null;
            }
        },
        'sessionrequest': {
            type: Object,
            default: function _default() {
                return null;
            }
        },
        'keysessionrequest': {
            type: String,
            default: function _default() {
                return '';
            }
        },
        'data': {
            default: function _default() {
                return null;
            }
        },
        'timezone': {
            type: String,
            required: false,
            default: function _default() {
                return "UTC";
            }
        },
        'trans': {
            required: false,
            default: function _default() {
                return {
                    duplicateDialog: {
                        title: 'Warning!',
                        text: 'Do you really want to duplicate this item?',
                        yes: 'Yes, duplicate.',
                        no: 'No, cancel.',
                        success_title: 'Success!',
                        success: 'Item successfully duplicated.',
                        error_title: 'Error!',
                        error: 'An error has occured.'
                    },
                    deleteDialog: {
                        title: 'Warning!',
                        text: 'Do you really want to delete this item?',
                        yes: 'Yes, delete.',
                        no: 'No, cancel.',
                        success_title: 'Success!',
                        success: 'Item successfully deleted.',
                        error_title: 'Error!',
                        error: 'An error has occured.'
                    }
                };
            }
        }
    },
    filters: {
        date: function date(date) {
            var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'YYYY-MM-DD';

            var date = (0, _moment2.default)(date);
            return date.isValid() ? date.format(format) : "";
        },
        datetime: function datetime(_datetime) {
            var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'YYYY-MM-DD HH:mm:ss';

            var date = (0, _moment2.default)(_datetime);
            return date.isValid() ? date.format(format) : "";
        },
        time: function time(_time) {
            var format = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'HH:mm:ss';

            // '2000-01-01' is here just because momentjs needs a date
            var date = (0, _moment2.default)('2000-01-01 ' + _time);
            return date.isValid() ? date.format(format) : "";
        }
    },
    components: {
        'pagination': _Pagination2.default,
        'sortable': _Sortable2.default,
    },
    created: function created() {
        if (this.data != null) {
            this.populateCurrentStateAndData(this.data);
        } else {
            this.loadData();
        }

        var _this = this;
        setInterval(function () {
            _this.now = (0, _moment2.default)().tz(_this.timezone).format('YYYY-MM-DD HH:mm:ss');
        }, 1000);
    },
};