import AppForm from '../app-components/Form/AppForm';

Vue.component('supplement-excursion-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                type_personne_id:  '' ,
                tarif:  '' ,
                
            }
        }
    }

});