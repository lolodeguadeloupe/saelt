import AppForm from '../app-components/Form/AppForm';

Vue.component('modele-vehicule-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                description:  '' ,
                
            }
        }
    }

});