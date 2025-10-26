import AppForm from '../app-components/Form/AppForm';

Vue.component('categorie-vehicule-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                description:  '' ,
                famille_vehicule_id:  '' ,
                
            }
        }
    }

});