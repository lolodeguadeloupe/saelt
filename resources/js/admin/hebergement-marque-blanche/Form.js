import AppForm from '../app-components/Form/AppForm';

Vue.component('hebergement-marque-blanche-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                liens:  '' ,
                type_hebergement_id:  '' ,
                
            }
        }
    }

});