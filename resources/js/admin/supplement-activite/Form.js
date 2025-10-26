import AppForm from '../app-components/Form/AppForm';

Vue.component('supplement-activite-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                description:  '' ,
                tarif:  '' ,
                regle_tarif:  '' ,
                
            }
        }
    }

});