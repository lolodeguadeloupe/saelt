import AppForm from '../app-components/Form/AppForm';

Vue.component('tarif-tranche-saison-location-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                marge:  '' ,
                prix_achat:  '' ,
                prix_vente:  '' ,
                tranche_saison_id:  '' ,
                categorie_vehicule_id:  '' ,
                
            }
        }
    }

});