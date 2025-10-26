import AppForm from '../app-components/Form/AppForm';

Vue.component('tarif-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                montant:  '' ,
                devise:  '' ,
                chambre_id:  '' ,
                type_personne_id:  '' ,
                
            }
        }
    }

});