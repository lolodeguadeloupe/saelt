import AppForm from '../app-components/Form/AppForm';

Vue.component('vehicule-location-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                immatriculation:  '' ,
                marque:  '' ,
                modele:  '' ,
                status:  '' ,
                description:  '' ,
                date_ouverture:  '' ,
                duration_min:  '' ,
                prestataire_id:  '' ,
                categorie_vehicule_id:  '' ,
                
            }
        }
    }

});