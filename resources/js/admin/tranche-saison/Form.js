import AppForm from '../app-components/Form/AppForm';

Vue.component('tranche-saison-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nombre_min:  '' ,
                nombre_max:  '' ,
                saison_id:  '' ,
                
            }
        }
    }

});