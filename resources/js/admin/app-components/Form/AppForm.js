import { BaseForm } from 'craftable';
import '../helperJquery';
import '../eventClick';
import Myform from '../helperForm';
import '../controleInput';
import lang from '../lang';
var dict = lang('fr');
export default {
    mixins: [BaseForm],
    data: function () {
        return {
            eventFormSubmit: {}
        }
    },
    mounted() {
        $('.opacity-load-0').each(function () {
            $(this).removeClass('opacity-load-0');
            $('.create-page-load').each(function () {
                $(this).remove();
                $('body').each(function () {
                    $(this).css({ overflow: 'auto' })
                })
            })
        });
    },
    methods: {
        mySubmit: function mySubmit(event, callback, reload = false, data_ = {}, loadData = true) {
            var _this4 = this
            const action = $(event.target).attr('action');
            let loading = $(event.target).InputLoadRequest();
            event.preventDefault();
            const data = Myform(event.target).serialized();
            if (!data) {
                _this4.$notify({
                    type: 'error',
                    title: `${dict.error}!`,
                    text: `${dict.form_error}`
                });
                loading.remove();
                return false;
            }
            axios.post(action, { ...data, ...data_ }).then(function (response) {
                _this4.$notify({
                    type: 'success',
                    title: `${dict.success}!`,
                    text: response.data.message ? response.data.message : `${dict.success}`
                });

                for (const _string in _this4.eventFormSubmit) {
                    if (typeof _string == 'string') {
                        $(event.target).parents(`[data-modal="${_string}"]`).each(function () {
                            $(_this4.eventFormSubmit[_string].form).each(function () {
                                var _data_set = {};
                                if (response.data && typeof $(event.target).attr('data-response') != 'undefined' && response.data[$(event.target).attr('data-response')][_this4.eventFormSubmit[_string]['key']]) {
                                    _data_set[_this4.eventFormSubmit[_string]['inputkey']] = response.data[$(event.target).attr('data-response')][_this4.eventFormSubmit[_string]['key']];
                                }
                                if ((response.data && typeof $(event.target).attr('data-response') != 'undefined' && response.data[$(event.target).attr('data-response')][_this4.eventFormSubmit[_string]['label']])) {
                                    _data_set[_this4.eventFormSubmit[_string]['inputlabel']] = response.data[$(event.target).attr('data-response')][_this4.eventFormSubmit[_string]['label']];
                                }
                                Myform(this).setForm(_data_set);
                                if (typeof _this4.eventFormSubmit[_string]['fnSet'] == 'function' && typeof $(event.target).attr('data-response') != 'undefined') {
                                    _this4.eventFormSubmit[_string]['fnSet'](this, response.data[$(event.target).attr('data-response')]);
                                }
                            })
                        })
                    }
                }
                //console.log(_this4.eventFormSubmit, $(event.target).parents('[data-modal="create_ville"]'), $('[data-modal="create_vile"]'))
                if (callback && callback.success)
                    callback.success(response)
                if (reload) {
                    return _this4.onSuccess(response.data)
                }
                if (loadData)
                    return _this4.loadData();
                return true;
            }).catch(function (errors) {
                _this4.$notify({
                    type: 'error',
                    title: `${dict.error}!`,
                    text: `${dict.error}`
                });
                Myform(event.target).erreur(_this4.getError(errors));
                if (callback && callback.errors)
                    callback.errors(errors)
                return _this4.onFail(errors.response.data);
            }).finally(() => {
                if (loading) {
                    loading.remove();
                }
            });
        },
        getError: function getError(error = {}) {
            if (error.response && error.response.status && error.response.status === 422) {
                return { error: 422, data: error.response.data.errors };
            }
            return { error: error.response.status, data: {} };
        },
        postData: function postData(url, data, callback) {
            var _this4 = this
            axios.post(url, data).then(function (response) {

                if (callback && callback.success)
                    callback.success(response)
                return true;
            }).catch(function (errors) {

                if (callback && callback.errors)
                    callback.errors(errors)
                return true;
            }).finally(() => {
                if (callback && callback.finally)
                    callback.finally()
                return true;
            });
        },
    }
};