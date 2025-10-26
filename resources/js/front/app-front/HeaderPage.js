'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

import './helperJquery';
import './eventClick';
import Myform from './helperForm';
import './controleInput';

/** */
var _moment = require('moment');
var _moment2 = _interopRequireDefault(_moment);
require('moment-timezone');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

export default {
    data: function data() {
        return {
            count_commande: this.aside.count_commande && this.aside.count_commande != undefined ? this.aside.count_commande : 0,
        };
    },
    mounted() {
        var _this5 = this;
        /** */
        $('.form_customer_search').each(function() {
            var _data = {};
            if (_this5.sessionrequest && _this5.sessionrequest.customer_search) {
                for (const key in _this5.sessionrequest.customer_search) {
                    _data[key] = _this5.sessionrequest.customer_search[key];
                }
            }
            Myform(this).setForm({..._data });
        });
        //
        _this5.$parent.$on('changeCountCommande', function(count) {
            _this5.count_commande = count;
        })
    },
    methods: {
        hasProduitStatus(){
            var has = false;
            for(var k in this.aside.produit){
                if(this.aside.produit[k].status == 1){
                    has = true;
                }
            }
            return has;
        },
        searchData: function(event) {
            var _this5 = this;
            const data = Myform(event.target).serialized();
            _this5.$parent.$emit('loadData', data);
        },
        managerRequest: function managerRequest(event, url, data = {}) {
            var _this5 = this;
            event.preventDefault();
            let loading_ = $(event.target).InputLoadRequest();
            let loading = _this5.$loading();
            axios.post(`${_this5.urlbase}/put-request`, {
                ...data
            }).then(function(response) {
                window.location = `${url}?key_=${response.data.key}`;
            }).catch(function(errors) {

            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        },
        loadData: function loadData() {
            return;
        }
    },
    props: {
        'url': {
            type: String,
            required: false
        },
        'urlbase': {
            type: String,
            required: false
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
            type: Object,
            default: function _default() {
                return null;
            }
        },
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
};