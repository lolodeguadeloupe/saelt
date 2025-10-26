import AppForm from '../app-components/Form/AppForm';

Vue.component('tarif-transfert-voyage-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                trajet_transfert_voyage_id:  '' ,
                type_personne_id:  '' ,
                prix_achat_aller:  '' ,
                prix_achat_aller_retour:  '' ,
                marge_aller:  '' ,
                marge_aller_retour:  '' ,
                prix_vente_aller:  '' ,
                prix_vente_aller_retour:  '' ,
                
            }
        }
    }

});