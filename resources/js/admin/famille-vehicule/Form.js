import AppForm from '../app-components/Form/AppForm';

Vue.component('famille-vehicule-form', {
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