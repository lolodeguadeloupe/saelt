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
            collection: []
        };
    },
    beforeUpdate() {

    },
    updated() {

    },
    watch: {

    },
    mounted() {
        var _this5 = this;
        if (_this5.data && _this5.data.data) {
            _this5.collection = [..._this5.data.data];
        }
    },
    methods: {
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
            required: false
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