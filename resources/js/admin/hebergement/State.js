import AppListing from '../app-components/Listing/AppListing';

Vue.component('hebergement-state', {
    mixins: [AppListing],
    data: function () {
        return {
            monState: {}
        }
    }, methods: {
        editHebergement(url) {
            var _this5 = this;
            axios.get(url).then(function (response) {
                _this5.$modal.show('edit_hebergement');
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
            });
        }
    }
});