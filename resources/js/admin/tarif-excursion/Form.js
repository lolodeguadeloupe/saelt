import AppForm from '../app-components/Form/AppForm';

Vue.component('tarif-excursion-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                montant:  '' ,
                excursion_id:  '' ,
                saison_id:  '' ,
                type_personne_id:  '' ,
                
            }
        }
    }

});