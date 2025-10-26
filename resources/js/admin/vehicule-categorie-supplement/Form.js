import AppForm from '../app-components/Form/AppForm';

Vue.component('vehicule-categorie-supplement-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                tarif:  '' ,
                agence_location_id:  '' ,
                categorie_vehicule_id:  '' ,
                
            }
        }
    }

});