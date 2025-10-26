import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('saison-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: {},
            actionEditSaison: '',
            myEvent: {},
            debut_saison: '',
            fin_saison: '',
            min_date: new Date('2000-01-01'),
            max_date: new Date('2000-12-31'),
        }
    },
    mounted() {

        //calendar.headerTitle = "manitra"
    },
    methods: {
        editSaison(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditSaison = response.data.saison.resource_url;
                const d1 = _this5.$parseDate(response.data.saison.debut);
                const d2 = _this5.$parseDate(response.data.saison.fin);
                _this5.debut_saison = new Date(`2000-${d1.getMonth() + 1}-${d1.getDate()}`);
                _this5.fin_saison = new Date(`2000-${d2.getMonth() + 1}-${d2.getDate()}`);
                _this5.$modal.show('edit_saison');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editSaison': function () {
                        var _data = response.data.saison;
                        $('#edit-saison').each(function () {
                            Myform(this).setForm(_data)
                        });
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createSaison(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.myEvent = {
                ..._this5.myEvent, 'createSaison': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_saison');
        },
        storeSaison(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false);
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        formatSaison(_date) {
            if (String(_date) == '') return '';
            _date = moment(_date, 'DD/MM/YYYY');
            const d = new Date(_date);
            return `${String(`0${d.getDate()}`).substr(-2)} ${this.$dictionnaire.short_month[d.getMonth()]}`;
        },
        dateToString(date) {
            if (date == '') return '';
            return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    }, props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});