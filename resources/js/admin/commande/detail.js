import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';

Vue.component('commande-detail', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            change_form: false
        }
    },
    methods: {
        calculerSupplement(supp = []) {
            var somme = 0;
            supp.map(function (_supp) {
                somme = somme + parseFloat(_supp.prix);
            })
            return somme;
        },
        changeForm(event) {
            const val = event.target.value;
            this.change_form = true;
            this.$promise(function () {
                $(event.target).each(function () {
                    $(this).val(val);
                })
            })
        },
        saveCommande(event) {
            this.mySubmit(event, {
                success: function () {
                    window.location.reload();
                },
                errors: function () {
                }
            }, false, {}, false);
        },
    },
    props: [
        'url',
        'action',
        'urlbase',
        'urlasset',
        'modepayement'
    ]
});