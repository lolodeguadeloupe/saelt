import AppForm from '../app-components/Form/AppForm';

Vue.component('marque-vehicule-form', {
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