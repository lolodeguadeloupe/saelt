import AppForm from '../app-components/Form/AppForm';

Vue.component('tranche-personne-transfert-voyage-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                nombre_min:  '' ,
                nombre_max:  '' ,
                type_transfert_id:  '' ,
                
            }
        }
    }

});